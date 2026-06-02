# CLAUDE.md - Custom Fields YouTube (FREE)

Joomla Custom Fields plugin that adds a "YouTube" field type. The admin stores a YouTube video ID (or URL) on the content item and the plugin renders an embedded YouTube player on the frontend.

This is the **FREE** version. The companion PRO version lives at `C:\laragon\www\dev\extensions\CustomFields-Youtube-PRO`.

## What it does

- Adds a custom field of type `youtube` (Fields plugin group, element `youtube`).
- The editor enters a YouTube video ID **or** any common YouTube URL (`watch?v=`, `youtu.be/`, `/embed/`, `/shorts/`, `/live/`); the layout extracts the 11-char video ID.
- On the frontend `tmpl/youtube.php` outputs a plain `<iframe>` YouTube embed.
- FREE exposes the iframe dimensions and the privacy (`nocookie`) mode. All other player options are locked behind PRO and shown as disabled placeholders with an upgrade notice.

## Architecture

Standard Joomla namespaced plugin. Entry points:

- `services/provider.php` - DI service provider, registers the plugin with the container (standard J5/J6 pattern).
- `src/Extension/Youtube.php` - the plugin class. Empty subclass of `FieldsPlugin`; all behaviour is handled by the layout and params, no custom event code.
- `src/Field/ProField.php` - custom form field type `pro`, renders a "PRO only" placeholder (`<code>` text). Used by the locked params below.
- `src/Field/UpgradeField.php` - custom form field type `upgrade`, renders the upgrade-to-PRO notice + button linking to joomill-extensions.com. Used at the bottom of the params form.
- `tmpl/youtube.php` - frontend render layout. Resolves the video ID and outputs a plain hardened iframe with `video_width` / `video_height` and the optional `nocookie` host. Returns early when the value is empty / not a valid ID. No container, no player flags, no facade - that's the PRO layout.
- `tmpl/style.css` - container/responsive + facade styling (shipped for parity with PRO; FREE's minimal layout does not load or use it).
- `params/youtube.xml` - the field's admin settings form. **This is the main file that differs functionally between FREE and PRO.**
- `script.php` - installer script, modern Joomla 5+ style: returns a `ServiceProviderInterface` that registers an anonymous `InstallerScriptInterface` (with `DatabaseInterface` injected). Checks min Joomla 5.0 / min PHP in `preflight`, enables the plugin on install, shows the Joomill follow/thankyou screen in `postflight` / on uninstall.
- `youtube.xml` - the manifest (version, namespace, update server cat `11`). No `<changelogurl>` and no `<dlid>` (those are PRO-only).
- `language/` - en-GB, de-DE, es-ES, fr-FR, it-IT, nl-NL.

The `addfieldprefix` in `params/youtube.xml` points at the `Joomill\Plugin\Fields\Youtube\Field` namespace, which resolves the `pro` / `upgrade` field types.

### Security / hardening

The stored field value is treated as untrusted. `tmpl/youtube.php` resolves the video ID by whitelisting `[A-Za-z0-9_-]{11}` (plain ID or extracted from a URL), returns early on anything else, and HTML-escapes every value written into the iframe `src` / attributes. The iframe uses modern embed attributes (`allow`, `allowfullscreen`, `loading="lazy"`, `style="border:0"`, `title`) instead of the deprecated `frameborder`. Never reintroduce raw `$field->value` into the markup. Mirror any change here in the PRO layout.

## FREE vs PRO

The PHP source is effectively identical between the two repos: the only difference in `script.php`, `services/provider.php`, `src/Extension/Youtube.php`, `src/Field/*`, and `tmpl/style.css` is the `FREE Version` / `PRO Version` package header comment. PRO additionally ships `tmpl/youtube.js` (the facade). The real divergence is in two files plus the manifest:

| Area | FREE | PRO |
|------|------|-----|
| `params/youtube.xml` | `video_width` / `video_height` / `nocookie` functional; the rest are locked `type="pro"` placeholders + a `type="upgrade"` notice | all options functional |
| `tmpl/youtube.php` | minimal: plain iframe with the video ID + width/height + nocookie | full render: mode, ratio, align, all player flags, facade |
| `tmpl/youtube.js` | absent | present (facade) |
| manifest cat IDs | cat `11`, no changelog URL, no `<dlid>` | update + changelog cat `10`, has `<changelogurl>` + `<dlid>` |
| package header | `FREE Version` | `PRO Version` |

`nocookie` (privacy mode) is functional in **both** versions.

## Param reference (FREE)

- `video_width` / `video_height` - iframe dimensions.
- `nocookie` - privacy-enhanced mode; embeds via `youtube-nocookie.com` so YouTube sets no cookies until the video is played. Functional in FREE.
- `responsive`, `lite`, `align`, `autoplay`, `mute`, `controls`, `color`, `modestbranding`, `fullscreen`, `rel`, `captions`, `playsinline`, `loop`, `start`, `end` - locked `type="pro"` placeholders. Define their real behaviour in the PRO repo's `params/youtube.xml` + `tmpl/youtube.php`, not here.

### Deprecated / removed

`showinfo` was removed from the YouTube embed API (2018) and has been dropped from the params and language files. Don't reintroduce it.

## Conventions

- Author: Jeroen Moolenschot | Joomill. License GPL v3+. Copyright header on every PHP/XML/CSS file.
- Keep `services/`, `src/Extension/`, `src/Field/`, `script.php`, `tmpl/style.css`, and the language keys aligned with PRO (only the package-header comment should differ). New functional options belong in PRO; in FREE they stay locked placeholders that point users to the upgrade. The facade (`tmpl/youtube.js`) is PRO-only.
- On version bumps update `<version>`, `<creationDate>`, `<copyright>` in `youtube.xml` and keep all six language packs aligned. Mirror the same bump in the PRO repo.
- Min Joomla / min PHP are set in `script.php` (`minimumJoomlaVersion` = 5.0, `minimumPhpVersion` = `JOOMLA_MINIMUM_PHP`).
