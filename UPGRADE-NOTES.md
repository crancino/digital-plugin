# Digital plugin upgrade notes

## Current structure (legacy entrypoint)

This plugin is currently bootstrapped via the legacy Joomla plugin entry file:

- `digital.php` (class `PlgSystemDigital`)

This is because `digital.xml` includes:

- `<filename plugin="digital">digital.php</filename>`

The namespaced class under `src/Extension/Digital.php` exists, but **is not the bootstrap entrypoint** with the current manifest/wiring.

## Future upgrade: switch to the modern Joomla 6 plugin structure

Goal: use the namespaced plugin class (PSR-4) as the real entrypoint, via Joomla's service provider mechanism.

High-level steps:

- Add `services/provider.php` to the plugin.
  - Register the plugin class under `IIT\Plugin\System\Digital\Extension\Digital`.
  - Return the proper service provider object expected by Joomla.
- Update `digital.xml`:
  - Ensure the `<files>` section includes the `services` folder.
  - Remove the legacy `<filename plugin="digital">digital.php</filename>` entry (or keep only during a transition period).
- Verify events are still subscribed correctly (`SubscriberInterface`) and that the plugin still runs in the same request contexts.
- Reinstall/upgrade the plugin package and confirm:
  - Custom JS injection behavior
  - WebAsset injections (FontAwesome, fonts)
  - YOOessentials custom sources registration

Notes:

- The migration should be done carefully because this plugin currently contains substantial logic in `digital.php`.
- If/when migrating, prefer making `src/Extension/Digital.php` the single source of truth and deleting the duplicated legacy logic once validated.

