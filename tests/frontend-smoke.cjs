// Run with Node and jsdom available (NODE_PATH may point to an external tool directory).
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { JSDOM } = require('jsdom');
const root = path.resolve(__dirname, '..');
const jquery = fs.readFileSync(process.env.GRIT_JQUERY_PATH || path.resolve(root, '../../../wp-includes/js/jquery/jquery.js'), 'utf8');
const code = fs.readFileSync(path.join(root, 'assets/js/custom.js'), 'utf8');

async function scenario({ observer = true, reduced = false, libraries = false } = {}) {
    const dom = new JSDOM(`<!doctype html><html><body class="loaded"><main id="content" class="main">
        <div id="blank" class="in__animate"></div>
        <div id="valid" class="in__animate" data-animation="animate__fadeInUp\t animate__slow"></div>
        <a id="link" href="/next">Next</a><button class="btn">Button</button>
        <script id="nprogress-js"></script><script id="magic-mouse-js"></script>
    </main></body></html>`, { url: 'https://example.test/', runScripts: 'outside-only', pretendToBeVisual: true });
    const w = dom.window;
    const errors = [];
    w.addEventListener('error', event => errors.push(event.error));
    const listeners = [];
    w.matchMedia = () => ({ matches: reduced, addEventListener: (_, callback) => listeners.push(callback) });
    const observed = new Set();
    let reveal;
    if (observer) w.IntersectionObserver = class {
        constructor(callback) { reveal = callback; }
        observe(element) { observed.add(element); }
        unobserve(element) { observed.delete(element); }
        disconnect() { observed.clear(); }
    };
    let mouse = 0, progress = 0;
    if (libraries) {
        w.magicMouse = () => mouse++;
        w.NProgress = { start: () => progress++, done() {} };
    }
    w.eval(jquery); w.jQuery.noConflict(); w.eval(code);
    await new Promise(resolve => w.jQuery(resolve));
    await new Promise(resolve => setTimeout(resolve, 10));
    assert.equal(errors.length, 0, 'optional libraries must not crash initialization');
    assert.equal(w.document.getElementById('blank').classList.contains('hidden'), false, 'missing animation remains readable');
    const valid = w.document.getElementById('valid');
    if (!observer || reduced) assert.equal(valid.classList.contains('hidden'), false);
    else {
        assert.equal(valid.classList.contains('hidden'), true);
        reveal([{ target: valid, isIntersecting: true }]);
        assert.equal(valid.classList.contains('hidden'), false);
        assert.equal(valid.classList.contains('animate__slow'), true, 'whitespace-delimited tokens work');
        assert.equal(observed.size, 0, 'finished entrances release observers');
        valid.classList.add('hidden');
        listeners.forEach(listener => listener({ matches: true }));
        assert.equal(valid.classList.contains('hidden'), false, 'changed motion preference reveals pending content');
    }
    const link = w.jQuery('#link');
    for (const modifier of ['ctrlKey', 'metaKey', 'shiftKey', 'altKey']) {
        const event = w.jQuery.Event('click', { button: 0, [modifier]: true });
        link.triggerHandler(event);
        assert.equal(event.isDefaultPrevented(), false, modifier);
    }
    const regular = w.jQuery.Event('click', { button: 0 });
    link.triggerHandler(regular);
    assert.equal(regular.isDefaultPrevented(), true, 'ordinary navigation still uses loader');
    for (const name of ['options', 'nprogress_active', 'lightbox_nivo_active']) assert.equal(name in w, false, 'no leaked global: ' + name);
    if (libraries) {
        assert.equal(mouse, 1); assert.equal(progress, 1);
        assert(w.document.querySelector('.btn').classList.contains('magic-hover__square'));
    }
    dom.window.close();
}
(async () => {
    await scenario();
    await scenario({ observer: false });
    await scenario({ reduced: true });
    await scenario({ libraries: true });
    console.log('PASS frontend: motion fallbacks, optional libraries, scoped variables and modified links');
})().catch(error => { console.error(error); process.exitCode = 1; });
