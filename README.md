# GRIT Theme

GRIT is a WordPress starter theme for agencies, freelancers, and developers who build custom sites from a shared foundation. It uses PHP and Timber/Twig for templates, ACF PRO for content, SCSS for styles, and JavaScript for interactive components.

The agency defines the design and editing options. Editors manage text, images, and supported settings through WordPress and ACF.

Read this file for installation and initial setup. The [English guide](GUIDE.md) covers sections, classes, shortcodes, archives, libraries, and code customization.

[Italian README](README_IT.md) · [Italian guide](GUIDE_IT.md) · [Repository](https://github.com/gritlab-it/grit-theme) · [Issue tracker](https://github.com/gritlab-it/grit-theme/issues)

## Requirements

| Component | Requirement |
| --- | --- |
| WordPress | A working installation, administrator access, and configurable permalinks. |
| PHP | The reference environment uses PHP 8.2. Check plugin compatibility on the target server. |
| Composer | Run it in development to install PHP dependencies when `vendor/` is missing. |
| Timber and Twig | `composer.json` declares `timber/timber: ^1.0`. Timber brings in Twig. Moving to Timber 2 requires a migration. |
| ACF PRO | Required for Flexible Content, Repeater, and the other theme fields. Install and license it separately. |
| Sass | Needed when editing and compiling SCSS. The frontend loads the compiled CSS. |

Install Composer dependencies before activating the theme. Check the plugin and library versions against the needs of each project.

## 1. Install the theme

Run these commands from the WordPress root.

```bash
git clone https://github.com/gritlab-it/grit-theme.git wp-content/themes/grit-theme
cd wp-content/themes/grit-theme
```

You can also upload the theme folder to `wp-content/themes/`. If using a ZIP, check that its theme folder contains the theme files directly.

The repository contains the starter code. Transfer project content, images, plugin settings, and database separately.

## 2. Install PHP dependencies

Run this command from the theme folder.

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
```

Composer installs Timber, Twig, and the other declared dependencies. It generates `vendor/autoload.php`, which `functions.php` loads. The `--no-dev` flag skips development dependencies added by the project.

If `composer.lock` exists, Composer installs the locked versions. The current `.gitignore` excludes both `vendor/` and `composer.lock`, so a clone may lack them. Without a lock file, Composer resolves versions allowed by the manifest on each installation. Distribute the lock file when the project needs reproducible installs.

Timber is already in the manifest. Use `composer install` for routine setup and reserve `composer update` for deliberate dependency upgrades. On hosting without Composer, install dependencies in a compatible development environment and deploy `vendor/` with the theme. Twig loads through Composer.

## 3. Install WordPress plugins

Install and activate ACF PRO using your licensed package. The ZIP reference in `core/plugins.php` is commented out.

TGMPA lists required and recommended WordPress plugins under **Appearance → Install Plugins** or on the screen linked from its notice. Its required flag reflects the theme's distribution settings. Individual features have their own dependencies. Composer handles PHP packages separately. [Plugins and libraries](GUIDE.md#plugins-and-libraries)

## 4. Activate and configure the theme

1. Activate GRIT under **Appearance → Themes**.
2. Open **Appearance → Theme Setup**.
3. On a new site, select the setup operations you need. These cover initial pages, a static homepage, permalinks, menus, a Contact Form 7 form, and ACF field import.
4. On an existing site, review the options initially set to **Yes** and select **No** wherever you want to skip an operation.
5. Check the homepage and posts page under **Settings → Reading**. Check menu assignments under **Appearance → Menus**.
6. Save **Settings → Permalinks** after configuring post types, taxonomies, and slugs.

Back up files and the database before applying setup operations to an existing project. Saving the screen runs the selected operations. Homepage and additional-page creation are independent. Setup reuses existing pages and preserves menu assignments. It clears completed operations and leaves failed operations available for retry. Transfer demo content and media separately.

### Bio menu

Setup creates **Bio Navigation**, adds About and Contatti, and assigns it to the `bio_navigation` location. Twig exposes it as `bio_menu`, following the same convention as `primary_navigation` and `primary_menu`. Manage item titles, descriptions, and links under **Appearance → Menus**.

### Privacy and Cookie Policy pages

Use the default page template with the slugs `privacy-policy` and `cookie-policy`. The controller in `page.php` selects `page-privacy-policy.twig` and `page-cookie-policy.twig`. You can edit the page title independently. If you change the slug, rename the matching Twig file.

These templates use the page content or the theme's fallback when it is empty. Automatic Cookie Policy content uses a Complianz shortcode. The template shows a document-unavailable message when the shortcode is unavailable. You can also write the page content directly.

Setup reuses the page selected in **Settings → Privacy**, including a draft. It preserves its status and text. If no privacy page is selected, setup looks for `privacy-policy`. It looks for `cookie-policy` for the cookie page. It creates a page only when there is no suitable page to reuse and preserves existing custom templates.

Automatic footer links use published pages. WordPress's Privacy setting determines the privacy link. The slug determines the Twig layout and identifies the Cookie Policy page.

### Starter contact form

With Contact Form 7 active, the setup option creates **Modulo di Contatto Demo** through the plugin API. It reuses an existing form of that name and preserves its fields and mail settings.

The main message goes to `[_site_admin_email]`, the address in **Settings → General**, with `Reply-To: [your-email]`. The sender follows the site's CF7 default. Check it against the configured mail service.

**Mail (2)** holds a separate visitor confirmation and starts disabled. Enable it after verifying configuration and delivery. Configure SMTP separately and test delivery after validating the form.

The privacy link uses the published page selected in WordPress or found by the standard slug. Publish the page before using the form so visitors have a link. Update the stored link in CF7 if the page URL changes. First name, last name, email, and acceptance are required. Phone and message are optional. Referrer and current page are hidden fields.

## 5. Import ACF fields

The source file is [core/acf-fields.json](core/acf-fields.json).

- For a fresh installation, activate ACF PRO and use **Import ACF Fields** in setup. Setup skips groups whose keys already exist.
- Use **ACF → Tools → Import Field Groups** to import or update definitions on an existing site. Check the resulting groups and preserve their keys.
- Read the instructions beside each field and the **Guida** tab in each layout for available classes and options.
- Check field groups and location rules. Register custom post types and taxonomies in the project. The field JSON covers field groups and the demo `section` post type requires separate registration.
- Update the distributed JSON whenever fields change. Plan a data migration before changing keys or renaming layouts that contain saved data.

Transfer content, media, Customizer settings, and plugin configuration separately from field definitions.

## 6. Customize the theme

Use **Appearance → Customize** to configure the logo, header, footer, Theme Fields, and optional libraries. Enter company and social details before using the Contacts shortcode.

Edit the palette, fonts, breakpoints, buttons, forms, and component settings in `assets/css/_variables.scss`. With Dart Sass available, compile from the theme folder.

```bash
sass assets/css/main.scss assets/css/main.css --style=expanded
```

During development, you can watch the entry point.

```bash
sass --watch assets/css/main.scss:assets/css/main.css --style=expanded
```

Compile `main.scss` as the entry point for all partials. Commit the sources and compiled CSS together. Make edits in SCSS so recompiling preserves them.

Select the agency brand using `GRIT_AGENCY` in `functions.php`. [Agency branding](GUIDE.md#agency-branding)

## 7. Check the first installation

- Open the homepage, an inner page, a single post, search, and an archive.
- Check that ACF shows Sections on the intended editing screens.
- Verify desktop and mobile menus and footer content.
- Check media and the source pages referenced by reusable sections.
- Enable the libraries each feature needs.
- Check consent, Maps, forms, and external scripts on the target domain.

If Timber is missing, check Composer and `vendor/autoload.php`. If plain URLs work but pretty permalinks fail, check WordPress and server rewrite settings. If the hostname fails to resolve, check DNS or the local host configuration.

## Documentation and licenses

The [English guide](GUIDE.md) covers fields, classes, examples, and component customization. The [Italian README](README_IT.md) and [Italian guide](GUIDE_IT.md) cover the same material.

Keep the README files, changelogs, and licenses shipped with third-party libraries under `assets/`. The theme code uses the license in [LICENSE](LICENSE). Plugins, libraries, fonts, and media retain their own licenses.

### Origin and credits

GRIT builds on Upstatement's Timber starter theme. Composer metadata identifies the GRIT project maintained by Grit Lab. Keep the original credits and licenses shipped with the starter and its dependencies.
