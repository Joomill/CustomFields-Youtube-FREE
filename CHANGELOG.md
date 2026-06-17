# Changelog

All notable changes to the Extension are documented in this file.

## TODO
- Addition: help buttons now link to the Joomill documentation page
- Addition: Support Plugin lazy loading for PHP >= 8.4: Added a possibility to load plugin class on demand (lazy loading) when the event dispatched. For servers with PHP version >= 8.4.
- Check other updates in the past: https://github.com/joomla/Manual/tree/main/updates
- Check bc for Joomla 7 release: https://github.com/joomla/Manual/blob/main/updates/64-70/removed-backward-incompatibility.md
- Check joomla installer script volgens: C:\Obsidian\Joomill-Vault\Joomill\30-snippets\joomla-installer-script.md

## 5.3.0
- Addition: support for plugin lazy loading on PHP 8.4 and Joomla 6.1+, loading the plugin on demand when its event is dispatched (with a safe fallback on older versions)
- Update: rebuilt the installation script on Joomla's InstallerScriptInterface standard
- Addition: the installation screen now links to the plugin configuration and the online documentation
- Fix: corrected the social media icons on the install and uninstall screen
