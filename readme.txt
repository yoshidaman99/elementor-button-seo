=== Elementor Button SEO ===
Contributors: yoshidaman99
Tags: elementor, button, seo, accessibility, schema, json-ld, aria, wcag
Requires at least: 5.9
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds SEO and accessibility enhancements to Elementor Button widgets — Schema.org JSON-LD, aria-label, and title attributes to fix "Links do not have descriptive text" audit issues.

== Description ==

Elementor Button SEO adds a new **"Button SEO & Accessibility"** section to the **Content tab** of every Elementor Button widget. This plugin piggybacks on Elementor — no custom widgets needed.

**Features:**

* **Fix "Links do not have descriptive text"** — Add custom `aria-label` attributes for screen readers, with automatic fallback from button text
* **Link title attributes** — Add descriptive `title` attributes for SEO context and hover tooltips
* **Schema.org JSON-LD** — Add structured data to buttons (ReadAction, BuyAction, DownloadAction, and more) for rich search results
* **Auto-detection** — Schema action names default to the button text
* **Custom JSON-LD** — Override all schema fields with your own custom JSON-LD
* **Per-button control** — Enable/disable per button, not globally
* **Dynamic tags support** — All text fields support Elementor dynamic tags
* **Zero performance impact** — Only loads on pages with Elementor buttons

**How it fixes "Links do not have descriptive text":**

This is a common accessibility and SEO audit failure. It occurs when:
* Buttons have no visible text (icon-only buttons)
* Button text is generic like "Click here" or "Read more"
* Links lack descriptive context for screen readers

This plugin lets you add descriptive `aria-label` and `title` attributes to every button, resolving these audit issues.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/elementor-button-seo/` or install through the WordPress plugins screen
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Edit any page with Elementor, click a Button widget, go to the **Content** tab
4. Find the **"Button SEO & Accessibility"** section and toggle it on

== Frequently Asked Questions ==

= Does this require Elementor Pro? =
No, it works with the free version of Elementor.

= Does this add a new widget? =
No, it extends the existing Elementor Button widget by adding a new section to its Content tab.

= Will this slow down my site? =
No. The plugin only runs when Elementor is active and only processes Button widgets. There are no database queries or external requests.

= Can I use this with any Elementor theme? =
Yes, it works with any theme that has Elementor installed.

= Does this work with the WordPress block editor? =
No, this plugin specifically enhances Elementor Button widgets.

== Changelog ==

= 1.0.2 =
* Fix: Controls now appear on the Content tab (fixes hook targeting non-existent section)
* Update tab references in documentation

= 1.0.0 =
* Initial release
* Add "Button SEO & Accessibility" section to Elementor Button widget
* ARIA label support with auto-fallback from button text
* Link title attribute support with auto-population option
* Schema.org JSON-LD structured data (10 action types, 7 object types)
* Custom JSON-LD override support
* Dynamic tags support for all text fields
