# Digital (System) plugin — overview

This repository folder contains the **Joomla System plugin** `digital` used to extend a YOOtheme Pro + ZOOlanders Essentials site with:

- Local **Font Awesome** assets
- Optional **Custom JS** injection (frontend only)
- Custom font **“Hey August”**
- Custom Essentials **Sources** (Zenodo + Scientilla)

## Where it runs

- Plugin type: **System** (`plugins/system/digital`)
- Current bootstrap entrypoint: **`digital.php`** (legacy entry file)

See `UPGRADE-NOTES.md` for a future migration to the modern Joomla 6 service provider structure.

## Main behaviors

### 1) Web assets (Font Awesome)

On frontend requests, the plugin injects Font Awesome by loading:

- CSS: `/media/plg_system_digital/css/all.min.css`
- Webfonts are expected under: `/media/plg_system_digital/webfonts/`

The plugin also registers the extension asset registry:

- `media/joomla.asset.json` (installed to `/media/plg_system_digital/joomla.asset.json`)

### 2) Custom font (“Hey August”)

On frontend requests, the plugin injects an `@font-face` declaration that points to:

- `/media/plg_system_digital/fonts/Hey August.ttf`
- `/media/plg_system_digital/fonts/Hey August.otf`

### 3) Custom JS injection (frontend only)

If the plugin parameter **`custom_js`** is set, the plugin injects it into the document **only on the frontend** and **skips injection in YOOtheme Builder/Customizer contexts**.

Important detail:

- When the page is loaded inside an iframe (Builder preview), the plugin injects a small helper script that appends `yoobuilder=1` to links.  
  This keeps subsequent navigations correctly marked as “Builder context” so the Custom JS stays disabled there.

### 4) Custom Essentials sources (Zenodo + Scientilla)

The plugin registers two custom Essentials Source types:

- `zenodo`
- `scientilla`

These sources are implemented under:

- `sources/YOOthemeDigital/Sources/Zenodo/...`
- `sources/YOOthemeDigital/Sources/Scientilla/...`

Each source provides a `config.json` describing how it appears in the Essentials “Add Source” UI.

#### Scientilla “single source of truth” for Email

The Scientilla resolver is designed to take the **email/username from the Scientilla source instance configuration**, so the same configured identity is used consistently when binding dynamic fields.

### 5) Debug logging

When enabled, the plugin logs source registration and resolver diagnostics to:

- `administrator/logs/digital.log.php`

## Plugin parameters

Configured in `digital.xml`:

- **`custom_js`**: JavaScript snippet to inject (string/textarea, raw)
- **`zenodo_token`**: Bearer token for Zenodo API
- **`scientilla_url`**: Base URL for Scientilla (optional)
- **`scientilla_token`**: Bearer token for Scientilla API
- **`debug_sources`**: Enables logging to `administrator/logs/digital.log.php`

## Key files

- **`digital.php`**: current runtime entrypoint and main event handlers
- **`digital.xml`**: plugin manifest and parameters
- **`media/joomla.asset.json`**: WebAsset definitions
- **`sources/autoload.php`**: loads YOOtheme/Essentials autoloaders + PSR-4 for `YOOthemeDigital\`
- **`sources/YOOthemeDigital/...`**: Zenodo + Scientilla source implementations

