# GRIT Theme — Guida completa

[Guida in inglese](GUIDE.md) · [README in inglese](README.md)

Manuale operativo dello starter, con campi, classi e comportamenti dei componenti. Per installazione e primo avvio consultare [README_IT.md](README_IT.md).

Gli esempi di classi vanno inseriti nei campi indicati, separati da spazi. ID media, slug, tipi di contenuto e nomi delle agenzie negli esempi vanno adattati al progetto. Il manuale descrive le funzioni implementate: la presenza di una libreria in elenco non crea da sola un nuovo componente.

## Da dove iniziare: personalizzazioni frequenti

I percorsi della tabella sono relativi al tema parent; quelli indicati come **child** appartengono al tema child attivo. Parti dal risultato da ottenere e consulta il capitolo completo solo quando serve.

| Voglio modificare… | Dove intervenire | Approfondimento |
| --- | --- | --- |
| **Colori** | `assets/css/_variables.scss`: palette `$accent`, `$primary`, `$secondary`, `$light`, `$dark`. Per assegnare colori ai contenuti usa prima le classi `bg-*` e `color-*` nei campi ACF. | [Colori e SCSS](#colori-scss-e-personalizzazione) |
| **Font** | `assets/css/_variables.scss`: caricamento del font, `$font-primary`, `$font-secondary` e `$font-base`; regole tipografiche in `_typography.scss`. Il campo Google Fonts di Personalizza carica il font, ma non lo assegna automaticamente agli elementi: aggiornare anche le famiglie usate dagli stili. | [Pulsanti e caratteri](#pulsanti-e-caratteri) |
| **Pulsanti** | Nei campi ACF scegli testo, link e classi. Dimensioni e angoli: variabili `$button-*` in `_variables.scss`; combinazioni di colori: regole `.btn-*` in `_typography.scss`; markup condiviso: `templates/partials/buttons.twig`. | [Pulsanti condivisi](#pulsanti-condivisi) |
| **Spaziature** | Prima usa classi come `py-5`, `mb-4`, `gap-*` dove previste dal layout. Per le utility aggiuntive del tema consulta `$extra-spacing-values` in `_variables.scss` e la loro generazione in `_content.scss`. | [Campi comuni e colonne](#campi-comuni-e-colonne) |
| **Header e footer** | Scegli la variante in Personalizza e assegna i menu da Aspetto → Menu. Modifica il relativo Twig in `templates/headers/` o `templates/footers/`; gli stili sono in `_header.scss` e `_footer.scss`. | [Header, footer, menu e form](#header-footer-menu-e-form) |
| **Una Section** | Prima modifica contenuti, colonne e classi nei campi ACF della pagina. Per cambiare il markup apri `templates/sections/section_NOME.twig`, segui gli eventuali partial inclusi e modifica gli stili in `_sections.scss`. Il wrapper comune è `templates/sections/section.twig`: riguarda più layout. | [Section Text come esempio](#section-text) |
| **CSS nel child** | Scrivi nel `style.css` del child: il suo `functions.php` lo carica già dopo gli stili del parent. Copiare un partial SCSS nel child non modifica automaticamente il CSS compilato del parent. | [Colori e SCSS](#colori-scss-e-personalizzazione) |
| **JavaScript nel child** | Il child distribuito non carica un JS personalizzato. Aggiungi il caricamento nel suo `functions.php`, tramite `wp_enqueue_scripts` dopo il parent (priorità 120), usando l’URL del child e l’handle `scripts` come dipendenza se il codice deve seguire `custom.js`. Per poche istruzioni puoi usare `wp_add_inline_script('scripts', …, 'after')` nello stesso hook, senza un file aggiuntivo. | [Percorso delle librerie](#percorso-breve-opzione--caricamento--inizializzazione) |

**Dopo una modifica SCSS**, compila `assets/css/main.scss` in `assets/css/main.css`: modificare soltanto il sorgente non aggiorna il sito. Per il CSS scritto direttamente nel `style.css` del child non serve compilazione. Verifica il risultato su desktop e mobile; per gli script controlla anche la console del browser.

## Indice

- [Personalizzazioni frequenti](#da-dove-iniziare-personalizzazioni-frequenti)
- [Metodo di lavoro](#metodo-di-lavoro)
- [Struttura dei file](#struttura-dei-file)
- [Plugin e librerie](#plugin-e-librerie)
- [Campi comuni e colonne](#campi-comuni-e-colonne)
- [Section Page e contenuti riutilizzabili](#section-page-e-contenuti-riutilizzabili)
- [Section Text](#section-text)
- [Section Gallery](#section-gallery)
- [Section Collapse](#section-collapse)
- [Section Archive](#section-archive)
- [Section Slides](#section-slides)
- [Section Cube](#section-cube)
- [Section Maps](#section-maps)
- [Effetti GSAP e barre](#effetti-gsap-e-barre)
- [Caroselli Owl condivisi](#caroselli-owl-condivisi)
- [Pulsanti condivisi](#pulsanti-condivisi)
- [Shortcode Contacts](#shortcode-contacts)
- [Shortcode Counter](#shortcode-counter)
- [Shortcode Video](#shortcode-video)
- [Card Tease](#card-tease)
- [Archivi WordPress e ricerca](#archivi-wordpress-e-ricerca)
- [Header footer menu e form](#header-footer-menu-e-form)
- [Colori SCSS e personalizzazione](#colori-scss-e-personalizzazione)
- [Branding dell’agenzia](#branding-dellagenzia)
- [SEO consenso servizi esterni e integrazioni](#seo-consenso-servizi-esterni-e-integrazioni)
- [Aggiornamenti controlli e risoluzione problemi](#aggiornamenti-controlli-e-risoluzione-problemi)
- [Licenze](#licenze)

## Metodo di lavoro

GRIT è una base per realizzare progetti personalizzati, con contenuti gestiti tramite ACF e presentazione in Twig. L’agenzia definisce layout e possibilità; il cliente compila i campi predisposti.

Usare prima le classi Bootstrap e le opzioni già disponibili. Per una pagina di presentazione non serve creare un foglio di stile specifico se la composizione si ottiene con le section. Separare i dati dai template: query e preparazione in PHP, presentazione in Twig, stili in SCSS.

La homepage usa i contenuti della pagina impostata in Lettura. Il setup crea le pagine iniziali, ma non una composizione dimostrativa: per trasferire un layout occorrono anche contenuti ACF e media, rimappando gli ID quando necessario.

Per i requisiti e l’installazione consultare `README_IT.md`; per campi, classi e personalizzazione usare questa guida. Mantenere entrambi i documenti coerenti con il progetto. Se si pubblicano pagine guida in WordPress, usare le stesse istruzioni e affiancarle a esempi ACF. Il CPT `section` deve essere registrato dal progetto, per esempio tramite ACF: l’import dei gruppi in `core/acf-fields.json` non registra CPT o tassonomie.

## Struttura dei file

Tutti i percorsi qui indicati sono relativi alla cartella del tema.

| File o cartella | Responsabilità |
| --- | --- |
| `functions.php` | Include dei moduli core, avvio Composer/Timber, contesto condiviso e selezione agenzia. |
| `page.php`, `single.php`, `archive.php`, `search.php`, `author.php`, `index.php`, `404.php` | Controller della gerarchia WordPress: raccolgono contesto e scelgono i Twig. |
| `templates/base.twig` | Struttura comune, header, contenuto, footer e hook WordPress. |
| `templates/home.twig`, `page.twig`, `single.twig`, `archive.twig`, `search.twig`, `author.twig` | Presentazione delle diverse viste. |
| `templates/sections/` | Rendering dei layout ACF. `section.twig` è il wrapper comune. |
| `templates/partials/sections.twig` | Unico rendering delle section locali e dei richiami Section Page. |
| `templates/partials/grid-classes.twig` | Colonne condivise dei capitoli e delle card. |
| `templates/partials/` | Pulsanti, card, immagini, video, paginazione e altri componenti riutilizzabili. |
| `templates/headers/`, `templates/footers/` | Layout separati, modificabili individualmente. |
| `core/init.php` | Supporti WordPress, menu e aree widget. |
| `core/config.php`, `core/scripts.php` | Opzioni delle librerie e caricamento effettivo degli asset. |
| `core/customizer.php`, `core/admin-customizer.php` | Personalizza, branding e strumenti amministrativi. |
| `core/activation.php`, `core/plugins.php` | Setup iniziale e registrazione plugin TGMPA. |
| `core/extras.php` | Shortcode, helper immagini, branding, archivi, ACF, contenuti e Maps. |
| `core/acf-fields.json` | Definizioni ACF distribuite con il tema. |
| `assets/css/main.scss`, `main.css` | Entrata Sass e risultato compilato. |
| `assets/css/_variables.scss` | Valori centralizzati di stile e breakpoint. |
| `assets/js/custom.js` | Controller frontend condivisi, Owl, Masonry, counter, video e GSAP. |
| `assets/js/maps.js`, `assets/maps/style.json` | Controller e stile della cartografia. |
| `assets/credits/` | Dati e immagini del branding agenzia. |

L’elenco `$grit_includes` in `functions.php` stabilisce quali moduli sono caricati. La presenza di un file non implica che sia attivo: in particolare verificare l’include opzionale di WooCommerce prima di usarne le funzioni. L’include WooCommerce attualmente commentato non viene attivato dal solo contenuto della relativa cartella.

I commenti `GRIT_SET` identificano le sezioni principali del codice. Mantenere commenti descrittivi coerenti e aggiornati; i file delle librerie conservano le proprie intestazioni e licenze.

### Orientarsi in core/extras.php

L’indice iniziale raggruppa le funzioni per responsabilità e i commenti indicano i Twig o i controller che le utilizzano. Cerca il numero `GRIT_SET` per raggiungere il blocco desiderato.

| Personalizzazione | Sezioni da consultare |
| --- | --- |
| Branding agenzia e crediti | 03; i dati dell’agenzia sono in `assets/credits/credits.json`. |
| Immagini responsive di Text e Gallery | 05; per cambiare la struttura visiva intervenire nei relativi Twig. |
| Shortcode counter, contatti e video | 06–08; stili in `_shortcodes.scss`, comportamento in `custom.js`. |
| Integrazione ACF Maps e tag del modulo CF7 | 10 e 12. |
| Opzioni e risultati di Section Archive | 14–15: campi ACF, query dei post, termini ed estratti delle card. |
| Risultati degli archivi nativi WordPress | 16: è una query diversa dalle liste inserite con Section Archive. |
| Dati passati dai controller ai Twig | 17: campi ACF, contenuti formattati e paginazione. |
| Dati delle mappe nel frontend | 18; struttura in `section_maps.twig`, interazioni in `maps.js`. |
| Individuazione delle policy e relativi link | 19; il layout della pagina dipende dallo slug. |

Per modificare l’aspetto di una card, un pulsante o una sezione partire dal Twig/SCSS indicato, non dagli helper PHP.

## Plugin e librerie

### Plugin WordPress

Il riferimento effettivo è `core/plugins.php`. TGMPA propone installazione/attivazione e mostra gli avvisi; non sostituisce Composer. L’opzione automatica riguarda l’attivazione dopo l’installazione gestita da TGMPA, non l’acquisto di ACF PRO né l’installazione di Twig.

| Dichiarazione attuale TGMPA | Plugin |
| --- | --- |
| Obbligatori | ACF PRO, E-mail Log, Duplicate post, Contact Form 7, WP Maintenance Mode, Custom Post Type Permalinks, CopyPaste FlexContent Blocks for ACF, Post Meta Inspector, Complianz GDPR. |
| Consigliati / non obbligatori | Responsive Lightbox Lite, Redirection, SG Speed Optimizer, SG Security Optimizer, Akismet, Jetpack, Sucuri Security, Yoast SEO. |

Questa tabella documenta la dichiarazione del tema, non certifica installazione o attivazione sul singolo sito. ACF PRO è la dipendenza dei campi; CF7 serve per i suoi form; il lightbox della gallery dipende dalla configurazione del relativo plugin. Gli strumenti di ispezione, sicurezza e gestione non sono tutti requisiti del rendering delle section.

### Librerie frontend

| Stato iniziale in assenza di impostazioni salvate | Librerie |
| --- | --- |
| Sempre caricate, senza interruttore Personalizza | jQuery di WordPress, Bootstrap 4.6.2 con bundle Popper, Font Awesome, Animate.css, Hover.css. |
| Attive di default, disattivabili in Personalizza | Owl Carousel, Masonry, ImagesLoaded, List.js, Jarallax con Video ed Element, NProgress. |
| Disattive di default, attivabili in Personalizza | GSAP, Three.js, Lenis, Locomotive Scroll, Lightbox2, Fitty, Swiper, Magic Mouse, Cocoen. |

Le impostazioni già salvate prevalgono sui default: una copia del sito può quindi avere GSAP attivo. Jarallax, Video ed Element condividono un solo interruttore. List.js abilita ricerca/paginazione Collapse; Masonry dispone gli elementi di altezze diverse; Owl gestisce i caroselli. Il caricamento di Swiper, Three.js o Cocoen non configura automaticamente i contenuti ACF.

Bootstrap usa il proprio bundle e jQuery è quello fornito da WordPress: non aggiungere una seconda copia di jQuery o un altro Popper per le section Bootstrap 4. Google Maps è un servizio separato caricato quando necessario.

### Percorso breve: opzione → caricamento → inizializzazione

| Passaggio | File e responsabilità |
| --- | --- |
| Opzione | `core/customizer.php`: crea il controllo in Personalizza e il suo valore iniziale. `core/config.php`: legge lo stesso `grit_setting_*` e lo espone in `$GLOBALS['assets_options']`. Mantenere coerenti i default nei due file. |
| Caricamento | `core/scripts.php`: legge l’opzione e carica CSS/JS con gli handle WordPress e le relative dipendenze. `grit_scripts()` carica le librerie alla priorità 100; `grit_scripts_custom()` carica `custom.js` alla 110. |
| Inizializzazione | `assets/js/custom.js`: individua il componente nella pagina, verifica la disponibilità della libreria e avvia il comportamento. I commenti `GRIT_SET` permettono di trovare il blocco interessato. Il markup resta nei Twig e gli stili del tema negli SCSS. |

**Esempio: Owl Carousel.** Cerca `grit_setting_owl_carousel` nel Customizer e in `config.php`: il default è `true`. In `scripts.php`, `GRIT_SETTING_OWL_CAROUSEL` abilita gli asset con handle `owl_carousel`; il blocco 27 lo aggiunge alle dipendenze di `custom.js` quando è caricato. Nel blocco **03 | Owl carousels** di `custom.js` trovi selettori e opzioni; il controllo `typeof $.fn.owlCarousel` evita l’avvio quando manca la libreria. Per modificare il numero di elementi usa prima le classi documentate dei singoli layout.

### Librerie strutturali e facoltative

- **Strutturali nell’implementazione attuale:** jQuery di WordPress e Bootstrap. Il codice condiviso usa jQuery; griglia, utility, accordion e tab usano Bootstrap. Rimuoverli richiede adattare template, stili e interazioni.
- **Sempre caricate per la presentazione:** Font Awesome, Animate.css con ViewportChecker e Hover.css. Forniscono icone ed effetti usati dal tema. Non hanno un interruttore in Personalizza: prima di rimuoverle cercare le relative classi nei Twig, nei contenuti e negli stili.
- **Facoltative:** le librerie delle due righe configurabili della tabella precedente. Si possono attivare/disattivare in Personalizza; il componente interessato può perdere carosello, ricerca, animazione o altro comportamento. Verificare il risultato anche con la libreria disattivata.

`core/scripts.php` carica direttamente Bootstrap, Font Awesome, Animate.css e Hover.css. Queste risorse non hanno interruttori in `core/config.php`: per personalizzarne il caricamento, modificare i relativi enqueue in `core/scripts.php`.

List.js segue lo stesso percorso, ma viene registrato nel blocco 27 di `scripts.php` e caricato come dipendenza di `custom.js`; la sua inizializzazione è nel blocco 09 (Collapse). GSAP e Lenis sono nel blocco 12. Google Maps segue un percorso dedicato: chiave nel Customizer, dati in `core/extras.php`, template `section_maps.twig` e controller `assets/js/maps.js`.

Caricare una libreria non crea automaticamente un componente: per esempio, gli interruttori Three.js, Swiper e Cocoen caricano gli asset, ma `custom.js` non contiene un’inizializzazione dedicata per loro. Serve il markup e la configurazione previsti dal progetto.

### Aggiungere, disattivare o rimuovere una libreria

1. **Aggiungere:** se serve un controllo per chi configura il sito, seguire il percorso del Customizer e di `config.php`; aggiungere gli enqueue in `scripts.php`, poi l’inizializzazione nel blocco pertinente di `custom.js`. Dichiarare le dipendenze reali: se `custom.js` usa la nuova libreria, aggiungerne l’handle alle sue dipendenze soltanto quando è abilitata. Verificarne la disponibilità prima dell’avvio.
2. **Disattivare su un progetto:** usare Personalizza per le librerie facoltative. Cambiare il default nel codice non sovrascrive un valore già salvato nel sito.
3. **Rimuovere dallo starter:** cercare nome dell’opzione, chiave `GRIT_SETTING_*`, handle e chiamate JavaScript; eliminare le parti collegate e adattare markup/stili che le richiedono. Controllare anche gli asset e le licenze prima di eliminare file condivisi.

Gli elenchi `GRIT_SETTING_CSS` e `GRIT_SETTING_JS` in `config.php` servono per URL aggiuntivi caricati senza interruttore. Non inizializzano componenti e non descrivono dipendenze fra script: quando occorre un ordine preciso, usare enqueue espliciti in `scripts.php`.

Dopo una modifica verificare nella rete del browser che gli asset siano caricati una sola volta, controllare la console e provare il componente su desktop/mobile, anche con l’opzione disattivata.

## Campi comuni e colonne

### Dove compilare

Usare il Flexible Content **Sections** nelle schermate abilitate dalle regole ACF. I campi comuni possono variare leggermente secondo il layout. Ogni layout include una tab **Guida**, con note sulle classi e sulle librerie richieste; le istruzioni brevi restano accanto ai singoli campi. La tab contiene solo informazioni e non aggiunge valori ai contenuti salvati.

| Campo | Uso |
| --- | --- |
| Class | Classi sulla section: struttura, colori/utility e modificatori. |
| Inner Class | Colonne e modificatori del singolo capitolo/card/gruppo, secondo il layout. |
| Contained | Limita la larghezza interna secondo il tema; disattivato consente la composizione estesa. |
| Pre Content | Se attivo, prima del contenuto WordPress; altrimenti dopo. |
| Background Color / Text Color | Colori del wrapper. Non garantiscono da soli il contrasto di ogni pulsante. |
| Align | Allineamento del testo; non equivale all’allineamento verticale delle colonne. |
| Link 1 / Link 2 e colori | Collegamenti opzionali resi dal componente pulsanti. |

Il titolo di Section Text genera un h2, il sottotitolo un h3. Per un h1 introduttivo nel testo formattato lasciare vuoto il titolo del capitolo e inserire un solo h1 nella pagina. Usare titoli gerarchici e testi alternativi descrittivi nelle immagini informative.

### Classi: struttura, aspetto e comportamento

Prima scegli il layout, poi le colonne e infine lo stile. Scrivi le classi separate da spazi, senza il punto iniziale. Non occorre riempire tutti i campi: lasciandoli vuoti si usano i valori predefiniti.

| Scopo | Esempio | Dove usarlo |
| --- | --- | --- |
| Colonne | `col-12 col-md-6` | Inner Class del capitolo/card nei layout che prevedono colonne. Una colonna su mobile, due da 768 px. |
| Spaziatura | `py-5` / `mb-4` | Class per tutta la sezione; Inner Class per il singolo elemento. |
| Modalità di layout | `section_carousel_text` / `section_masonry` | Class di Section Text. Attivano un comportamento, non soltanto un colore o una spaziatura. |
| Configurazione del carosello | `carousel-items-1 carousel-items-md-2` | Class della sezione con carosello attivo. Non attiva il carosello da sola. |
| Effetto sull’immagine | `parallax` / `parallax-gsap` | Inner Class del capitolo di Section Text statica; richiede rispettivamente Jarallax o GSAP. |
| Stile del progetto | `servizi-card` | Nel campo del contenitore da personalizzare, con la relativa regola nel CSS del progetto o del child. |

Le classi di comportamento sono specifiche del layout: non copiare il comando di Section Text in Gallery o Archive. Consulta la tab Guida del layout per il nome corretto e abilita la libreria richiesta in Personalizza.

**Esempi pronti per Section Text**

| Risultato | Class della sezione | Inner Class di ogni capitolo | Libreria |
| --- | --- | --- | --- |
| Griglia a due colonne da tablet | `py-5` | `col-12 col-md-6` | Nessuna aggiuntiva |
| Griglia Masonry a due colonne da tablet | `section_masonry py-5` | `col-12 col-md-6` | Masonry |
| Carosello: uno su mobile, due da tablet | `section_carousel_text carousel-items-1 carousel-items-md-2` | Lasciare vuoto per la larghezza | Owl Carousel |

Nel carosello, `col-*` non controlla il numero di elementi visibili. Per tornare alla griglia, rimuovere la classe che attiva il carosello. Non combinare carosello e Masonry: Section Text dà precedenza al carosello.

### Colonne condivise

`col-12 col-md-6 col-lg-4` significa una colonna su mobile, due da md, tre da lg. `mb-4`, `p-4`, `py-5`, `pt-md-7` sono esempi di spaziature Bootstrap o delle estensioni del tema. Verificare i valori presenti prima di usare utility non previste.

Senza colonne esplicite:

| Capitoli/card | Colonne automatiche |
| --- | --- |
| 1 | `col-12`; con Align center: `col-12 col-md-10 col-xl-8`. |
| 2 | `col-12 col-md-6`. |
| 3 | `col-12 col-sm-6 col-md-4`. |
| 4 o più | `col-12 col-sm-6 col-md-3`. |

Una classe `col` o `col-*` in Inner Class sostituisce le colonne automatiche. Nel carosello le colonne vengono rimosse: il numero visibile si imposta con `carousel-items-*`. Le altre utility rimangono.

Breakpoint di riferimento: base 0, sm 576, md 768, lg 992, xl 1200, xxl 1400 px. Bootstrap 4 non fornisce automaticamente tutte le utility xxl: usare xxl soltanto nei sistemi del tema che lo supportano esplicitamente, come caroselli e gallery.

## Section Page e contenuti riutilizzabili

Section Page richiama le section di una pagina sorgente. È adatta a CTA, contatti e gruppi condivisi da mantenere in un solo punto.

1. Creare una pagina sorgente e compilarne le Sections.
2. Lasciarla anche in bozza, se non deve avere una pagina pubblica autonoma.
3. Nella pagina di destinazione aggiungere Section Page e selezionare la sorgente.
4. Modificare la sorgente per aggiornare tutti i richiami.

Il rendering legge anche una sorgente in bozza. Di conseguenza i contenuti richiamati possono essere visibili nella pagina pubblica di destinazione: la bozza serve qui come contenitore riutilizzabile, non come barriera di riservatezza. Una password sulla sorgente non viene aggirata.

L’espansione avviene **a un solo livello**: eventuali Section Page dentro la sorgente non vengono espanse. Ogni section sorgente conserva la propria posizione Pre Content; il riferimento non forza tutte le section nello stesso punto.

Gli ID vengono ricostruiti nel contesto della destinazione: `section_id_2-1` indica la prima section richiamata dalla seconda riga. Ripetere una sorgente in righe diverse non riutilizza semplicemente gli ID della pagina originale. Gli ID dipendono dalla posizione: riordinare le righe può cambiare le ancore; non considerarli identificativi permanenti per link esterni.

Il rendering condiviso è in `templates/partials/sections.twig`, richiamato dai template principali nei punti pre/post content. La disponibilità delle section dipende dall’oggetto ACF caricato dal relativo controller: non presumere che una vista autore abbia una pagina associata.

## Section Text

La sezione usa il repeater ACF chapters (immagine, titolo, sottotitolo, WYSIWYG, due link, inner_class).

### Modalità

- Nessuna classe strutturale: griglia Bootstrap.
- `section_masonry`: griglia Masonry; senza libreria resta una griglia Bootstrap.
- `section_carousel_text`: carosello Owl. Ha precedenza se sono specificate entrambe le modalità.

Le classi devono essere token separati da spazi. Tutte le opzioni carousel-* descritte in [capitolo Caroselli Owl condivisi](#caroselli-owl-condivisi) sono supportate. Default testo: 1 / 2 / 3 / 3 / 4 / 4 elementi da base / sm / md / lg / xl / xxl.

### Colonne statiche

Default: un capitolo a larghezza piena (con align center si restringe da md); due capitoli su due colonne da md; tre su due colonne da sm e tre da md; quattro o più su due colonne da sm e quattro da md. Il valore `col` e tutte le classi `col-*` in inner_class sostituiscono le colonne automatiche. Nel carosello vengono rimosse perché la larghezza è gestita da Owl. Gli altri modificatori restano sul contenitore del capitolo.

### Proporzioni immagini

Inserire nel campo Class della sezione:

| Classe | Funzione |
|---|---|
| text-image-ratio-square | Riquadro 1:1 |
| text-image-ratio-landscape | Riquadro 4:3 |
| text-image-ratio-portrait | Riquadro 3:4 |
| text-image-ratio-auto | Proporzioni originali |
| text-image-fit-cover | Ritaglio per riempire (default con rapporto fisso) |
| text-image-fit-contain | Immagine intera con eventuali spazi |

Scegliere una sola ratio e una sola fit. Nessun suffisso responsive per queste classi. Senza ratio si mantengono le proporzioni originali. Le classi rendono uniformi i riquadri immagine, non l'altezza totale delle card. I contenitori parallax conservano la propria gestione dell'immagine: usare fit per immagini standard.

Esempio:

```text
section_carousel_text carousel-items-1 carousel-items-md-2 carousel-items-xl-3 text-image-ratio-landscape text-image-fit-cover
```

Le immagini usano wp_get_attachment_image con formato large e srcset quando disponibili. Sizes del carosello segue i conteggi configurati, con stima conservativa sulla finestra; per autoWidth o layout statici viene usata una stima 100vw. Nessuna rigenerazione o ingrandimento degli originali viene effettuata.

### Parallax

`parallax` o `parallax-gsap` nel campo inner_class del capitolo attivano il markup dedicato nei layout statici. GSAP ha precedenza. Le librerie devono essere caricate. Nel carosello queste classi non attivano il parallax: si evita il conflitto con elementi clonati e trasformazioni Owl.

### Contenuto e accessibilità

Titolo h2, sottotitolo h3. Il testo WYSIWYG mantiene il proprio HTML. Titoli e attributi sono escaped; URL filtrati tramite esc_url. I pulsanti sono generati solo con URL presente; target _blank include rel noopener noreferrer. Il partial condiviso è templates/partials/text-chapter.twig.

Masonry viene inizializzato una volta per griglia e ricalcolato al caricamento immagini/font. Jarallax è inizializzato solo se disponibile, indipendentemente da Owl. Gli stili della sezione sono in assets/css/_sections.scss; i controlli Owl restano in assets/css/_plugins.scss.

Il selettore di inizializzazione è `.js-grit-masonry`, distinto dall’auto-inizializzazione HTML di Masonry: evita che la libreria crei prima un’istanza senza le opzioni del tema.

Colori e posizioni dei controlli sono descritti nel capitolo [Caroselli Owl condivisi](#caroselli-owl-condivisi).

### Background Image della sezione

Campo Background Image nel pannello Style: immagine decorativa dell’intera sezione, indipendente dalle immagini dei capitoli. Con classe `parallax` anima lo sfondo tramite Jarallax; in assenza della libreria o con movimento ridotto resta statico. Usa `text-background-overlay` (nero 40%) oppure `text-background-overlay-light` (bianco 40%), scegliendo il colore del testo appropriato. Altezza data da contenuto e spaziature (es. py-7). Background Half riguarda solo il colore. Compatibile con griglia, Masonry e carosello. 

### Headers Layout: pannello sovrapposto

`text-header-overlap` con Background Image e un solo capitolo statico sovrappone il pannello di testo alla parte inferiore della foto. Inner Class consigliata: col-12 col-md-10 col-lg-8. Il pannello resta nel normale flusso e cresce con il testo. Colori predefiniti bianco/scuro, personalizzabili con --header-panel-background e --header-panel-color. Non pensato per Masonry o carosello. Breadcrumb nel Testo con [wpseo_breadcrumb].

### Hero e CTA: distribuzione verticale

Solo griglia statica: text-columns-top/center/bottom/stretch allinea le colonne fra loro (Class della sezione). text-content-top/center/bottom/between distribuisce i gruppi del capitolo (Class o Inner Class). text-image-after porta la foto dopo testo e pulsanti. text-height-medium imposta un minimo di 70svh sui capitoli, lasciandoli crescere. Non attivi in Masonry o carosello. Non usare più modalità dello stesso gruppo insieme. Between richiede spazio libero e non separa i singoli paragrafi del campo Text.

### Masonry condiviso con Archive

`section_masonry` usa lo stesso controller e gli stessi stili di Section Archive. Colonne in Inner Class; carosello prioritario se attivato. `$masonry-item-gap` centralizza lo spazio verticale standard. Per valutarlo usare capitoli di diversa lunghezza su una, due e tre colonne. Tenere le istruzioni tecniche separate dai testi dimostrativi dei capitoli.

## Section Gallery

### Modalità disponibili

| Immagini | Classi | Risultato |
| --- | --- | --- |
| Nessuna | Qualsiasi | Nessuna immagine da mostrare. |
| Una | Nessuna classe parallax | Immagine singola responsive. |
| Una | `parallax` | Immagine con Jarallax, se disponibile. |
| Una | `parallax-gsap` | Immagine con parallax GSAP; precede Jarallax se entrambe le classi sono presenti. |
| Più di una | `gallery_carousel` | Carosello Owl condiviso. |
| Più di una | Senza `gallery_carousel` | Griglia generata dallo shortcode WordPress `[gallery]`. |

Le classi parallax del ramo singolo vanno nel campo Class della section. `carousel-*` configura il carosello e non la griglia statica. Le immagini singole non acquisiscono automaticamente un lightbox solo perché il plugin è attivo: verificare il markup e le opzioni del plugin.

Con più immagini e senza `gallery_carousel`, la sezione usa lo shortcode WordPress `[gallery]`. Per il lightbox configurare Responsive Lightbox Lite con la libreria Nivo prevista dal progetto. I collegamenti puntano esplicitamente al file immagine (`link="file"`); l'apertura in lightbox dipende dalle impostazioni del plugin.

### Campi ACF

- Gallery: immagini e ordine.
- Columns: colonne sugli schermi da 576 px in assenza di classi esplicite. Il campo consente 1–4 colonne.
- Size: risorsa WordPress thumbnail / medium / large / full. La classe delle proporzioni modifica il riquadro visivo, non la risoluzione scaricata.

Sotto 576 px il valore predefinito è una colonna. Distanza predefinita: 8 px. Le classi sono inserite nel campo Class della sezione, separate da spazi. JavaScript legge colonne e distanze; senza JavaScript restano i valori predefiniti ACF.

### Colonne e distanze

- `gallery-cols-N`: da 1 a 12 colonne, a tutte le larghezze.
- `gallery-cols-sm-N`: da 576 px.
- `gallery-cols-md-N`: da 768 px.
- `gallery-cols-lg-N`: da 992 px.
- `gallery-cols-xl-N`: da 1200 px.
- `gallery-cols-xxl-N`: da 1400 px.
- `gallery-gap-N`: distanza in pixel, intero da 0 a 500.
- `gallery-gap-sm-N`, `gallery-gap-md-N`, `gallery-gap-lg-N`, `gallery-gap-xl-N`, `gallery-gap-xxl-N`: distanza dal breakpoint corrispondente.

Ogni valore esplicito si propaga verso gli schermi più grandi finché non viene sovrascritto per la stessa opzione. Non inserire valori contraddittori per lo stesso breakpoint.

### Proporzioni delle anteprime

- `gallery-ratio-square`: 1:1.
- `gallery-ratio-landscape`: 4:3.
- `gallery-ratio-portrait`: 3:4.
- `gallery-ratio-auto`: proporzioni originali.
- `gallery-fit-cover`: riempie il riquadro, ritagliando quando necessario (default con rapporto fisso).
- `gallery-fit-contain`: mostra tutta l'immagine nel riquadro, lasciando eventuali spazi vuoti.

Scegliere una sola classe ratio e una sola classe fit. Il fit è significativo con un rapporto fisso. Le proporzioni non hanno suffissi responsive. Queste classi funzionano sia nella griglia statica sia nel carosello. Non modificano il ramo immagine singola con parallax. L'immagine originale aperta tramite collegamento mantiene le proprie proporzioni.

### Esempi

Una colonna mobile, due tablet, quattro desktop:

```text
gallery-cols-1 gallery-cols-md-2 gallery-cols-xl-4 gallery-gap-20
```

Anteprime quadrate, nessun ritaglio, distanza maggiore su desktop:

```text
gallery-cols-1 gallery-cols-sm-2 gallery-cols-lg-3 gallery-ratio-square gallery-fit-contain gallery-gap-10 gallery-gap-lg-30
```

Senza classi: una colonna mobile, poi Columns di ACF, immagini nelle proporzioni originali.

### Carosello e lightbox

Per il carosello usare `gallery_carousel` e le classi `carousel-*` documentate in [capitolo Caroselli Owl condivisi](#caroselli-owl-condivisi). Le classi `gallery-cols-*` e `gallery-gap-*` sono dedicate alla griglia. Le classi ratio e fit funzionano anche nel carosello.

Il lightbox è gestito dal plugin Responsive Lightbox Lite. Configurarlo nel plugin e verificarne il comportamento sulle immagini singole e nei caroselli, inclusi gli elementi clonati da Owl.

Stili della griglia: assets/css/_sections.scss. Stili Owl e controlli: assets/css/_plugins.scss. Dopo modifiche SCSS ricompilare main.scss in main.css.

### Anteprime responsive nel carosello

Le anteprime sono immagini WordPress generate con `wp_get_attachment_image`, dimensione iniziale `large`, attributi width/height e srcset quando disponibili nei metadati. Il browser sceglie tra i file realmente disponibili: non vengono creati nuovi formati né ingranditi gli originali.

L’attributo sizes segue i conteggi `carousel-items-*` ed è una stima prudenziale basata sulla larghezza della finestra; contenimento, gap e stage padding possono ridurre la larghezza effettiva. Con autoWidth di base si usa 100vw come stima. La qualità dipende dagli originali e dalle miniature WordPress esistenti.

- Nessuna classe ratio: proporzioni originali, altezze potenzialmente differenti.
- `gallery-ratio-landscape gallery-fit-cover`: riquadri 4:3 uniformi, con eventuale ritaglio.
- `gallery-ratio-square gallery-fit-contain`: riquadri quadrati con immagini intere ed eventuali spazi liberi.
- Nessuna altezza fissa: le anteprime crescono con la larghezza della card.
- L’immagine originale collegata al lightbox resta invariata.

Esempio consigliato:

```text
gallery_carousel carousel-items-1 carousel-items-md-2 carousel-items-xl-3 gallery-ratio-landscape gallery-fit-cover
```

Le classi ratio non hanno breakpoint. Evitare autoWidth se si desidera un numero preciso di elementi. Il campo ACF Size riguarda la griglia statica.

Colori e posizioni dei controlli sono descritti nel capitolo [Caroselli Owl condivisi](#caroselli-owl-condivisi).

## Section Collapse

### Modalità

| Class della sezione | Funzione |
|---|---|
| Nessuna classe specifica | Accordion diviso in gruppi; primo elemento aperto per gruppo |
| section_collapse_search | Lista piatta con ricerca e paginazione indipendente, sette risultati per pagina |
| section_collapse_dynamic | Schede: ciascun gruppo può contenere testo, griglia o carosello |

Se sono presenti search e dynamic, search ha precedenza. Il repeater ACF Lists contiene args (nome del gruppo), args_color, inner_class e item (titolo, WYSIWYG, due link). I pulsanti non richiedono testo e vengono mostrati anche nella griglia dinamica.

### Schede: Inner Class del gruppo

- Vuoto: testi in sequenza.
- `grid`: griglia con tre colonne da md, una su mobile.
- `grid col-12 col-md-6`: due colonne da md.
- `carousel`: carosello Owl.
- `carousel carousel-items-1 carousel-items-md-2 carousel-no-loop`: carosello configurato per gruppo.
- Altri valori: layout testo con le classi indicate, senza far sparire i contenuti.

Per Owl si possono usare tutte le classi funzionali carousel-* elencate in [capitolo Caroselli Owl condivisi](#caroselli-owl-condivisi). Le opzioni della sezione valgono per tutti i caroselli, quelle del contenitore del gruppo prevalgono a parità di opzione e breakpoint. Le classi di posizione dei controlli restano sulla sezione, perché sono stili del wrapper. I conteggi predefiniti dei caroselli Collapse sono quelli standard (1/2/3/4/5/5).

### Ricerca

List.js 2.3.1 è distribuito localmente in assets/list-js con la licenza originale. Quando abilitato in Personalizza, WordPress lo carica una sola volta come dipendenza di custom.js. Ogni sezione riceve una propria istanza con sette risultati per pagina. Cerca in titolo, contenuto e gruppo, senza distinzione tra maiuscole e minuscole; il trattamento degli accenti segue il comportamento della libreria. Ricerca e reset ritornano alla prima pagina. Paginazione, stato vuoto e lista vuota sono gestiti per sezione. Senza JavaScript l’elenco completo rimane visibile.

### Dipendenze e accessibilità

Accordion e tab usano Bootstrap 4; il carosello usa Owl. Bootstrap deve essere attivo per apertura e tab. Gli ID derivano da sezione, gruppo e posizione della voce: nomi uguali o vuoti non creano conflitti. Le intestazioni sono button con attributi ARIA; icone decorative aggiornate in base agli eventi reali Bootstrap. I titoli sono escaped, il WYSIWYG conserva HTML, link filtrati con esc_url e target _blank con rel noopener noreferrer.

All'apertura di una scheda viene aggiornato il carosello nascosto. La ricerca e gli accordion sono indipendenti tra sezioni; ogni gruppo standard può mantenere un elemento aperto, mentre la ricerca usa un unico accordion per sezione.

### Codice

- templates/sections/section_collapse.twig: modalità e identificativi.
- templates/partials/collapse-item.twig: intestazioni e pannelli accordion.
- templates/partials/buttons.twig: gruppo pulsanti condiviso; testo nei rispettivi layout.
- assets/js/custom.js: ricerca, paginazione, icone e aggiornamento tab.
- assets/css/_sections.scss: blocco Collapse condiviso.
- assets/css/_plugins.scss: controlli Owl condivisi.

Il numero di risultati per pagina si configura nel controller di ricerca in `assets/js/custom.js`. Le personalizzazioni di spaziatura usano le utility del tema. Dopo modifiche SCSS ricompilare main.scss.

Colori e posizioni dei controlli sono descritti nel capitolo [Caroselli Owl condivisi](#caroselli-owl-condivisi).

## Section Archive

Mostra una selezione indipendente di contenuti pubblicati, senza paginazione. La query della sezione è separata dalla query principale WordPress e dagli elenchi `archive_posts`/`archive_section` usati da altri template, inclusi i correlati del singolo.

### Campi

| Campo | Comportamento |
| --- | --- |
| Post Type | Selezione dei tipi pubblici registrati, esclusi gli allegati. Vuoto: post. |
| Tease | Campo testo: nome del template card senza tease- e senza .twig; la descrizione elenca le varianti disponibili. Vuoto: template del tipo, se presente, altrimenti card standard. Le varianti WooCommerce richiedono l’integrazione realmente disponibile. |
| Inner Class | Colonne e modificatori di ogni card, per esempio col-12 col-md-6 mb-4. |
| Numero contenuti | Da 1 a 100. Vuoto: quantità configurata in Impostazioni → Lettura. |
| Ordina per | Data, titolo oppure menu_order; ordine secondario per ID per stabilità. |
| Direzione | DESC (default: più recenti prima per data) oppure ASC. |
| Escludi contenuto corrente | Opzionale, disattivato di default. Nei singoli/pagine esclude l’oggetto visualizzato, anche se la sezione è richiamata da Section Page. |
| Tassonomia | Opzionale, deve appartenere al post type scelto. |
| Slug dei termini | Slug separati da virgole; corrispondenza con almeno uno (OR/IN). Senza slug il filtro non viene applicato. Filtro invalido o senza risultati: sezione nascosta. |
| Contained / Pre Content / colori / allineamento / Class | Funzionamento comune delle sezioni. |

Query limitata a publish, senza contenuti protetti da password. L’ordinamento predefinito è Data + DESC (più recenti prima); per mostrare prima i contenuti meno recenti scegliere Data + ASC.

### Griglia e carosello

Class vuoto: griglia. `section_archive_carousel`: carosello quando ci sono almeno due risultati; un solo risultato resta statico. Riconoscimento della classe esatta.

Colonne centralizzate: con Inner Class esplicito si usano le colonne richieste; senza colonne si applicano le regole condivise di Text (1 piena, 2 metà da md, 3: due da sm e tre da md; 4+: due da sm e quattro da md). In carosello le classi col-* sono rimosse e restano gli altri modificatori. Le classi col-* nel campo Class controllano la colonna esterna che contiene l’elenco.

Preset Owl Archive: 1/2/3/3/3/3 elementi a base/sm/md/lg/xl/xxl, loop disattivato. Usa le classi comuni carousel-items-*, carousel-gap-*, carousel-nav, carousel-no-nav, carousel-dots, carousel-no-dots e altri modificatori documentati in [capitolo Caroselli Owl condivisi](#caroselli-owl-condivisi).

Colori indipendenti: `carousel-nav-light`, `carousel-nav-dark`, `carousel-dots-light`, `carousel-dots-dark`. Nessuna modifica automatica a forma, dimensioni o sfondo delle frecce. Senza Owl le card restano leggibili in sequenza.

### Card

Le card standard usano immagini WordPress large/srcset con alt da Libreria Media. Le anteprime preferiscono l’excerpt, altrimenti testo del contenuto, senza eseguire shortcode o filtri the_content. Le card non hanno ID ripetibili: usano data-post-id, valido anche con copie Owl e più sezioni.

Codice PHP in core/extras.php; template sections/section_archive.twig e partials/tease*.twig; colonne in partials/grid-classes.twig; immagini in partials/card-image.twig.

Gli slug sono i nomi tecnici dei termini, non gli ID né i titoli visualizzati. Esempio: tassonomia category e slug notizie,eventi mostra articoli appartenenti a Notizie oppure Eventi. Il filtro include normalmente anche i termini figli delle tassonomie gerarchiche. Senza slug nessun filtro. I filtri amministrativi usano i nomi dei campi e verificano il layout section_archive, senza chiavi ACF fissate nel codice.

### Modalità Termini

`archive_mode`: `posts` (predefinito) oppure `terms`.

In Termini la tassonomia pubblica scelta viene interrogata con `get_terms()`. Le card hanno nome, link all’archivio, descrizione facoltativa (35 parole) e conteggio WordPress facoltativo. Non vengono usati Post Type, Tease, filtro Slug dei termini, ordine dei post o esclusione del contenuto corrente. Non vengono registrate nuove tassonomie.

| Campo | Funzione |
| --- | --- |
| `taxonomy` | Tassonomia pubblica da elencare; obbligatoria per avere risultati. |
| `posts_per_page` | Quantità comune, massimo 100; nessuna paginazione numerata. |
| `terms_orderby` | `name`, `count` oppure `term_id`. |
| `order` | `ASC` o `DESC`. |
| `terms_hide_empty` | Nasconde i termini vuoti secondo WordPress. |
| `terms_parent` | Slug del genitore: solo figli diretti della stessa tassonomia gerarchica. |
| `terms_top_level` | Termini con parent zero; ignorato per tassonomie piatte o genitore compilato. |
| `terms_show_description` | Mostra la descrizione testuale abbreviata. |
| `terms_show_count` | Mostra il conteggio WordPress; nessun ricalcolo per CPT. |

Griglia e carosello condividono Class, Inner Class e le opzioni Owl della modalità Contenuti. Senza termini la section non viene generata; con un solo termine resta statica. Tassonomia mancante/non pubblica, genitore inesistente o genitore su tassonomia non gerarchica non producono risultati. La card è `templates/partials/tease-term.twig`, separata dai Tease dei post. Non sono previste immagini dei termini.



### Masonry

Aggiungi `section_masonry` in Class sia per Contenuti sia per Termini. Le larghezze restano quelle di Inner Class, per esempio `col-12 col-md-6 col-lg-4 mb-4`. La classe `section_archive_carousel` ha precedenza anche se compare insieme a Masonry: scegli una sola modalità.

Il controller e gli stili sono condivisi con Section Text. La libreria Masonry si gestisce in Personalizza; senza libreria rimane una griglia Bootstrap. L’effetto si vede con card di altezze differenti. Immagini e font completati provocano un nuovo calcolo; Masonry gestisce il resize. La distanza verticale comune è `$masonry-item-gap`, sovrascrivibile con utility come `mb-4`. Lo stesso sistema si applica sia alle card dei contenuti sia ai termini.

## Section Slides

Campi ACF: repeater slides, titolo, testo, immagine, colori, allineamento, due pulsanti; contained, pre_content e class sulla sezione.

Zero elementi: nessun contenuto interno. Un elemento: slide statica. Due o più: Owl condiviso; senza Owl le slide sono leggibili una sotto l’altra. Titoli h2; immagini decorative responsive con alt vuoto. Inserire informazioni importanti anche nel testo.

### Classi della sezione

| Classe | Effetto |
| --- | --- |
| Nessuna classe di altezza | Altezza minima pari allo schermo, con unità svh sui browser compatibili |
| slides-height-small | Altezza minima 50% dello schermo |
| slides-height-medium | Altezza minima 75% dello schermo |
| slides-height-auto | Altezza determinata dal testo e dalla spaziatura |
| slides-content-top | Testo in alto |
| slides-content-center | Testo al centro verticale |
| Nessuna classe di posizione | Testo in basso |
| slides-overlay | Velo nero al 40% |
| slides-overlay-light | Velo bianco al 40% |
| slides-no-overlay | Rimuove il velo |
| slides-zoom | Zoom leggero, opzionale; disabilitato con movimento ridotto e sulle immagini Jarallax |
| parallax | Solo sulla slide singola; richiede Jarallax attivo; disabilitato con movimento ridotto |

Usare una sola classe per altezza, posizione e overlay. L’altezza è minima: contenuti lunghi possono espandere la slide. Colore del testo e overlay devono essere scelti insieme per garantire leggibilità. Contained rispetta il campo ACF.

### Carosello condiviso

Default: una slide, loop, autoplay ogni 5000 ms, frecce e punti attivi, dissolvenza e smartSpeed 1000 ms. Autoplay spento con movimento ridotto. Classi disponibili del sistema comune: carousel-no-autoplay, carousel-timeout-7000, carousel-speed-600, carousel-no-loop, carousel-no-nav, carousel-no-dots, carousel-no-drag, carousel-no-touch e modificatori responsive del sistema condiviso. Posizione frecce e punti nelle classi comuni carousel-nav-* e carousel-dots-*.

Slides forza items=1, autoWidth=false, center=false e margin=0 a ogni breakpoint per mantenere compatibile la dissolvenza. Non usare carousel-items-*, carousel-gap-*, carousel-center o carousel-auto-width per questo layout. I modificatori hanno senso solo con più slide.

Esempio: `slides-height-medium slides-content-center slides-overlay carousel-no-autoplay carousel-nav-bottom-right`.

File: templates/sections/section_slides.twig, templates/partials/slide.twig; SCSS nel blocco section_slides di assets/css/_sections.scss; impostazioni Owl e Jarallax in assets/js/custom.js.

Parallax: nelle Slides l’immagine viene spostata nel contenitore Jarallax (keepImg=false), con livello zIndex=0 sopra il colore di fondo e sotto overlay e testo. Velocità predefinita 0.5.

Full-width: disattivare Contained. Frecce standard, senza dimensioni o sfondo specifici per Slides; per posizioni esterne prevedere spazio con le classi della sezione. Stili centralizzati in assets/css/_plugins.scss. Controlli assenti sulla slide singola, con carousel-no-nav o sotto il breakpoint configurato; estremi attenuati con loop disattivato.

Colori e posizioni dei controlli sono descritti nel capitolo [Caroselli Owl condivisi](#caroselli-owl-condivisi).

## Section Cube

Composizione testo + immagini. Campi ACF: titolo, testo, elenco icona/testo, due link con colori, gallery, colori, Invert, Contained, Pre Content e Class.

| Contenuto | Comportamento |
| --- | --- |
| Testo senza gallery | Testo a larghezza piena; nessuna colonna immagini vuota |
| Una immagine | Immagine statica responsive |
| Più immagini | Owl condiviso, una immagine visibile per default |
| Solo immagini | Gallery a larghezza piena, senza colonna testo vuota |
| Nessun contenuto | Nessun contenuto interno |

Con testo e immagini: impilati su mobile; testo 8/12 e media 4/12 da md; metà e metà da lg. Invert scambia le colonne da md; su mobile resta prima il testo. Contained mantiene il comportamento laterale del tema. Titolo h2. Testi formattati conservati, titoli e attributi escapati. Pulsanti condivisi.

Le immagini usano WordPress srcset, alt della Libreria Media e object-fit: cover. La cornice mantiene una base quadrata, espandendosi con il testo affiancato; possono esserci ritagli ai bordi. Le icone dell’elenco sono decorative e hanno dimensione 40×40 con object-fit: contain.

`parallax` è una classe esatta, disponibile solo con una immagine e Jarallax attivo. Non viene applicata dentro Owl. Con movimento ridotto viene disattivata. L’immagine viene spostata nel contenitore animato, evitando una copia statica sovrapposta. Senza Jarallax rimane la copertura statica.

Con più immagini usare le classi Owl comuni: carousel-items-*, carousel-gap-*, carousel-no-nav, carousel-no-dots, carousel-autoplay e relativi breakpoint. Il preset Cube parte con un elemento e gap zero. Per una composizione fotografica continua mantenere carousel-items-1. Senza Owl le immagini restano leggibili in sequenza.

Colori indipendenti dei controlli: carousel-nav-light / carousel-nav-dark; carousel-dots-light / carousel-dots-dark. Nessuna personalizzazione automatica di forma o dimensione delle frecce. Riservare spazio per controlli esterni con classi della sezione.

File: templates/sections/section_cube.twig, blocco Cube in assets/css/_sections.scss; Owl/Jarallax in assets/js/custom.js.

## Section Maps

La section gestisce una o più sedi tramite ACF, con titolo, testo, due pulsanti e colonne Bootstrap personalizzabili.

### Mappa e stile

- Una sede: centratura automatica, zoom iniziale 12.
- Più sedi: inquadratura automatica di tutti i marker, con zoom massimo 16 dopo l’adattamento.
- Lo stile è sempre quello personalizzato in `assets/maps/style.json`. Modifica direttamente il JSON; non serve compilare SCSS. Il file nello stesso percorso del tema child ha precedenza.
- Un JSON non valido viene ignorato per evitare errori di caricamento.
- In Personalizza si configura soltanto la chiave Maps JavaScript API; non serve un Map ID.
- Il titolo della sede compare nella testata del popup accanto alla chiusura, seguito da descrizione e indicazioni.

### Campi e colonne

Ogni sede comprende titolo, descrizione e posizione. Coordinate incomplete o fuori intervallo vengono ignorate; zero è valido. Senza sedi valide la section non viene renderizzata.

Sono disponibili titolo della section, testo, due link/pulsanti, colori, allineamento, Contained, Pre content e Class.

| Impostazione | Valore predefinito |
| --- | --- |
| Colonna testo | `col-12 col-lg-5 mb-4 mb-lg-0` |
| Colonna mappa | `col-12 col-lg-7` |
| Senza contenuti testuali | Mappa a tutta larghezza, `col-12` |

### Classi della section

| Classe | Funzione |
| --- | --- |
| `maps-text-right` | Testo a destra da lg; prima della mappa su mobile. |
| `maps-columns-center` | Allineamento verticale delle colonne; non cambia il centro della mappa. |
| `maps-height-small` | Altezza mappa 18rem. |
| `maps-height-large` | Altezza mappa `clamp(28rem, 60vh, 48rem)`. |
| `maps-hide-locations` | Nasconde l’elenco solo quando la mappa è caricata correttamente. |

L’altezza standard è `clamp(20rem, 40vw, 32rem)`. Dimensioni, spaziature e colori del popup sono in `assets/css/_variables.scss`.

### Caricamento e fallback

Il controller viene caricato soltanto quando necessario. Google Maps viene richiesto una sola volta vicino al viewport; ogni mappa mantiene marker e popup indipendenti. Le gesture cooperative consentono lo scorrimento della pagina.

Senza chiave, JavaScript, consenso o in caso di errore, resta disponibile l’elenco HTML delle sedi con i link alle indicazioni. Con Complianz viene rispettato il consenso Google Maps/marketing.

### File

- `templates/sections/section_maps.twig`: contenuti e colonne.
- `core/extras.php`: validazione delle sedi e caricamento del JSON.
- `assets/js/maps.js`: mappa, marker e popup.
- `assets/maps/style.json`: cartografia personalizzata.
- `assets/css/_sections.scss`: presentazione.
- `assets/css/_variables.scss`: variabili.
- `core/acf-fields.json`: esportazione dei campi.

## Effetti GSAP e barre

GSAP carica il core e ScrollTrigger. CSSRulePlugin e ScrollToPlugin restano disponibili negli asset: decommentare i relativi enqueue in `core/scripts.php` solo quando servono nel codice personalizzato.

### Dove personalizzare le animazioni

In `assets/js/custom.js`, all’inizio del blocco **12 | GSAP, ScrollTrigger, Lenis and decorative bars**, l’oggetto `motionSettings` raccoglie i parametri modificabili del progetto:

| Gruppo | Cosa modifica |
| --- | --- |
| `smoothScroll` | Durata dello scorrimento Lenis e del raggiungimento dell’ancora al caricamento. |
| `horizontal` | Ritardo con cui pannelli orizzontali e titoli laterali seguono lo scroll (`scrub`, in secondi). |
| `reveal` | Opacità iniziale, durata, intervallo tra parole e punti di inizio/fine dell’effetto. |
| `parallax` | Ingrandimento e spostamento percentuale delle immagini. |
| `bars` | Numero massimo, distanza minima, rotazione e risposta delle barre a scroll e puntatore. |

Esempi: aumentare `reveal.wordDelay` da `0.035` a `0.06` distanzia maggiormente le parole nella rivelazione temporizzata; ridurre `bars.maxCount` da `15` a `8` limita le barre decorative. `reveal.scrollSpread` riguarda invece la distribuzione delle parole nell’effetto legato allo scroll, non una durata di riproduzione in secondi.

Questi valori personalizzano gli effetti già attivati dalle classi; non attivano le librerie. Le impostazioni sono condivise dalle sezioni della pagina. Breakpoint, controlli sui contenuti troppo alti, movimento ridotto e ripristino al resize restano nella logica sottostante: non occorre modificarli per regolare la velocità degli effetti. Per il parallax mantenere un ingrandimento sufficiente a coprire i bordi durante lo spostamento.


Gli effetti usano i campi di Section Text. GSAP è opzionale in Personalizza. Il controller è in `assets/js/custom.js`; gli stili in `_sections.scss`.

| Class sulla section | Effetto |
| --- | --- |
| `section-gsap-reveal` | Reveal a ingresso, un controllo scroll per titolo/paragrafo. |
| `section-gsap-reveal-scroll` | Reveal legato allo scroll, su tutti i capitoli. |
| `section-gsap-horizontal` | Capitoli scorrevoli orizzontali con pin. |
| `section-gsap-vertical` | Pannelli verticali sovrapposti con pin. |
| `section-gsap-lateral-word` | Primo titolo h1/h2 o `.gsap-lateral-text` lungo. |
| `section-gsap-70horizontal` / `section-gsap-30horizontal` | Due Section Text direttamente consecutive, più coppie indipendenti. |
| `section-bars` + una classe di posizione | Decorazioni limitate alla propria section. |

`parallax-gsap` appartiene invece a Inner Class del capitolo con Image. Il parallax di Gallery resta compatibile. Non viene applicato dentro pin strutturali o coppie 70/30. Jarallax sul Background Image è un sistema distinto.

Le modalità strutturali e le barre richiedono almeno 768 px e movimento consentito. Le classi `is-gsap-*` vengono aggiunte soltanto dal controller: senza GSAP, su mobile e con movimento ridotto il contenuto rimane nel normale flusso. I reveal possono funzionare anche su mobile, rispettando movimento ridotto. Masonry e carosello escludono le modalità strutturali/reveal di Text.

I resize ripristinano il contesto GSAP e ricreano misure, pin e parole. Non esistono spacer verticali manuali. Immagini e font aggiornano le misure. Per contenuti troppo alti i pannelli tornano statici; usa testi sintetici nelle composizioni a schermo. Le larghezze rimangono quelle di Inner Class. Le animazioni vengono ordinate prima del refresh per far convivere pin successivi.

I reveal usano una suddivisione interna dei nodi testuali, senza sostituire link/HTML e con ripristino del testo originale. Codice, pulsanti e contatori sono esclusi.



I pannelli verticali ereditano l’altezza della finestra attraverso container e riga. Il titolo laterale viene allineato a sinistra e centrato verticalmente; la dimensione si configura con `$gsap-lateral-title-size` in `_variables.scss`. Un titolo senza scorrimento e una coppia 70/30 senza contenuti eccedenti tornano al layout normale.

I pin, comprese le coppie 70/30, vengono creati nell’ordine delle section nel documento: ogni blocco successivo tiene conto dello spazio dei precedenti. Le coppie possono quindi precedere o seguire le altre modalità; resta necessario mantenere adiacenti le proprie fasce 70 e 30.


### Barre decorative: posizione, dimensioni e colore

Classi di posizione: `bar-top`, `bar-bottom`, `bar-left`, `bar-right`, `bar-top-left`, `bar-top-right`, `bar-bottom-left`, `bar-bottom-right`, `bar-center`, `bar-all`. Sceglierne una insieme a `section-bars`.

Le barre sono generate nella propria section con posizioni casuali: numero e disposizione dipendono dallo spazio disponibile e dal controllo delle sovrapposizioni. Da 768 a 1024 px le dimensioni sono 220–300 × 30 px; oltre 1024 px 280–380 × 35 px. Sotto 768 px il controller non le genera. Testo sopra le barre (`z-index` 3 contro 2), decorazioni non cliccabili e nascoste alle tecnologie assistive.

Il colore dipende dallo sfondo della section: `$grey` come base, con `bg-light` e `bg-primary`; `$light` con `bg-accent`, `bg-grey` e `bg-secondary`. Per cambiare queste combinazioni modificare il blocco Bars in `_sections.scss`, usando le variabili comuni.

## Caroselli Owl condivisi

Le classi funzionali con underscore scelgono la struttura Twig. I modificatori con trattini configurano il carosello. Inserirli nel campo **classi della sezione** oppure direttamente sul relativo `.owl-carousel` nei template. Le classi del carosello hanno precedenza a parità di opzione e breakpoint.

### Attivazione

| Contenuto | Classe della sezione |
|---|---|
| Testi / chapters | `section_carousel_text` |
| Gallery con più immagini | `gallery_carousel` |
| Sezione elenco / correlati | `section_archive_carousel` |
| Cube e slide | Automatico per `section_cube` / `section_slides` |
| Markup personalizzato di intestazione | Automatico se contiene `.carousel-header` e la struttura Owl prevista |

I modificatori non trasformano da soli una griglia in carosello: serve il markup `.owl-carousel` prodotto dalle modalità sopra. L'elenco principale di archive.twig rimane una griglia paginata. I correlati di single.twig sono già un carosello: personalizzarne le classi nel relativo `<section>`.

### Breakpoint

| Suffisso | Larghezza minima |
|---|---:|
| nessuno | 0 px |
| `sm` | 576 px |
| `md` | 768 px |
| `lg` | 992 px |
| `xl` | 1200 px |
| `xxl` | 1400 px |

Ogni valore esplicito rimane attivo fino al successivo override della stessa opzione. Le opzioni non specificate mantengono i valori del tipo di carosello. Non inserire classi contraddittorie per la stessa opzione e breakpoint.

### Valori numerici: lista delle famiglie supportate

| Classe | Funzione |
|---|---|
| `carousel-items-N` | Numero di elementi visibili, minimo 1 |
| `carousel-gap-N` | Distanza tra elementi in px |
| `carousel-padding-N` | Spazio laterale dello stage in px |
| `carousel-speed-N` | Durata della transizione in ms |
| `carousel-timeout-N` | Intervallo autoplay in ms |

Tutte supportano `carousel-{opzione}-{breakpoint}-N`, ad esempio `carousel-items-md-3` o `carousel-gap-xl-30`. I valori sono interi non negativi; solo `items` accetta decimali, scritti con `p`: `carousel-items-1p5`.

### Interruttori: lista completa

| Attiva | Disattiva | Funzione |
|---|---|---|
| `carousel-loop` | `carousel-no-loop` | Ripetizione infinita |
| `carousel-nav` | `carousel-no-nav` | Frecce |
| `carousel-dots` | `carousel-no-dots` | Pallini |
| `carousel-center` | `carousel-no-center` | Elemento centrale |
| `carousel-autoplay` | `carousel-no-autoplay` | Avanzamento automatico |
| `carousel-auto-height` | `carousel-no-auto-height` | Altezza adattata |
| `carousel-auto-width` | `carousel-no-auto-width` | Larghezza determinata dai contenuti |
| `carousel-rewind` | `carousel-no-rewind` | Ritorno all'inizio a fine elenco |
| `carousel-drag` | `carousel-no-drag` | Trascinamento mouse |
| `carousel-touch` | `carousel-no-touch` | Trascinamento touch |

Tutte supportano il suffisso breakpoint: `carousel-no-nav-md`, `carousel-autoplay-lg`, `carousel-no-auto-height-sm`.

`carousel-left` disattiva la centratura e applica il rientro laterale previsto dal tema. Non abilita autoWidth. Center e left usano i conteggi predefiniti del tipo; per scegliere conteggi differenti usare items.

Con autoWidth le larghezze dipendono dagli elementi: non aspettarsi un numero fisso di card anche impostando items. L'autoplay si arresta al passaggio del mouse ed è disattivato quando il dispositivo richiede movimento ridotto.

### Posizione e aspetto — solo SCSS

| Classe | Risultato |
|---|---|
| `carousel-nav-sides` | Frecce laterali, centrate verticalmente |
| `carousel-nav-top-left` | Frecce in alto a sinistra |
| `carousel-nav-top-right` | Frecce in alto a destra |
| `carousel-nav-bottom-left` | Frecce in basso a sinistra |
| `carousel-nav-bottom-right` | Frecce in basso a destra |
| `carousel-dots-inside` | Pallini dentro il carosello |
| `carousel-dots-outside` | Pallini sotto il carosello |
| `carousel-dots-left` | Pallini allineati a sinistra |
| `carousel-dots-center` | Pallini centrati |
| `carousel-dots-right` | Pallini allineati a destra |

Le posizioni non hanno suffissi responsive. Sono disponibili anche gli alias `owl-nav-top-left`, `owl-nav-top-right`, `owl-nav-bottom-left`, `owl-nav-bottom-right` e `owl-dots-inner`. Selezionare una sola posizione per frecce e una per pallini. Nav/dots possono essere nascosti automaticamente da Owl quando non c'è nulla da scorrere.

Tutti gli stili dei controlli risiedono in `assets/css/_plugins.scss`. Variabili CSS modificabili su `.owl-carousel`: `--carousel-nav-offset`, `--carousel-controls-gap`, `--carousel-dots-offset`, `--carousel-dot-size`, `--carousel-nav-size`. Colori basati su `$light`, `$dark`, `$accent`. Per i controlli esterni prevedere spazio con padding/margini della sezione. Dopo ogni modifica SCSS ricompilare `main.scss` in `main.css`.

### Valori predefiniti

| Tipo | Items: base / sm / md / lg / xl / xxl | Loop |
|---|---|---|
| Standard / gallery | 1 / 2 / 3 / 4 / 5 / 5 | sì |
| Testo | 1 / 2 / 3 / 3 / 4 / 4 | sì |
| Sezione archivio / correlati | 1 / 2 / 3 / 3 / 3 / 3 | no |
| Cube / slide | 1 / 1 / 1 / 1 / 1 / 1 | sì |

Base: gap 20 px (0 per cube/slide), nav e dots attivi , center/autoWidth/autoHeight disattivi. Autoplay solo nelle slide, con intervallo 5000 ms. Le slide conservano la dissolvenza e velocità 1000 ms.

### Esempi

Testo centrato: una card su mobile, due su tablet, tre su desktop; frecce solo da lg:

```text
section_carousel_text carousel-center carousel-items-1 carousel-items-md-2 carousel-items-xl-3 carousel-no-nav carousel-nav-lg carousel-dots
```

Gallery senza loop, con pallini interni e frecce in basso a destra:

```text
gallery_carousel carousel-no-loop carousel-items-1 carousel-items-lg-3 carousel-dots-inside carousel-nav-bottom-right
```

Correlati con quattro card da xl e distanze crescenti:

```text
section_archive_carousel carousel-items-1 carousel-items-md-2 carousel-items-xl-4 carousel-gap-15 carousel-gap-lg-30 carousel-no-dots
```

### Colore di frecce e punti Owl

| Classe | Effetto |
| --- | --- |
| `carousel-nav-light` | Frecce bianche |
| `carousel-nav-dark` | Frecce scure |
| `carousel-dots-light` | Punti bianchi: bordo non attivo e riempimento attivo |
| `carousel-dots-dark` | Punti scuri: bordo non attivo e riempimento attivo |

Usare nel campo Class della sezione, oppure direttamente sull’elemento Owl. Scegliere una modalità per nav e una per dots; sono indipendenti. Non cambiano dimensioni, forma, sfondo dei pulsanti o posizione. Senza classi colore rimane lo stile standard. Le classi applicate direttamente al carosello prevalgono sulla sezione.

Esempio su sfondo scuro: `carousel-nav-light carousel-dots-light`. Su sfondo chiaro: `carousel-nav-dark carousel-dots-dark`. Frecce esterne su pagina chiara e punti interni su foto scura: `carousel-nav-dark carousel-dots-light`.

## Pulsanti condivisi

- `templates/partials/buttons.twig`: gruppo opzionale di link con wrapper `.box-buttons`.
- `templates/partials/btn.twig`: singolo link con aspetto pulsante, URL filtrato, attributi escaped e protezione per target `_blank`.
- `assets/css/_typography.scss`: unico stile del gruppo, con inline-flex, wrapping e gap verticale/orizzontale. Nessun margine aggiuntivo sul secondo elemento.

### Utilizzo

```twig
{% include 'partials/buttons.twig' with {
    buttons: [
        { title: section.link_1.title, url: section.link_1.url, target: section.link_1.target, style: 'btn btn-primary' },
        { title: section.link_2.title, url: section.link_2.url, target: section.link_2.target, style: 'btn btn-secondary' }
    ],
    buttons_class: '',
    buttons_animation: ''
} only %}
```

`buttons` accetta anche un solo elemento o più di due. I link senza URL sono omessi; senza link il gruppo non viene generato. `buttons_class` aggiunge classi al wrapper; `buttons_animation` è opzionale. Gli allineamenti del contenitore restano validi perché il gruppo è inline-flex.

Usato da Text, Collapse, Slides, Cube e Maps. Per un singolo pulsante si può usare direttamente `btn.twig`.

## Shortcode Contacts

Ogni richiamo è indipendente, senza icone o gruppi. Fonte: Personalizza → Theme Fields.

- `intestazione`: Intestazione / ragione sociale — `[grit_contact field="intestazione"]`
- `piva`: Partita IVA — `[grit_contact field="piva"]`
- `rea`: Numero REA — `[grit_contact field="rea"]`
- `cap_soc`: Capitale sociale — `[grit_contact field="cap_soc"]`
- `indirizzo_1`: Indirizzo 1 — `[grit_contact field="indirizzo_1"]`
- `indirizzo_2`: Indirizzo 2 — `[grit_contact field="indirizzo_2"]`
- `indirizzo_3`: Indirizzo 3 — `[grit_contact field="indirizzo_3"]`
- `tel_1`: Telefono 1 — `[grit_contact field="tel_1"]`
- `tel_2`: Telefono 2 — `[grit_contact field="tel_2"]`
- `tel_3`: Telefono 3 — `[grit_contact field="tel_3"]`
- `mail_1`: Email 1 — `[grit_contact field="mail_1"]`
- `mail_2`: Email 2 — `[grit_contact field="mail_2"]`
- `mail_3`: Email 3 — `[grit_contact field="mail_3"]`
- `fax`: Fax — `[grit_contact field="fax"]`
- `facebook`: Facebook — `[grit_contact field="facebook"]`
- `instagram`: Instagram — `[grit_contact field="instagram"]`
- `linkedin`: LinkedIn — `[grit_contact field="linkedin"]`
- `tiktok`: TikTok — `[grit_contact field="tiktok"]`

| Attributo | Valore predefinito | Uso |
| --- | --- | --- |
| `field` | Vuoto | Nome del dato nella lista sopra. |
| `label` | Valore salvato | Testo o HTML limitato del collegamento. |
| `class` | Vuoto | Classi del contenitore. |
| `tag` | `span` | `span`, `p`, `div`, `h2`, `h3`, `h4`. |
| `link` | `true` | `false` per visualizzare solo il testo. |

Link sempre target="_blank" con rel="noopener noreferrer". Telefoni: tel:; email: mailto:; social: URL HTTP/HTTPS. Indirizzi: indicazioni Google Maps con destinazione codificata. Altri dati testo. Campi vuoti omessi. CF7 usa il proprio shortcode. Per documentare gli esempi senza eseguirli usare doppie parentesi quadre.

Esempio indirizzo: `[grit_contact field="indirizzo_1" label="Raggiungici"]`. Usa `link="false"` per il solo testo.

Label con HTML limitato: sono ammessi i e span (class, aria-hidden), strong ed em. Non sono ammessi script, eventi o link annidati. Per icone Font Awesome usare apici singoli negli attributi HTML, dentro label delimitata da doppi apici:

`[grit_contact field="tel_1" label="<i class='fas fa-phone' aria-hidden='true'></i> Chiamaci"]`

Mantenere un testo leggibile accanto all’icona per l’accessibilità.

### Esempi Contacts pronti da adattare

```text
[grit_contact field="tel_1" label="Chiamaci"]
[grit_contact field="mail_1" label="Scrivici"]
[grit_contact field="indirizzo_1" label="Apri le indicazioni"]
[grit_contact field="indirizzo_1" link="false" tag="p"]
[grit_contact field="tiktok" label="Seguici su TikTok"]
[grit_contact field="tel_1" label="<span class='btn btn-primary'>Chiamaci</span>"]
```

Nell’ultimo esempio la label contiene uno span con le classi del pulsante; il collegamento telefonico viene generato dallo shortcode. Non inserire lo shortcode nel campo URL di un pulsante ACF: quel campo richiede un URL e non lo esegue. L’attributo `class` di Contacts si applica al contenitore, non direttamente al link generato. Un numero o un’email non validi possono essere mostrati come testo senza collegamento; correggere il dato in Personalizza.

## Shortcode Counter

Il contatore è uno shortcode utilizzabile nei contenuti e nel testo dei capitoli di Section Text.

### Utilizzo

```text
[grit_counter number="220" prefix="n°" suffix="site"]
```

Usare il blocco Shortcode di Gutenberg oppure un campo WYSIWYG ACF formattato. Se si inserisce lo shortcode in una normale stringa Twig non elaborata, non viene eseguito automaticamente: serve un percorso che applichi do_shortcode. Non serve una sezione specifica.

| Attributo | Default | Funzione |
|---|---|---|
| number | 0 | Numero senza separatori delle migliaia |
| prefix | vuoto | Testo prima del numero |
| suffix | vuoto | Testo dopo il numero |
| duration | 3000 | Millisecondi, da 0 a 60000 |
| repeat | false | true per ripetere al rientro in vista |
| animate | true | false per mostrare subito il risultato |
| tag | span | span, p, div, h2, h3, h4 |
| class | vuoto | Classi del contenitore |

Sono ammessi negativi e decimali con punto o virgola: 1250, -20, 12.5, 12,5. Un solo punto o virgola è interpretato come separatore decimale: 1.000 non significa mille. Massimo sei decimali e precisione numerica sicura JavaScript; gli altri testi restano visibili senza animazione. L’animazione usa il controller del tema in `assets/js/custom.js`.

```text
[grit_counter number="12,5" suffix="%" duration="2000" tag="h3"]
[grit_counter number="220" animate="false" prefix="n°"]
[grit_counter number="1000" repeat="true" duration="1500"]
```

Il markup include il valore finale per chi non usa JavaScript e una versione stabile per screen reader. Il movimento ridotto disattiva l’animazione. L’animazione parte all’ingresso in vista e si esegue una volta salvo repeat.

### HTML diretto

Funziona anche fuori da qualsiasi sezione:

```html
<h3>n° <span class="sr-only">220</span><span class="number-animate" aria-hidden="true" data-counter-end="220" data-counter-decimals="0" data-counter-duration="3000" data-counter-repeat="false" data-counter-animate="true">220</span> site</h3>
```

Gli attributi data-counter-* del numero hanno precedenza sulle opzioni ereditate tramite classi. Il componente shortcode è gestito in core/extras.php; animazione in assets/js/custom.js; stile numerico in assets/css/_shortcodes.scss.

## Shortcode Video

Il player si usa in Section Text o nei contenuti tramite shortcode. Gli stili condivisi sono nel blocco `.grit-video` di `assets/css/_shortcodes.scss`.

`[grit_video file="266" preview="239"]`

`[grit_video url="https://www.youtube.com/watch?v=7XXu_-eoxHo"]`

| Attributo | Uso |
| --- | --- |
| file | ID video della Libreria Media |
| url | URL YouTube/Vimeo, alternativo a file |
| preview | ID copertina, facoltativo |
| ratio | landscape (16:9), portrait (9:16), square (1:1) |
| fit | contain (default) o cover; file locali |
| loop | false (default) o true; file locali |
| class | Classi del contenitore del player |

Sostituire gli ID degli esempi con quelli dei media del progetto. Un file valido ha precedenza su URL. Nessuna sorgente valida: nessun output. Preview invalida viene ignorata. URL noti dei provider sono convertiti senza richieste oEmbed ripetute.

Con copertina: vero pulsante accessibile, poster per il file locale, iframe esterno inserito al clic. Senza copertina: controlli disponibili subito; i file caricano metadati e richiedono un frame a 0.01 secondi senza autoplay. Se la sorgente inizia con nero, usare Preview. Il browser/provider può bloccare il play automatico richiesto dopo clic: restano i controlli.

Usare in Gutenberg (blocco Shortcode) o nel Testo dei Chapters. Per due player affiancati usare due capitoli con Inner Class col-12 col-md-6. Per documentare la sintassi senza eseguirla usare doppie parentesi: [[grit_video file="266"]]. I campi URL dei pulsanti non interpretano shortcode.

Il caricamento al clic non sostituisce il consenso. Il controller non promuove data-src a src; verificare il blocco effettivo nel plugin privacy, soprattutto senza Preview. Non sono previsti pausa automatica degli altri player o sottotitoli generati. Fit/loop non configurano il player remoto.

Codice PHP in `core/extras.php`; template `templates/partials/video.twig`; controller `initializeGritVideos` in `assets/js/custom.js`.

Gli URL YouTube condivisi mantengono la posizione iniziale (start oppure t, anche 1m30s); i link Vimeo non in elenco mantengono il codice h nel percorso o nella query. Un parametro non valido non viene trasformato in codice HTML.

## Card Tease

Scrivi il nome nel campo testo Tease di Section Archive, senza tease- o .twig.

| Nome | Uso |
| --- | --- |
| card | Card semplice: immagine, titolo, anteprima |
| vertical | Card verticale con categorie, immagine, titolo e anteprima |
| horizontal | Immagine e testo affiancati da md, impilati su mobile |
| compact | Miniatura quadrata piccola e testo breve affiancato |
| text | Titolo e anteprima, nessuna immagine |
| title | Solo titolo e collegamento, senza bordo |
| editorial | Immagine, categorie, data, anteprima, pulsante e tag |
| overlay | Testo su immagine con gradiente scuro; fondo scuro se manca la foto |

Alias disponibili: post → editorial; section → card. Product è un template specifico WooCommerce, disponibile solo con l’integrazione richiesta; non è una variante generica.

Tutte le card generiche estendono tease.twig: classi e data-post-id condivisi, nessun ID duplicato. Le immagini usano card-image.twig (WordPress srcset e alt Media Library), le anteprime il relativo helper senza eseguire shortcode. Nessun effetto GSAP obbligatorio. Gli stili delle varianti sono centralizzati nel blocco Tease di assets/css/_sections.scss.

Inner Class governa le colonne della griglia; in carosello il numero visibile è gestito da Owl. Per horizontal preferire card sufficientemente larghe (per esempio col-12 col-lg-6). I contenuti restano visibili anche senza immagine; le varianti title e text non la mostrano intenzionalmente.

### Informazioni del post nei template

`templates/partials/tease.twig` conserva una legenda commentata con esempi dei dati Timber disponibili: titolo, permalink, ID, date, excerpt, immagine, autore, tassonomie e campi. Il commento non viene mostrato nel frontend.

```twig
<h2><a href="{{ post.link|e('html_attr') }}">{{ post.title|e }}</a></h2>
<p>{{ function('grit_archive_excerpt', post, 35)|e }}</p>
{% for term in post.terms('category') %}
    <a href="{{ term.link|e('html_attr') }}">{{ term.name|e }}</a>
{% endfor %}
```

Nel contesto condiviso `home` è l’URL pubblico restituito da `home_url()`, `agency` contiene il branding validato e i menu sono esposti con i nomi `primary_menu`, `secondary_menu`, `mobile_menu`, `footer_menu`, `bio_menu`. `post`, campi ACF, titolo e risultati vanno interpretati in base alla vista: un archivio nativo non è sempre una pagina. Non applicare escaping testuale al contenuto HTML formattato quando deve essere renderizzato come markup; effettuare invece escaping su titoli, attributi e valori puntuali.

## Archivi WordPress e ricerca

### Archivio principale e Section Archive sono diversi

`archive.php` gestisce la pagina dei risultati WordPress e la sua paginazione; Section Archive costruisce invece una selezione indipendente senza paginazione numerata. Masonry cambia la disposizione, non aggiunge automaticamente nuove pagine di risultati.

| Situazione | Origine dei risultati e dei campi |
| --- | --- |
| Archivio CPT nativo | Query principale WordPress; può caricare contenuti e ACF da una pagina pubblicata associata allo slug. |
| Pagina con Template Archive | Query separata e paginata per il CPT associato al percorso della pagina. |
| Pagina articoli | Pagina scelta in Impostazioni → Lettura e query blog. |
| Categoria, tag o tassonomia | Query principale del termine; ACF del termine corrente, se i gruppi vi sono abilitati. |
| Ricerca nativa | Query principale WordPress, con pagina guida associata facoltativa. |
| Autore | Query autore e identità dell’autore; non carica automaticamente una pagina con le sue section ACF. |

### Associazione pagina e CPT

Il controller confronta il percorso della pagina con nome del post type, `has_archive` quando è una stringa e slug `rewrite`. Esempio: un CPT `progetto` con rewrite `progetti` può essere associato alla pagina `progetti`. Una pagina `blog` può rappresentare i normali post. L’associazione deve essere univoca; senza corrispondenza valida la pagina Template Archive non mostra post estranei come ripiego.

`has_archive` e `rewrite` hanno ruoli diversi: il primo abilita/definisce l’archivio nativo, il secondo configura la riscrittura degli URL. Impostare soltanto `rewrite => true` non garantisce l’esistenza di un archivio CPT. Verificare la registrazione del CPT, i conflitti di slug e i permalink.

Se l’archivio nativo non ha una pagina associata, continua a funzionare con i dati nativi; non esiste un ID pagina da cui recuperare le section ACF. Le pagine protette non vengono usate per esporre contenuti senza password.

### Scegliere i post type negli archivi dei termini

Modificare soltanto `$archive_post_types` nella funzione `grit_taxonomy_archive_post_types()` in `core/extras.php`:

```php
$archive_post_types = [
    'category' => ['post'],
    'post_tag' => ['post', 'section'],
    // 'settore' => ['progetto'],
];
```

- `[]`: tipi pubblici associati alla tassonomia; conserva eventuali filtri espliciti già impostati nella query.
- `['post']`: solo articoli del blog.
- `['section']`: solo Sections, se la tassonomia vi è associata.
- Una lista esplicita prevale sui filtri URL `post_type` e viene intersecata con i tipi realmente associati.
- Nomi invalidi/non associati non devono mostrare contenuti estranei.

Questo filtro modifica la query prima della paginazione e non cambia le assegnazioni dei termini ai contenuti.

### Varianti Twig degli archivi

Duplicare il template in `templates/` seguendo la priorità del controller:

| Archivio | Priorità specifica → generica |
| --- | --- |
| CPT | `archive-{post_type}.twig` → `archive.twig` → `index.twig`. |
| Categoria | `category-{slug}.twig` → `category-{ID}.twig` → `category.twig` → `archive.twig` → `index.twig`. |
| Tag | `tag-{slug}.twig` → `tag-{ID}.twig` → `tag.twig` → `archive.twig` → `index.twig`. |
| Tassonomia custom | `taxonomy-{taxonomy}-{term-slug}.twig` → `taxonomy-{taxonomy}.twig` → `taxonomy.twig` → `archive.twig` → `index.twig`. |

`post_type` e `taxonomy` sono nomi registrati, non etichette amministrative. `archive-progetto.twig` usa il nome CPT, non necessariamente lo slug rewrite `progetti`. La gerarchia Twig è costruita in PHP: rinominare un file con un nome arbitrario non lo rende selezionabile.

### Ricerca con section prima e dopo i risultati

Le chiamate native WordPress a `get_search_form()` usano `templates/partials/searchform.twig` tramite il filtro in `core/utils.php`. Il partial conserva il termine cercato e genera un ID univoco per il campo di ogni form.

`search.php` cerca una pagina associata in questo ordine: pagina corrente con Template Search, pagina pubblicata `search` o `cerca`, unica pagina pubblicata assegnata al template Search. Se la trova, carica contenuti e ACF della pagina e rende Section Text, Section Page e gli altri layout nelle posizioni pre/post content.

La ricerca nativa conserva la query di WordPress. La pagina Search costruisce i risultati per il termine cercato; senza termine non mostra un elenco casuale di contenuti. I campi della pagina non sostituiscono i risultati con una seconda lista indipendente.

Gli helper `grit_template_fields()`, `grit_template_content()` e `grit_template_query()` in `core/extras.php` centralizzano campi, contenuto formattato, conteggi e intervalli. Non usare un ID pagina fittizio per una vista che non possiede una pagina associata.

## Header footer menu e form

### Articoli e commenti

Il layout del singolo contenuto è in `templates/single.twig`: categorie e titolo, estratto facoltativo, autore e data, immagine in evidenza, testo e tag. Le Sections ACF si possono inserire prima e dopo il contenuto; i correlati dipendono dalla query in `single.php`.

`comments.php` presenta elenco e modulo nativi WordPress. Le classi in `$comment_styles` regolano riquadri, avatar, spaziature e pulsanti usando le utility del tema. I campi ereditano lo stile globale dei form; Invio, Rispondi e Annulla risposta usano le classi `btn`.

- Abilitare i commenti in **Impostazioni → Discussione**, sul singolo contenuto e nel Customizer (opzione **Disable comments** disattivata). Il tipo di contenuto deve supportare i commenti.
- Nome ed email seguono l’impostazione WordPress che li rende obbligatori. L’email non è pubblicata; il campo Sito web non è presente. Chi è collegato usa i dati del proprio account.
- La spunta per ricordare nome ed email nel browser è facoltativa e compare se abilitata nelle impostazioni Discussione.
- L’accettazione della privacy è obbligatoria anche per gli utenti collegati. Configurare e pubblicare la pagina Privacy in **Impostazioni → Privacy**; il modulo ne usa il link. `grit_validate_comment_form()` in `core/extras.php` controlla la spunta negli invii dal modulo nativo.
- Registrazione obbligatoria, moderazione, notifiche e profondità delle risposte si gestiscono nelle impostazioni Discussione. Il link Modifica è riservato agli utenti autorizzati e apre il backend.


### Bio / Link in bio

Usare lo slug `bio` e il template predefinito: il tema carica automaticamente `page-bio.twig`. Cambiando slug occorre rinominare anche il Twig corrispondente. La pagina usa un layout essenziale senza menu principale, loader o footer esteso. Le Sections ACF prima/dopo il contenuto restano disponibili.

- Nome: titolo del sito. Presentazione: contenuto della pagina; se vuoto, motto del sito.
- Foto: immagine in evidenza della pagina; in alternativa logo del sito o iniziale del nome. Non vengono richieste immagini a servizi esterni.
- Collegamenti: il setup crea il menu **Bio Navigation**, lo assegna alla posizione **Bio Navigation** e inserisce About e Contatti con una descrizione iniziale. Aggiungere le proprie voci a un solo livello da **Aspetto → Menu → Bio Navigation**. Titolo, descrizione, ordine e apertura in nuova scheda si gestiscono nel menu. Se il campo Descrizione non è visibile, abilitarlo in **Impostazioni schermata → Descrizione**; il testo compare sotto il titolo nella Bio. Il collegamento al sito resta sempre disponibile.
- Contatti: Theme Fields di Personalizza. Email, telefono e indirizzo usano il secondo recapito. Il terzo telefono è usato per WhatsApp e deve includere il prefisso internazionale.
- Social: Instagram, LinkedIn, Facebook e TikTok vengono mostrati quando il relativo campo è compilato, anche con il segnaposto `#` per le prove. I campi vuoti non generano collegamenti.
- Condivisione: il link WhatsApp condivide l’indirizzo della Bio. Il footer compatto richiama le policy pubblicate.

Contatti e social si modificano direttamente in `templates/page-bio.twig`; il menu viene esposto nel contesto condiviso come gli altri menu.

Gli stili sono nel blocco `section_bio` di `_sections.scss` e usano la palette del tema. Non servono plugin o JavaScript aggiuntivi.


### Header

Selezionare la variante in Personalizza. Ogni variante ha un proprio file Twig modificabile.

| Valore | Layout |
| --- | --- |
| `header_1` | Classico, menu mobile espandibile. |
| `header_2` | Classico, overlay mobile. |
| `header_3` | Barra flottante arrotondata. |
| `header_4` | Trasparente con blocchi separati. |
| `header_5` | Logo centrale tra due menu. |

Modificare `templates/headers/header_N.twig` e `_header.scss`. Menu condiviso in `templates/headers/menu.twig`; social centralizzati in `templates/headers/nav-social.twig`. Conservare gli ID distinti dei menu normale/sticky e i collegamenti dei pulsanti di apertura. Le animazioni overlay gestiscono la comparsa ritardata degli elementi e rispettano il movimento ridotto.

Il menu della Bio usa la posizione `bio_navigation` ed è disponibile in Twig come `bio_menu`, seguendo la stessa convenzione di `primary_navigation` → `primary_menu`.

Posizioni registrate: `primary_navigation`, `secondary_navigation`, `mobile_navigation`, `footer_navigation`, `bio_navigation`. Assegnarle da Aspetto → Menu. Header con due gruppi di navigazione richiedono le assegnazioni appropriate; non duplicare gli ID per simulare più menu.

### Footer

| Valore | Layout |
| --- | --- |
| `footer_1` | Colonne e newsletter. |
| `footer_2` | Menu orizzontale. |
| `footer_3` | Centrato. |
| `footer_4` | Invito al contatto. |
| `footer_5` | Menu editoriale. |

Template in `templates/footers/`; stili in `_footer.scss`. `_variables.scss` contiene `$footer-1-background` fino a `$footer-5-background` e le dimensioni comuni. La scelta del fondo determina il tema cromatico del footer secondo le regole Sass presenti: controllare anche logo e pulsanti quando si cambia palette. Si applica alla compilazione, non leggendo a runtime qualsiasi immagine di sfondo.

Aree widget registrate in `core/init.php`: Primary, Pre Footer, Footer Col 1–4 e Footer Bottom. Il loro rendering effettivo dipende dalla variante di template. Un campo o widget vuoto non crea automaticamente il suo contenuto; per newsletter e form serve la relativa configurazione.

### Form

Impostare in `assets/css/_variables.scss`:

```scss
$form-style: 1; // 1, 2 oppure 3
```

| Variante | Aspetto |
| --- | --- |
| 1 | Campi pieni, con fondo e angoli secondo le variabili comuni. |
| 2 | Campi trasparenti con linea inferiore. |
| 3 | Campi trasparenti con bordo, angoli morbidi e ombra leggera. |

Ricompilare Sass. Le tre varianti sono definite in `_forms.scss`; `form-style-1`, `form-style-2` e `form-style-3` permettono una scelta locale esplicita sul contenitore previsto. Prima di rinominare classi come `contact-form-style-*`, verificarne gli utilizzi nei template e nei contenuti salvati.

I form CF7 si inseriscono con il loro shortcode:

```text
[contact-form-7 id="123" title="Contatti"]
```

L’ID deve appartenere a un modulo reale del sito. Verificare invio email, messaggi di errore, consenso e configurazione del server: lo stile del tema non garantisce la consegna delle email.

## Colori SCSS e personalizzazione

### Entrata e responsabilità

| File | Modifiche previste |
| --- | --- |
| `_variables.scss` | Palette, font, breakpoint, spaziature e valori condivisi. |
| `_content.scss` | Struttura generale e utility. |
| `_typography.scss` | Tipografia, combinazioni cromatiche e gruppi dei pulsanti. |
| `_sections.scss` | Layout delle section, gallery, card, Masonry e Maps. |
| `_plugins.scss` | Presentazione dei componenti delle librerie, in particolare frecce e dots Owl. |
| `_header.scss`, `_footer.scss` | Navigazione e footer. |
| `_forms.scss` | Tre stili form e stati dei controlli. |
| `_shortcodes.scss` | Componenti counter/video e stili degli shortcode. |
| `main.scss` | Import dei partial; compilare questo file in `main.css`. |

Usare le variabili della palette, come `$accent`, `$primary`, `$secondary`, `$light`, `$dark`, `$grey`, `$black` e `$white`, anziché ripetere valori esadecimali nei componenti. Le classi `bg-*`, `color-*` e le utility tipografiche esistenti consentono molte composizioni direttamente in ACF.

`$breakpoints` e gli alias derivati in `_variables.scss` centralizzano i valori del tema. Bootstrap è distribuito come CSS già compilato: cambiare una mappa Sass del tema non ricompila automaticamente i breakpoint del pacchetto Bootstrap o quelli numerici di un controller JavaScript. Se si cambiano i breakpoint del progetto verificarne la coerenza fra griglia, SCSS e JS.

### Tabelle nei contenuti e nelle guide

Per una tabella HTML con bordi e spaziatura usa `table table-bordered`; racchiudila in `table-responsive` per consentire lo scorrimento orizzontale su mobile. Il solo tag `figure` non aggiunge bordi: l’aspetto dipende dalle classi e dal foglio di stile caricato.

```html
<div class="table-responsive mb-4">
    <table class="table table-bordered mb-0">
        <thead>
            <tr><th scope="col">Campo</th><th scope="col">Utilizzo</th></tr>
        </thead>
        <tbody>
            <tr><td>Class</td><td>Classi della sezione</td></tr>
        </tbody>
    </table>
</div>
```

Nell’editor a blocchi, il blocco Tabella genera un wrapper `figure.wp-block-table`: conservarlo quando si modifica quel blocco. Per le guide convertite da Markdown, applicare le classi dell’esempio alle tabelle generate, incluse quelle degli esempi, senza cambiare i contenuti ACF.

### Colori e trasparenza

```scss
$black-50: #808080;             // Colore opaco grigio.
$black-50-rgb: $black-50;       // Resta un valore Sass di tipo colore.
$black-50-rgba: rgba($black, .5); // Nero con trasparenza del 50%.
```

Un colore esadecimale è utilizzabile nelle funzioni colore Sass. Il suffisso `-rgb` nel nome non lo trasforma in una lista `128, 128, 128`: il formato CSS emesso dipende dal contesto. Grigio opaco e nero semitrasparente non danno lo stesso risultato sopra qualsiasi fondo.

### Pulsanti e caratteri

Modificare le combinazioni cromatiche dei pulsanti nelle mappe/regole di `_typography.scss` e i valori in `_variables.scss`. Il tema non deve sostituire la decisione progettuale sulle combinazioni: controllare normale, hover, focus, disabled e contrasto su ogni sfondo usato.

`btn-sm` e `btn-lg` regolano le dimensioni previste dal componente. Le classi display-1…display-6 offrono titoli responsive già definiti. Prima di introdurre una nuova utility cercare se esiste nel tema o in Bootstrap.

### Compilazione

Dalla cartella del tema, con Dart Sass disponibile:

```bash
sass assets/css/main.scss assets/css/main.css --style=expanded
```

Non modificare soltanto il risultato compilato. Verificare diff, errori Sass, cache e resa su schermi diversi dopo ogni modifica. `custom.css` e `custom.js` sono asset caricati dal tema, ma non vanno usati per duplicare configurazioni comuni già centralizzate.

## Branding dell’agenzia

La selezione è all’inizio di `functions.php`, prima del caricamento dei moduli:

```php
if (!defined('GRIT_AGENCY')) {
    define('GRIT_AGENCY', 'gritlab');
}
```

Il valore corrisponde a `agency_folder` in `assets/credits/credits.json`. Record distribuiti: `gritlab`, `astratto`, `poliedro`. L’ordine dei record non seleziona l’agenzia; una selezione mancante o invalida usa il fallback GRIT. Un child theme può definire la costante prima del caricamento del parent.

Ogni record contiene nome e URL agenzia, dati cliente, nome tema, crediti autore, cartella asset e colore esadecimale del login. Non sostituire URL o campi con valori non validi: il lettore comune valida e completa i dati mancanti.

File in `assets/credits/<agency_folder>/`:

| File | Utilizzo |
| --- | --- |
| `logo.png` | Logo login. |
| `icon.svg` | Icona della barra amministrativa. |
| `screenshot.png` | Anteprima del tema parent. |
| `screenshot-child.png` | Anteprima del child, solo quando un child separato è attivo. |

I singoli asset mancanti usano quelli della cartella `gritlab`. Le cartelle ammettono lettere minuscole, numeri, trattini e underscore.

Logo, colore login e crediti leggono il record alla richiesta successiva. Nome del tema e anteprime vengono sincronizzati anche all’apertura dell’amministrazione da parte di un utente con il permesso di gestire le opzioni del tema: basta cambiare `GRIT_AGENCY` e ricaricare una pagina amministrativa. Attivazione e salvataggio del setup mantengono la stessa sincronizzazione. Conservare le anteprime personalizzate nella cartella dell’agenzia, da cui vengono copiate nella radice del tema parent e del child attivo. Vengono scritti soltanto i file diversi e scrivibili; dopo un aggiornamento viene invalidata la cache dei temi di WordPress. La sincronizzazione non viene eseguita nel frontend.

In PHP:

```php
$agency = grit_agency_data();
$agency_url = $agency['agency_url'];
```

In Twig il contesto contiene `agency`; usare `{{ agency.agency }}` e `{{ agency.agency_url }}` con escaping adatto al punto di inserimento. Non usare il branding agenzia come sostituto dei dati aziendali del cliente in Theme Fields.

Funzioni di riferimento: `grit_agency_data()`, `grit_agency_asset()`, `grit_sync_agency_screenshots()` in `core/extras.php`; applicazione metadati in `core/activation.php`; presentazione amministrativa in `core/admin-customizer.php`.

## SEO consenso servizi esterni e integrazioni

### Breadcrumb e SEO

Usare la funzione di Yoast prevista dal progetto e il relativo shortcode, dove registrato dal plugin:

```text
[wpseo_breadcrumb]
```

Attivare/configurare i breadcrumb in Yoast e verificare che lo shortcode venga interpretato nel campo utilizzato. Non inserire breadcrumb duplicati nel template e nel contenuto. Il tema non sostituisce la configurazione di titoli, descrizioni, sitemap e indicizzazione del plugin SEO.

### Privacy e tracciamento

Privacy e Cookie Policy usano il template predefinito e gli slug `privacy-policy` e `cookie-policy`, che richiamano i rispettivi file `page-{slug}.twig`. La pagina Privacy di riferimento si sceglie in Impostazioni → Privacy; per la Cookie Policy il footer cerca lo slug `cookie-policy`. Le istruzioni di setup e riutilizzo delle pagine sono nel README.

La gestione del consenso e l’eventuale Analytics si configurano nel sistema adottato dal progetto. Complianz è un’integrazione opzionale. Il campo Google Tag Manager accetta l’ID completo `GTM-…`: vuoto disattiva il caricamento dal tema. Se Complianz è configurato per caricare GTM, il tema gli delega il caricamento; senza Complianz il campo funziona autonomamente. Il caricamento dal tema non configura il consenso. Hotjar ha un’impostazione separata: evitare doppie integrazioni e verificare che gli script siano effettivamente bloccati prima del consenso quando richiesto.

Maps, video YouTube/Vimeo, font e altri servizi esterni possono effettuare richieste verso terzi. Il semplice caricamento al clic o l’esistenza di un campo API non sostituiscono la configurazione del consenso. Testare accettazione e revoca, oltre al primo accesso.

### Google Maps

Configurare una chiave con Maps JavaScript API e le autorizzazioni richieste dal progetto Google Cloud. Le restrizioni per siti web devono includere il dominio e il protocollo usati, compreso l’ambiente locale quando lo si testa. Verificare gli errori reali di console e configurazione del servizio senza pubblicare chiavi non necessarie nella documentazione.

### WooCommerce e altre integrazioni

Template e file WooCommerce presenti non significano che l’intero modulo sia attivo. Controllare plugin, include in `functions.php`, supporti del tema e template del progetto prima di adottare `tease-product` o modificare pagine shop/prodotto. Le librerie opzionali richiedono un componente/configurazione che le utilizzi: non promettere funzionalità soltanto perché esiste un interruttore.

## Aggiornamenti controlli e risoluzione problemi

### Aggiornare un progetto

L’import del setup ACF salta i gruppi con la stessa chiave già presente: per aggiornare le definizioni su un sito esistente usare gli strumenti ACF e verificare il risultato, non limitarsi a salvare nuovamente Configurazione del tema.

1. Salvare file e database, comprese opzioni Personalizza e contenuti ACF.
2. Verificare le modifiche locali prima di sostituire il tema o importare JSON.
3. Installare le dipendenze dalla configurazione/lock previsti; non aggiornare indiscriminatamente Timber o le librerie.
4. Importare le definizioni ACF necessarie senza alterare chiavi/layout già usati senza migrazione.
5. Ricompilare Sass se sono cambiati i sorgenti.
6. Svuotare la cache pertinente e verificare frontend e amministrazione.

Se il progetto modifica nomi o struttura dei layout ACF, prevedere una migrazione esplicita dei contenuti: sostituire i file del tema non converte i dati salvati nel database.

### Controlli proporzionati alla modifica

- Sintassi PHP e JavaScript dei file cambiati.
- Compilazione SCSS e verifica del CSS risultante.
- Rendering Twig con dati vuoti, uno o più elementi e testi lunghi.
- Home, pagina, singolo, categoria, tag, tassonomia, archivio CPT e ricerca, incluse pagine senza risultati.
- Menu mobile/overlay, tastiera, focus, pulsanti e layout su viewport diversi.
- Più istanze di caroselli/Maps/GSAP e resize; libreria opzionale disattivata e movimento ridotto.
- Link, immagini, invio form, consenso e servizi esterni sul dominio effettivo.

I controlli di sviluppo non certificano tutte le combinazioni future di plugin e contenuti.

| Sintomo | Verifica |
| --- | --- |
| Timber mancante | Composer e `vendor/autoload.php`; versione Timber compatibile con il codice 1.x. |
| Campi non visibili | ACF PRO attivo, JSON importato e regole di posizione corrette. |
| Funziona solo Home | Dominio/DNS, virtual host, permalink e riscritture del server. |
| Categoria vuota | Assegnazioni termini, tassonomia associata al CPT, `$archive_post_types` e query principale. |
| Section Archive nascosta | Filtri validi, contenuti pubblicati, tassonomia associata o termini disponibili. |
| Niente frecce Owl | Libreria attiva, più elementi di quelli visibili, classi nav, breakpoint e spazio per controlli esterni. |
| Gallery con immagini sfocate | Dimensione ACF, originali disponibili, miniature/srcset reali; il CSS non aumenta la risoluzione. |
| GSAP statico | Interruttore, viewport, movimento ridotto, classe corretta, contenuto eccedente o pannelli troppo alti. |
| Barre invisibili | GSAP e viewport abilitati, colore di fondo/contrasto, altezza disponibile. |
| Mappa assente | Chiave, restrizioni dominio, servizio Google, consenso, coordinate e console. |
| Shortcode mostrato letteralmente | Campo/contesto che applica `do_shortcode`; ID e nome shortcode validi. |
| Esempio shortcode eseguito nella guida | In WordPress documentare con doppie parentesi quadre. |
| Modifica SCSS non visibile | Compilazione di `main.scss`, asset effettivamente caricato e cache. |

Consultare i log pertinenti evitando di pubblicare dati personali o credenziali. Non nascondere un errore disattivando globalmente i controlli: verificare la causa nel componente coinvolto.

## Licenze

Non eliminare i README, i changelog e le licenze delle librerie dentro `assets/`, né i file di licenza dei pacchetti Composer. Il loro contenuto e la loro manutenzione appartengono ai rispettivi autori. La licenza del tema è nel file `LICENSE`; non copre automaticamente media, font e dipendenze con licenza propria.


## Traduzioni dell’interfaccia

I testi traducibili PHP e Twig del dominio `grit` usano l’inglese come lingua sorgente. `lang/grit.pot` contiene le voci correnti; `lang/it_IT.po` contiene le traduzioni italiane e `lang/it_IT.mo` è il catalogo compilato letto da WordPress. Dopo aver aggiornato il PO, ricompilare con `msgfmt --check -o lang/it_IT.mo lang/it_IT.po`. Quando si aggiungono o cambiano testi, aggiornare anche POT, riferimenti e traduzioni, conservando i segnaposto come `%s` e `%d`. La lingua dell’amministrazione segue il profilo WordPress; quella pubblica segue la lingua del sito. I contenuti demo, le email di esempio e i testi legali statici non vengono tradotti dal catalogo.
