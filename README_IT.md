# GRIT Theme

[README in inglese](README.md) · [Guida in inglese](GUIDE.md)

Starter WordPress per agenzie, freelance e sviluppatori che vogliono una base condivisa per costruire siti personalizzati. Usa PHP e Timber/Twig per i template, ACF PRO per i contenuti, SCSS per gli stili e JavaScript per i componenti interattivi.

La grafica e le possibilità offerte al cliente vengono definite dall’agenzia; testi, immagini e impostazioni previste si gestiscono nei campi WordPress e ACF.

- **Questo file:** requisiti, installazione e primo avvio.
- **[GUIDE_IT.md](GUIDE_IT.md):** utilizzo delle section, classi, shortcode, archivi, librerie e personalizzazione del codice.
- **[Repository](https://github.com/gritlab-it/grit-theme)** · **[Segnalazioni](https://github.com/gritlab-it/grit-theme/issues)**

## Requisiti

| Elemento | Indicazione |
| --- | --- |
| WordPress | Installazione funzionante, accesso amministratore e permalink configurabili. |
| PHP | Ambiente di riferimento del progetto: PHP 8.2. Verificare anche la compatibilità dei plugin sul server di destinazione. |
| Composer | Necessario nell’ambiente di sviluppo per installare le dipendenze PHP se `vendor/` non è già disponibile. |
| Timber e Twig | Il tema dichiara `timber/timber: ^1.0` in `composer.json`; Twig arriva come dipendenza di Timber. Non sostituire con Timber 2 senza una migrazione. |
| ACF PRO | Necessario per Flexible Content, Repeater e gli altri campi del tema. Installazione e licenza si gestiscono separatamente. |
| Sass | Necessario solo per modificare e ricompilare gli SCSS; il frontend usa il CSS compilato. |

Non è implementata un’installazione automatica di Composer/Twig all’attivazione del tema. Le versioni dei plugin e delle librerie vanno verificate per il progetto: questo manuale non dichiara compatibilità universale con ogni versione futura.

## 1. Installare il tema

Dalla radice di WordPress:

```bash
git clone https://github.com/gritlab-it/grit-theme.git wp-content/themes/grit-theme
cd wp-content/themes/grit-theme
```

In alternativa caricare la cartella del tema in `wp-content/themes/`. Se si utilizza uno ZIP, verificare che contenga direttamente la struttura del tema nella cartella corretta.

Il repository contiene il codice dello starter. Contenuti, immagini, configurazioni dei plugin e database appartengono al singolo progetto e si trasferiscono separatamente.

## 2. Installare le dipendenze PHP

Dalla cartella del tema:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
```

Il comando installa le dipendenze dichiarate, compresi Timber e Twig, e genera `vendor/autoload.php`, caricato da `functions.php`. `--no-dev` esclude eventuali dipendenze di sviluppo aggiunte dal progetto.

Se esiste `composer.lock`, Composer usa le versioni bloccate. Attualmente `.gitignore` esclude sia `vendor/` sia `composer.lock`: un clone può quindi esserne privo. Senza lock l’installazione risolve le versioni consentite dal manifest; non garantisce le stesse versioni tra installazioni. Definire una politica di distribuzione del lock per i progetti che richiedono riproducibilità.

Non occorre eseguire `composer require timber/timber` a ogni installazione: Timber è già nel manifest. Non usare `composer update` come passaggio ordinario per avviare il tema.

Per un hosting senza Composer, eseguire l’installazione nell’ambiente di sviluppo compatibile con il server e trasferire anche `vendor/`. Twig non è un plugin da attivare in WordPress.

## 3. Installare i plugin necessari

Installare e attivare ACF PRO con il proprio pacchetto autorizzato. Il riferimento a uno ZIP ACF in `core/plugins.php` è commentato: il tema non fornisce automaticamente il plugin commerciale.

Il tema carica TGMPA e mostra i plugin dichiarati obbligatori o consigliati in **Aspetto → Install Plugins** / nella schermata proposta dall’avviso. Consultare [Plugin e librerie nella guida](GUIDE_IT.md#plugin-e-librerie).

Il flag TGMPA “obbligatorio” è una scelta di distribuzione del tema: non significa che ogni singolo componente dipenda tecnicamente da tutti i plugin dell’elenco. Il comando Composer non installa l’intero elenco TGMPA.

## 4. Attivare e configurare

1. Aprire **Aspetto → Temi** e attivare GRIT.
2. Controllare la schermata **Aspetto → Configurazione del tema**.
3. Su un sito nuovo selezionare le operazioni necessarie: pagine iniziali, homepage statica, permalink, menu, modulo Contact Form 7 e import dei campi ACF.
4. Su un sito esistente scegliere **No** per le operazioni che non si vogliono applicare. La schermata contiene scelte inizialmente impostate su Yes: rivederle prima di salvare.
5. In **Impostazioni → Lettura** verificare Home e pagina articoli. In **Aspetto → Menu** controllare le assegnazioni.
6. Salvare **Impostazioni → Permalink** dopo aver configurato CPT, tassonomie e relativi slug.

Le operazioni di setup possono modificare pagine, menu, impostazioni e definizioni ACF. Prima di riapplicarle su un progetto già avviato fare un backup di file e database. Le operazioni vengono eseguite al salvataggio della schermata, solo per le opzioni selezionate. Homepage e pagine aggiuntive sono indipendenti; le pagine esistenti vengono riutilizzate e le assegnazioni menu conservate. Un’operazione completata viene disattivata; un errore lascia la relativa opzione disponibile per riprovare. Il setup non importa contenuti dimostrativi o media.

### Menu Bio

Il setup crea il menu **Bio Navigation** con About e Contatti e lo assegna alla posizione **Bio Navigation** (`bio_navigation`). In Twig è disponibile come `bio_menu`, come avviene per `primary_navigation` e `primary_menu`. Titoli, descrizioni e nuovi collegamenti si gestiscono da **Aspetto → Menu**.

### Pagine Privacy e Cookie Policy

Usare il template predefinito e gli slug `privacy-policy` e `cookie-policy`: `page.php` carica automaticamente `page-privacy-policy.twig` e `page-cookie-policy.twig`. Il titolo può essere modificato liberamente; cambiando slug occorre adeguare anche il nome del Twig. I template usano i contenuti della pagina e, quando vuoti, i rispettivi contenuti predefiniti già previsti dal tema. Per la Cookie Policy il documento automatico richiede lo shortcode di Complianz; in sua assenza viene mostrato un messaggio di documento non disponibile. È possibile compilare direttamente il contenuto della pagina.

Il setup riutilizza la pagina Privacy selezionata in **Impostazioni → Privacy**, anche quando è ancora una bozza; non la pubblica e non ne sostituisce i testi. In assenza di una Privacy selezionata cerca lo slug `privacy-policy`; per la Cookie Policy cerca `cookie-policy`. Crea una nuova pagina solo quando non ne trova una da riutilizzare. Un template personalizzato già assegnato viene conservato.

Per la Privacy, la pagina di riferimento si sceglie in **Impostazioni → Privacy**. Per la Cookie Policy mantenere lo slug `cookie-policy`. I link automatici del footer usano soltanto pagine pubblicate; le bozze non vengono collegate. La selezione Privacy di WordPress determina il link, mentre lo slug determina il layout Twig.

### Modulo contatti dello starter

L'opzione CF7 della configurazione iniziale richiede Contact Form 7 attivo e crea il **Modulo di Contatto Demo** attraverso le API del plugin. Se esiste già, lo riutilizza senza sovrascrivere campi o email.

La mail principale usa `[_site_admin_email]`, cioè l'indirizzo amministrativo in **Impostazioni → Generali**, e `Reply-To: [your-email]`. Il mittente segue il valore predefinito di CF7 per il sito: verificare che sia compatibile con il servizio di invio configurato.

**Mail (2)** contiene una conferma separata per il visitatore, inizialmente disattivata. Può essere abilitata in CF7 dopo aver verificato la configurazione e il recapito. Il modello non configura SMTP e la validazione dei campi non garantisce la consegna delle email.

Il collegamento privacy usa la pagina pubblicata individuata dalla configurazione Privacy di WordPress oppure dallo slug standard. Se non esiste una pagina pubblicata, l’accettazione resta senza link: configurare la pagina prima di usare il modulo. Il link salvato nel modulo CF7 va aggiornato se si cambia successivamente l’indirizzo della pagina. Nome, cognome, email e accettazione sono obbligatori; telefono e messaggio sono facoltativi. Provenienza e pagina corrente sono campi nascosti.

## 5. Importare i campi ACF

La definizione di riferimento è [`core/acf-fields.json`](core/acf-fields.json).

- Su una nuova installazione usare l’opzione **Import ACF Fields** del setup, con ACF PRO già attivo. Il setup salta i gruppi che trova già con la stessa chiave: non è un aggiornamento automatico dei campi esistenti.
- Per importare o aggiornare le definizioni usare **ACF → Strumenti → Importa gruppi di campi**, verificando il risultato sui gruppi esistenti e mantenendo le chiavi.
- Le istruzioni accanto ai campi e la tab **Guida** di ogni layout aiutano a scegliere classi e opzioni.
- Verificare gruppi e regole di posizione. I CPT e le tassonomie si registrano separatamente nel progetto: il JSON dei campi non crea il CPT dimostrativo `section`.
- Dopo modifiche ai campi aggiornare anche il JSON distribuito. Non rigenerare le chiavi o rinominare layout con dati già salvati senza una migrazione.

L’import descrive la struttura dei campi; non trasferisce contenuti, media, opzioni Personalizza e tutte le configurazioni dei plugin.

## 6. Prima personalizzazione

In **Aspetto → Personalizza** configurare logo, header, footer, Theme Fields e librerie opzionali. Impostare i dati dell’azienda e i social prima di utilizzare gli shortcode Contacts.

Per lo stile partire da `assets/css/_variables.scss`: palette, font, breakpoint, pulsanti, form e componenti. Ricompilare dalla cartella del tema con Dart Sass disponibile:

```bash
sass assets/css/main.scss assets/css/main.css --style=expanded
```

Durante lo sviluppo:

```bash
sass --watch assets/css/main.scss:assets/css/main.css --style=expanded
```

`main.scss` è il punto d’ingresso: non compilare ogni partial separatamente. Versionare insieme sorgenti e CSS compilato. Non modificare solo `main.css`, perché la compilazione lo sovrascrive.

Per scegliere il branding dell’agenzia usare `GRIT_AGENCY` in `functions.php`; dettagli nella [guida](GUIDE_IT.md#branding-dellagenzia).

## 7. Verifica del primo avvio

- Home, pagina interna, singolo, ricerca e archivio si aprono correttamente.
- I campi Sections compaiono nelle schermate previste da ACF.
- Menu desktop/mobile e footer mostrano i dati corretti.
- Le immagini esistono nella Libreria Media e le section richiamate puntano a contenuti validi.
- Le funzionalità richieste hanno la relativa libreria attiva.
- Consenso, Maps, form e script esterni sono configurati per il dominio di destinazione.

Se compare l’avviso Timber mancante, controllare `vendor/autoload.php` e l’installazione Composer. Se funzionano soltanto gli URL semplici, verificare permalink, regole del server e dominio configurato; un errore DNS non si risolve modificando Twig.

## Documentazione e licenze

Il manuale operativo è **[GUIDE_IT.md](GUIDE_IT.md)**, con campi, classi, esempi e indicazioni per personalizzare i componenti. I README, i changelog e le licenze conservati dentro `assets/` delle librerie di terze parti appartengono ai rispettivi pacchetti e non vanno eliminati insieme alla documentazione del tema.

Il codice del tema è distribuito secondo [LICENSE](LICENSE). Le dipendenze mantengono le proprie licenze; la licenza del tema non sostituisce quelle dei plugin, delle librerie, dei font o dei media.

### Origine e crediti

Grit deriva dallo starter Timber di Upstatement. I metadati Composer identificano il progetto Grit mantenuto da Grit Lab; non sostituiscono i crediti e le licenze del progetto originale o delle dipendenze. Conservare le attribuzioni e i file di licenza distribuiti con ciascun componente.
