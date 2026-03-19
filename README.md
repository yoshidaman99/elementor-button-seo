# Elementor Button SEO

WordPress plugin that adds SEO and accessibility enhancements to Elementor Button widgets.

## Features

- **Fix "Links do not have descriptive text"** — Add `aria-label` and `title` attributes to buttons
- **Schema.org JSON-LD** — Add structured data (ReadAction, BuyAction, DownloadAction, etc.)
- **Piggybacks on Elementor** — No custom widgets, extends the existing Button widget's Advanced tab
- **Per-button control** — Enable/disable individually per button
- **Zero performance impact** — Only processes when Elementor is rendering

## Installation

1. Upload to `/wp-content/plugins/elementor-button-seo/`
2. Activate through WordPress Plugins menu
3. Edit any Elementor page, select a Button widget, go to **Advanced** tab
4. Toggle on **"Button SEO & Accessibility"**

## Requirements

- WordPress 5.9+
- PHP 7.4+
- Elementor (free)

## Schema.org Actions Supported

ReadAction, ViewAction, PlayAction, DownloadAction, SearchAction, RegisterAction, SubscribeAction, ShareAction, CommunicateAction, BuyAction

## License

GPLv2 or later
