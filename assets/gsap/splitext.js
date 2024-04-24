/*!
 * SplitText 3.11.6
 * https://greensock.com
 *
 * @license Copyright 2023, GreenSock. All rights reserved.
 * *** DO NOT DEPLOY THIS FILE ***
 * This is a trial version that only works locally and on domains like codepen.io and codesandbox.io.
 * Loading it on an unauthorized domain violates the license and will cause a redirect.
 * Get the unrestricted file by joining Club GreenSock at https://greensock.com/club
 * @author: Jack Doyle, jack@greensock.com
 */

!(function (D, u) {
    "object" == typeof exports && "undefined" != typeof module ? u(exports) : "function" == typeof define && define.amd ? define(["exports"], u) : u(((D = D || self).window = D.window || {}));
})(this, function (e) {
    "use strict";
    var S = /([\uD800-\uDBFF][\uDC00-\uDFFF](?:[\u200D\uFE0F][\uD800-\uDBFF][\uDC00-\uDFFF]){2,}|\uD83D\uDC69(?:\u200D(?:(?:\uD83D\uDC69\u200D)?\uD83D\uDC67|(?:\uD83D\uDC69\u200D)?\uD83D\uDC66)|\uD83C[\uDFFB-\uDFFF])|\uD83D\uDC69\u200D(?:\uD83D\uDC69\u200D)?\uD83D\uDC66\u200D\uD83D\uDC66|\uD83D\uDC69\u200D(?:\uD83D\uDC69\u200D)?\uD83D\uDC67\u200D(?:\uD83D[\uDC66\uDC67])|\uD83C\uDFF3\uFE0F\u200D\uD83C\uDF08|(?:\uD83C[\uDFC3\uDFC4\uDFCA]|\uD83D[\uDC6E\uDC71\uDC73\uDC77\uDC81\uDC82\uDC86\uDC87\uDE45-\uDE47\uDE4B\uDE4D\uDE4E\uDEA3\uDEB4-\uDEB6]|\uD83E[\uDD26\uDD37-\uDD39\uDD3D\uDD3E\uDDD6-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2640\u2642]\uFE0F|\uD83D\uDC69(?:\uD83C[\uDFFB-\uDFFF])\u200D(?:\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92])|(?:\uD83C[\uDFC3\uDFC4\uDFCA]|\uD83D[\uDC6E\uDC6F\uDC71\uDC73\uDC77\uDC81\uDC82\uDC86\uDC87\uDE45-\uDE47\uDE4B\uDE4D\uDE4E\uDEA3\uDEB4-\uDEB6]|\uD83E[\uDD26\uDD37-\uDD39\uDD3C-\uDD3E\uDDD6-\uDDDF])\u200D[\u2640\u2642]\uFE0F|\uD83C\uDDFD\uD83C\uDDF0|\uD83C\uDDF6\uD83C\uDDE6|\uD83C\uDDF4\uD83C\uDDF2|\uD83C\uDDE9(?:\uD83C[\uDDEA\uDDEC\uDDEF\uDDF0\uDDF2\uDDF4\uDDFF])|\uD83C\uDDF7(?:\uD83C[\uDDEA\uDDF4\uDDF8\uDDFA\uDDFC])|\uD83C\uDDE8(?:\uD83C[\uDDE6\uDDE8\uDDE9\uDDEB-\uDDEE\uDDF0-\uDDF5\uDDF7\uDDFA-\uDDFF])|(?:\u26F9|\uD83C[\uDFCB\uDFCC]|\uD83D\uDD75)(?:\uFE0F\u200D[\u2640\u2642]|(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2640\u2642])\uFE0F|(?:\uD83D\uDC41\uFE0F\u200D\uD83D\uDDE8|\uD83D\uDC69(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2695\u2696\u2708]|\uD83D\uDC69\u200D[\u2695\u2696\u2708]|\uD83D\uDC68(?:(?:\uD83C[\uDFFB-\uDFFF])\u200D[\u2695\u2696\u2708]|\u200D[\u2695\u2696\u2708]))\uFE0F|\uD83C\uDDF2(?:\uD83C[\uDDE6\uDDE8-\uDDED\uDDF0-\uDDFF])|\uD83D\uDC69\u200D(?:\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92]|\u2764\uFE0F\u200D(?:\uD83D\uDC8B\u200D(?:\uD83D[\uDC68\uDC69])|\uD83D[\uDC68\uDC69]))|\uD83C\uDDF1(?:\uD83C[\uDDE6-\uDDE8\uDDEE\uDDF0\uDDF7-\uDDFB\uDDFE])|\uD83C\uDDEF(?:\uD83C[\uDDEA\uDDF2\uDDF4\uDDF5])|\uD83C\uDDED(?:\uD83C[\uDDF0\uDDF2\uDDF3\uDDF7\uDDF9\uDDFA])|\uD83C\uDDEB(?:\uD83C[\uDDEE-\uDDF0\uDDF2\uDDF4\uDDF7])|[#\*0-9]\uFE0F\u20E3|\uD83C\uDDE7(?:\uD83C[\uDDE6\uDDE7\uDDE9-\uDDEF\uDDF1-\uDDF4\uDDF6-\uDDF9\uDDFB\uDDFC\uDDFE\uDDFF])|\uD83C\uDDE6(?:\uD83C[\uDDE8-\uDDEC\uDDEE\uDDF1\uDDF2\uDDF4\uDDF6-\uDDFA\uDDFC\uDDFD\uDDFF])|\uD83C\uDDFF(?:\uD83C[\uDDE6\uDDF2\uDDFC])|\uD83C\uDDF5(?:\uD83C[\uDDE6\uDDEA-\uDDED\uDDF0-\uDDF3\uDDF7-\uDDF9\uDDFC\uDDFE])|\uD83C\uDDFB(?:\uD83C[\uDDE6\uDDE8\uDDEA\uDDEC\uDDEE\uDDF3\uDDFA])|\uD83C\uDDF3(?:\uD83C[\uDDE6\uDDE8\uDDEA-\uDDEC\uDDEE\uDDF1\uDDF4\uDDF5\uDDF7\uDDFA\uDDFF])|\uD83C\uDFF4\uDB40\uDC67\uDB40\uDC62(?:\uDB40\uDC77\uDB40\uDC6C\uDB40\uDC73|\uDB40\uDC73\uDB40\uDC63\uDB40\uDC74|\uDB40\uDC65\uDB40\uDC6E\uDB40\uDC67)\uDB40\uDC7F|\uD83D\uDC68(?:\u200D(?:\u2764\uFE0F\u200D(?:\uD83D\uDC8B\u200D)?\uD83D\uDC68|(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC66\u200D\uD83D\uDC66|(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC67\u200D(?:\uD83D[\uDC66\uDC67])|\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92])|(?:\uD83C[\uDFFB-\uDFFF])\u200D(?:\uD83C[\uDF3E\uDF73\uDF93\uDFA4\uDFA8\uDFEB\uDFED]|\uD83D[\uDCBB\uDCBC\uDD27\uDD2C\uDE80\uDE92]))|\uD83C\uDDF8(?:\uD83C[\uDDE6-\uDDEA\uDDEC-\uDDF4\uDDF7-\uDDF9\uDDFB\uDDFD-\uDDFF])|\uD83C\uDDF0(?:\uD83C[\uDDEA\uDDEC-\uDDEE\uDDF2\uDDF3\uDDF5\uDDF7\uDDFC\uDDFE\uDDFF])|\uD83C\uDDFE(?:\uD83C[\uDDEA\uDDF9])|\uD83C\uDDEE(?:\uD83C[\uDDE8-\uDDEA\uDDF1-\uDDF4\uDDF6-\uDDF9])|\uD83C\uDDF9(?:\uD83C[\uDDE6\uDDE8\uDDE9\uDDEB-\uDDED\uDDEF-\uDDF4\uDDF7\uDDF9\uDDFB\uDDFC\uDDFF])|\uD83C\uDDEC(?:\uD83C[\uDDE6\uDDE7\uDDE9-\uDDEE\uDDF1-\uDDF3\uDDF5-\uDDFA\uDDFC\uDDFE])|\uD83C\uDDFA(?:\uD83C[\uDDE6\uDDEC\uDDF2\uDDF3\uDDF8\uDDFE\uDDFF])|\uD83C\uDDEA(?:\uD83C[\uDDE6\uDDE8\uDDEA\uDDEC\uDDED\uDDF7-\uDDFA])|\uD83C\uDDFC(?:\uD83C[\uDDEB\uDDF8])|(?:\u26F9|\uD83C[\uDFCB\uDFCC]|\uD83D\uDD75)(?:\uD83C[\uDFFB-\uDFFF])|(?:\uD83C[\uDFC3\uDFC4\uDFCA]|\uD83D[\uDC6E\uDC71\uDC73\uDC77\uDC81\uDC82\uDC86\uDC87\uDE45-\uDE47\uDE4B\uDE4D\uDE4E\uDEA3\uDEB4-\uDEB6]|\uD83E[\uDD26\uDD37-\uDD39\uDD3D\uDD3E\uDDD6-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])|(?:[\u261D\u270A-\u270D]|\uD83C[\uDF85\uDFC2\uDFC7]|\uD83D[\uDC42\uDC43\uDC46-\uDC50\uDC66\uDC67\uDC70\uDC72\uDC74-\uDC76\uDC78\uDC7C\uDC83\uDC85\uDCAA\uDD74\uDD7A\uDD90\uDD95\uDD96\uDE4C\uDE4F\uDEC0\uDECC]|\uD83E[\uDD18-\uDD1C\uDD1E\uDD1F\uDD30-\uDD36\uDDD1-\uDDD5])(?:\uD83C[\uDFFB-\uDFFF])|\uD83D\uDC68(?:\u200D(?:(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC67|(?:(?:\uD83D[\uDC68\uDC69])\u200D)?\uD83D\uDC66)|\uD83C[\uDFFB-\uDFFF])|(?:[\u261D\u26F9\u270A-\u270D]|\uD83C[\uDF85\uDFC2-\uDFC4\uDFC7\uDFCA-\uDFCC]|\uD83D[\uDC42\uDC43\uDC46-\uDC50\uDC66-\uDC69\uDC6E\uDC70-\uDC78\uDC7C\uDC81-\uDC83\uDC85-\uDC87\uDCAA\uDD74\uDD75\uDD7A\uDD90\uDD95\uDD96\uDE45-\uDE47\uDE4B-\uDE4F\uDEA3\uDEB4-\uDEB6\uDEC0\uDECC]|\uD83E[\uDD18-\uDD1C\uDD1E\uDD1F\uDD26\uDD30-\uDD39\uDD3D\uDD3E\uDDD1-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])?|(?:[\u231A\u231B\u23E9-\u23EC\u23F0\u23F3\u25FD\u25FE\u2614\u2615\u2648-\u2653\u267F\u2693\u26A1\u26AA\u26AB\u26BD\u26BE\u26C4\u26C5\u26CE\u26D4\u26EA\u26F2\u26F3\u26F5\u26FA\u26FD\u2705\u270A\u270B\u2728\u274C\u274E\u2753-\u2755\u2757\u2795-\u2797\u27B0\u27BF\u2B1B\u2B1C\u2B50\u2B55]|\uD83C[\uDC04\uDCCF\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE1A\uDE2F\uDE32-\uDE36\uDE38-\uDE3A\uDE50\uDE51\uDF00-\uDF20\uDF2D-\uDF35\uDF37-\uDF7C\uDF7E-\uDF93\uDFA0-\uDFCA\uDFCF-\uDFD3\uDFE0-\uDFF0\uDFF4\uDFF8-\uDFFF]|\uD83D[\uDC00-\uDC3E\uDC40\uDC42-\uDCFC\uDCFF-\uDD3D\uDD4B-\uDD4E\uDD50-\uDD67\uDD7A\uDD95\uDD96\uDDA4\uDDFB-\uDE4F\uDE80-\uDEC5\uDECC\uDED0-\uDED2\uDEEB\uDEEC\uDEF4-\uDEF8]|\uD83E[\uDD10-\uDD3A\uDD3C-\uDD3E\uDD40-\uDD45\uDD47-\uDD4C\uDD50-\uDD6B\uDD80-\uDD97\uDDC0\uDDD0-\uDDE6])|(?:[#\*0-9\xA9\xAE\u203C\u2049\u2122\u2139\u2194-\u2199\u21A9\u21AA\u231A\u231B\u2328\u23CF\u23E9-\u23F3\u23F8-\u23FA\u24C2\u25AA\u25AB\u25B6\u25C0\u25FB-\u25FE\u2600-\u2604\u260E\u2611\u2614\u2615\u2618\u261D\u2620\u2622\u2623\u2626\u262A\u262E\u262F\u2638-\u263A\u2640\u2642\u2648-\u2653\u2660\u2663\u2665\u2666\u2668\u267B\u267F\u2692-\u2697\u2699\u269B\u269C\u26A0\u26A1\u26AA\u26AB\u26B0\u26B1\u26BD\u26BE\u26C4\u26C5\u26C8\u26CE\u26CF\u26D1\u26D3\u26D4\u26E9\u26EA\u26F0-\u26F5\u26F7-\u26FA\u26FD\u2702\u2705\u2708-\u270D\u270F\u2712\u2714\u2716\u271D\u2721\u2728\u2733\u2734\u2744\u2747\u274C\u274E\u2753-\u2755\u2757\u2763\u2764\u2795-\u2797\u27A1\u27B0\u27BF\u2934\u2935\u2B05-\u2B07\u2B1B\u2B1C\u2B50\u2B55\u3030\u303D\u3297\u3299]|\uD83C[\uDC04\uDCCF\uDD70\uDD71\uDD7E\uDD7F\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE02\uDE1A\uDE2F\uDE32-\uDE3A\uDE50\uDE51\uDF00-\uDF21\uDF24-\uDF93\uDF96\uDF97\uDF99-\uDF9B\uDF9E-\uDFF0\uDFF3-\uDFF5\uDFF7-\uDFFF]|\uD83D[\uDC00-\uDCFD\uDCFF-\uDD3D\uDD49-\uDD4E\uDD50-\uDD67\uDD6F\uDD70\uDD73-\uDD7A\uDD87\uDD8A-\uDD8D\uDD90\uDD95\uDD96\uDDA4\uDDA5\uDDA8\uDDB1\uDDB2\uDDBC\uDDC2-\uDDC4\uDDD1-\uDDD3\uDDDC-\uDDDE\uDDE1\uDDE3\uDDE8\uDDEF\uDDF3\uDDFA-\uDE4F\uDE80-\uDEC5\uDECB-\uDED2\uDEE0-\uDEE5\uDEE9\uDEEB\uDEEC\uDEF0\uDEF3-\uDEF8]|\uD83E[\uDD10-\uDD3A\uDD3C-\uDD3E\uDD40-\uDD45\uDD47-\uDD4C\uDD50-\uDD6B\uDD80-\uDD97\uDDC0\uDDD0-\uDDE6])\uFE0F)/;
    function m(D) {
        (U = document), (i = window), (s = s || D || i.gsap || console.warn("Please gsap.registerPlugin(SplitText)")) && ((d = s.utils.toArray), (r = s.core.context || function () {}), (n = 1));
    }
    function p() {
        return String.fromCharCode.apply(null, arguments);
    }
    function t(D) {
        return i.getComputedStyle(D);
    }
    function u(D) {
        return "absolute" === D.position || !0 === D.absolute;
    }
    function v(D, u) {
        for (var e, t = u.length; -1 < --t; ) if (((e = u[t]), D.substr(0, e.length) === e)) return e.length;
    }
    function x(D, u) {
        void 0 === D && (D = "");
        var e = ~D.indexOf("++"),
            t = 1;
        return (
            e && (D = D.split("++").join("")),
                function () {
                    return "<" + u + " style='position:relative;display:inline-block;'" + (D ? " class='" + D + (e ? t++ : "") + "'>" : ">");
                }
        );
    }
    function y(D, u, e) {
        var t = D.nodeType;
        if (1 === t || 9 === t || 11 === t) for (D = D.firstChild; D; D = D.nextSibling) y(D, u, e);
        else (3 !== t && 4 !== t) || (D.nodeValue = D.nodeValue.split(u).join(e));
    }
    function z(D, u) {
        for (var e = u.length; -1 < --e; ) D.push(u[e]);
    }
    function A(D, u, e) {
        for (var t; D && D !== u; ) {
            if ((t = D._next || D.nextSibling)) return t.textContent.charAt(0) === e;
            D = D.parentNode || D._parent;
        }
    }
    function B(D) {
        var u,
            e,
            t = d(D.childNodes),
            F = t.length;
        for (u = 0; u < F; u++)
            (e = t[u])._isSplit
                ? B(e)
                : u && e.previousSibling && 3 === e.previousSibling.nodeType
                ? ((e.previousSibling.nodeValue += 3 === e.nodeType ? e.nodeValue : e.firstChild.nodeValue), D.removeChild(e))
                : 3 !== e.nodeType && (D.insertBefore(e.firstChild, e), D.removeChild(e));
    }
    function C(D, u) {
        return parseFloat(u[D]) || 0;
    }
    function D(D, e, F, i, n, s, E) {
        var r,
            o,
            l,
            p,
            d,
            a,
            h,
            f,
            c,
            g,
            x,
            v,
            S = t(D),
            _ = C("paddingLeft", S),
            b = -999,
            w = C("borderBottomWidth", S) + C("borderTopWidth", S),
            m = C("borderLeftWidth", S) + C("borderRightWidth", S),
            T = C("paddingTop", S) + C("paddingBottom", S),
            N = C("paddingLeft", S) + C("paddingRight", S),
            L = C("fontSize", S) * (e.lineThreshold || 0.2),
            W = S.textAlign,
            O = [],
            H = [],
            j = [],
            k = e.wordDelimiter || " ",
            V = e.tag ? e.tag : e.span ? "span" : "div",
            M = e.type || e.split || "chars,words,lines",
            R = n && ~M.indexOf("lines") ? [] : null,
            P = ~M.indexOf("words"),
            $ = ~M.indexOf("chars"),
            q = u(e),
            G = e.linesClass,
            I = ~(G || "").indexOf("++"),
            J = [],
            K = "flex" === S.display,
            Q = D.style.display;
        for (I && (G = G.split("++").join("")), K && (D.style.display = "block"), l = (o = D.getElementsByTagName("*")).length, d = [], r = 0; r < l; r++) d[r] = o[r];
        if (R || q)
            for (r = 0; r < l; r++)
                ((a = (p = d[r]).parentNode === D) || q || ($ && !P)) &&
                ((v = p.offsetTop),
                R && a && Math.abs(v - b) > L && ("BR" !== p.nodeName || 0 === r) && ((h = []), R.push(h), (b = v)),
                q && ((p._x = p.offsetLeft), (p._y = v), (p._w = p.offsetWidth), (p._h = p.offsetHeight)),
                R &&
                (((p._isSplit && a) || (!$ && a) || (P && a) || (!P && p.parentNode.parentNode === D && !p.parentNode._isSplit)) && (h.push(p), (p._x -= _), A(p, D, k) && (p._wordEnd = !0)),
                "BR" === p.nodeName && ((p.nextSibling && "BR" === p.nextSibling.nodeName) || 0 === r) && R.push([])));
        for (r = 0; r < l; r++)
            if (((a = (p = d[r]).parentNode === D), "BR" !== p.nodeName))
                if (
                    (q &&
                    ((c = p.style),
                    P || a || ((p._x += p.parentNode._x), (p._y += p.parentNode._y)),
                        (c.left = p._x + "px"),
                        (c.top = p._y + "px"),
                        (c.position = "absolute"),
                        (c.display = "block"),
                        (c.width = p._w + 1 + "px"),
                        (c.height = p._h + "px")),
                    !P && $)
                )
                    if (p._isSplit) for (p._next = o = p.nextSibling, p.parentNode.appendChild(p); o && 3 === o.nodeType && " " === o.textContent; ) (p._next = o.nextSibling), p.parentNode.appendChild(o), (o = o.nextSibling);
                    else
                        p.parentNode._isSplit
                            ? ((p._parent = p.parentNode),
                            !p.previousSibling && p.firstChild && (p.firstChild._isFirst = !0),
                            p.nextSibling && " " === p.nextSibling.textContent && !p.nextSibling.nextSibling && J.push(p.nextSibling),
                                (p._next = p.nextSibling && p.nextSibling._isFirst ? null : p.nextSibling),
                                p.parentNode.removeChild(p),
                                d.splice(r--, 1),
                                l--)
                            : a ||
                            ((v = !p.nextSibling && A(p.parentNode, D, k)),
                            p.parentNode._parent && p.parentNode._parent.appendChild(p),
                            v && p.parentNode.appendChild(U.createTextNode(" ")),
                            "span" === V && (p.style.display = "inline"),
                                O.push(p));
                else p.parentNode._isSplit && !p._isSplit && "" !== p.innerHTML ? H.push(p) : $ && !p._isSplit && ("span" === V && (p.style.display = "inline"), O.push(p));
            else R || q ? (p.parentNode && p.parentNode.removeChild(p), d.splice(r--, 1), l--) : P || D.appendChild(p);
        for (r = J.length; -1 < --r; ) J[r].parentNode.removeChild(J[r]);
        if (R) {
            for (q && ((g = U.createElement(V)), D.appendChild(g), (x = g.offsetWidth + "px"), (v = g.offsetParent === D ? 0 : D.offsetLeft), D.removeChild(g)), c = D.style.cssText, D.style.cssText = "display:none;"; D.firstChild; )
                D.removeChild(D.firstChild);
            for (f = " " === k && (!q || (!P && !$)), r = 0; r < R.length; r++) {
                for (h = R[r], (g = U.createElement(V)).style.cssText = "display:block;text-align:" + W + ";position:" + (q ? "absolute;" : "relative;"), G && (g.className = G + (I ? r + 1 : "")), j.push(g), l = h.length, o = 0; o < l; o++)
                    "BR" !== h[o].nodeName &&
                    ((p = h[o]),
                        g.appendChild(p),
                    f && p._wordEnd && g.appendChild(U.createTextNode(" ")),
                    q && (0 === o && ((g.style.top = p._y + "px"), (g.style.left = _ + v + "px")), (p.style.top = "0px"), v && (p.style.left = p._x - v + "px")));
                0 === l ? (g.innerHTML = "&nbsp;") : P || $ || (B(g), y(g, String.fromCharCode(160), " ")), q && ((g.style.width = x), (g.style.height = p._h + "px")), D.appendChild(g);
            }
            D.style.cssText = c;
        }
        q && (E > D.clientHeight && ((D.style.height = E - T + "px"), D.clientHeight < E && (D.style.height = E + w + "px")), s > D.clientWidth && ((D.style.width = s - N + "px"), D.clientWidth < s && (D.style.width = s + m + "px"))),
        K && (Q ? (D.style.display = Q) : D.style.removeProperty("display")),
            z(F, O),
        P && z(i, H),
            z(n, j);
    }
    function E(D, e, t, F) {
        var i,
            C,
            n,
            s,
            E,
            r,
            o,
            l,
            p = e.tag ? e.tag : e.span ? "span" : "div",
            d = ~(e.type || e.split || "chars,words,lines").indexOf("chars"),
            a = u(e),
            h = e.wordDelimiter || " ",
            f = " " !== h ? "" : a ? "&#173; " : " ",
            B = "</" + p + ">",
            c = 1,
            A = e.specialChars ? ("function" == typeof e.specialChars ? e.specialChars : v) : null,
            g = U.createElement("div"),
            x = D.parentNode;
        for (
            x.insertBefore(g, D),
                g.textContent = D.nodeValue,
                x.removeChild(D),
                o =
                    -1 !==
                    (i = (function getText(D) {
                        var u = D.nodeType,
                            e = "";
                        if (1 === u || 9 === u || 11 === u) {
                            if ("string" == typeof D.textContent) return D.textContent;
                            for (D = D.firstChild; D; D = D.nextSibling) e += getText(D);
                        } else if (3 === u || 4 === u) return D.nodeValue;
                        return e;
                    })((D = g))).indexOf("<"),
            !1 !== e.reduceWhiteSpace && (i = i.replace(b, " ").replace(_, "")),
            o && (i = i.split("<").join("{{LT}}")),
                E = i.length,
                C = (" " === i.charAt(0) ? f : "") + t(),
                n = 0;
            n < E;
            n++
        )
            if (((r = i.charAt(n)), A && (l = A(i.substr(n), e.specialChars)))) (r = i.substr(n, l || 1)), (C += d && " " !== r ? F() + r + "</" + p + ">" : r), (n += l - 1);
            else if (r === h && i.charAt(n - 1) !== h && n) {
                for (C += c ? B : "", c = 0; i.charAt(n + 1) === h; ) (C += f), n++;
                n === E - 1 ? (C += f) : ")" !== i.charAt(n + 1) && ((C += f + t()), (c = 1));
            } else
                "{" === r && "{{LT}}" === i.substr(n, 6)
                    ? ((C += d ? F() + "{{LT}}</" + p + ">" : "{{LT}}"), (n += 5))
                    : (55296 <= r.charCodeAt(0) && r.charCodeAt(0) <= 56319) || (65024 <= i.charCodeAt(n + 1) && i.charCodeAt(n + 1) <= 65039)
                    ? ((s = ((i.substr(n, 12).split(S) || [])[1] || "").length || 2), (C += d && " " !== r ? F() + i.substr(n, s) + "</" + p + ">" : i.substr(n, s)), (n += s - 1))
                    : (C += d && " " !== r ? F() + r + "</" + p + ">" : r);
        (D.outerHTML = C + (c ? B : "")), o && y(x, "{{LT}}", "<");
    }
    function F(D, e, i, C) {
        var n,
            s,
            r = d(D.childNodes),
            o = r.length,
            l = u(e);
        if (3 !== D.nodeType || 1 < o) {
            for (e.absolute = !1, n = 0; n < o; n++)
                ((s = r[n])._next = s._isFirst = s._parent = s._wordEnd = null),
                (3 === s.nodeType && !/\S+/.test(s.nodeValue)) || (l && 3 !== s.nodeType && "inline" === t(s).display && ((s.style.display = "inline-block"), (s.style.position = "relative")), (s._isSplit = !0), F(s, e, i, C));
            return (e.absolute = l), void (D._isSplit = !0);
        }
        E(D, e, i, C);
    }
    var U,
        i,
        n,
        s,
        r,
        d,
        o,
        _ = /(?:\r|\n|\t\t)/g,
        b = /(?:\s\s+)/g,
        l = "SplitText",
        a = p(103, 114, 101, 101, 110, 115, 111, 99, 107, 46, 99, 111, 109),
        h = /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}:?\d*$/,
  f = 'undefined',
        c =
            (((o = SplitText.prototype).split = function split(u) {
                this.isSplit && this.revert(), (this.vars = u = u || this.vars), (this._originals.length = this.chars.length = this.words.length = this.lines.length = 0);
                for (var e, t, i, C = this.elements.length, n = u.tag ? u.tag : u.span ? "span" : "div", s = x(u.wordsClass, n), E = x(u.charsClass, n); -1 < --C; )
                    (i = this.elements[C]), (this._originals[C] = i.innerHTML), (e = i.clientHeight), (t = i.clientWidth), F(i, u, s, E), D(i, u, this.chars, this.words, this.lines, t, e);
                return this.chars.reverse(), this.words.reverse(), this.lines.reverse(), (this.isSplit = !0), this;
            }),
                (o.revert = function revert() {
                    var e = this._originals;
                    if (!e) throw "revert() call wasn't scoped properly.";
                    return (
                        this.elements.forEach(function (D, u) {
                            return (D.innerHTML = e[u]);
                        }),
                            (this.chars = []),
                            (this.words = []),
                            (this.lines = []),
                            (this.isSplit = !1),
                            this
                    );
                }),
                (SplitText.create = function create(D, u) {
                    return new SplitText(D, u);
                }),
                SplitText);
    function SplitText(D, u) {
        n || m(), (this.elements = d(D)), (this.chars = []), (this.words = []), (this.lines = []), (this._originals = []), (this.vars = u || {}), r(this), f && this.split(u);
    }
    (c.version = "3.11.6"), (c.register = m), (e.SplitText = c), (e.default = c);
    if (typeof window === "undefined" || window !== e) {
        Object.defineProperty(e, "__esModule", { value: !0 });
    } else {
        delete e.default;
    }
});
