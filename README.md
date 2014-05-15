Raygun4WP
==========

[Raygun.io](http://raygun.io) provider plugin for Wordpress

This provider is a Wordpress plugin that allows you to easily send errors and exceptions from your Wordpress site to the Raygun.io error reporting service.
It features an admin panel for easy configuration. It uses the lower-level Raygun4php provider (which is included in the plugin).

## Installation

Firstly, ensure that your server is running PHP 5.3.3 or newer and that it has the **curl** extension is installed and enabled in your server's php.ini file. If you are using a *nix system, the package php5-curl may contain the required dependencies.

### Manually with Git

Clone this repository into your Wordpress installation's /plugins folder - for instance at /wordpress/wp-content/plugins. Use the --recursive flag to also pull down the Raygun4php dependency:

```
git clone --recursive https://github.com/MindscapeHQ/raygun4php.git
```

### From Wordpress Plugin Directory

Add it from the official repository using your admin panel - the plugin is available [here](http://wordpress.org/plugins/raygun4wp/).

## Usage

In your browser navigate to your Wordpress admin panel, click on Plugins, and 'Activate' Raygun4WP. Click on the new entry that appears to the left.

Copy your application's API key from the Raygun.io dashboard, and place it in the appropriate field. Set Error Reporting Status to 'Enabled', hit Submit, and you're done!

### Client-side JavaScript error tracking

As of 1.4 this plugin now also include Raygun4JS so you can automatically track JavaScript errors that occur in your user's browsers once your site's pages are loaded.

To activate this, turn on the JavaScript error tracking option in the Raygun4WP Settings page.

### Unique user tracking

You can enable this feature from the Settings page. If you do so the currently logged in user's email address will be transmitted along with each message. This will be visible in the Raygun dashboard. If they have associated a Gravatar with that address, you will see their picture. If this feature is not enabled, a random ID will be assigned to each user. Either way, you can view a count of the affected users for each error.

### Ignored domains

You can enter a comma-delimited list in the field on the Config page to prevent certain domains from sending errors.

### Async sending

Introduced in 1.1.3, this provider will now send asynchronously on *nix servers (async sockets) resulting in a massive speedup - POSTing to Raygun now takes ~56ms including SSL handshakes. This behaviour can be disabled in code if desired to fall back to blocking socket sends. Async sending is also unavailable on Windows due to a bug in PHP 5.3, and as a result it uses cURL processes. This can be disabled if your server is running a newer environment; please create an issue if you'd like help with this.

Changelog
---------

- 1.4.1: Admin warning notice fix
- 1.4.0: Added auto client-side JavaScript error tracking
- 1.3.0: Ignored Domains setting added; bump RG4PHP to v1.3.5
- 1.2.1: Updated admin message
- 1.2: Now requires PHP 5.3.3 or newer; default to using socket sending method; bump Raygun4PHP to 1.3.3
- 1.1.4: Bump Raygun4PHP to latest version 1.2.4
- 1.1.3: Bump Raygun4PHP to async version
- 1.1.1: WordPress version tracking enabled; updated Raygun4PHP. There were two bugs in 1.1 with nested request data and user tracking, updating is recommended.
- 1.1: Added Unique User tracking support; updated repo to use latest Raygun4PHP v1.1
- 1.0.3: Added button to test setup on config page; added status indicator, improved handling when API key missing or invalid; fixed a major bug where the provider would attempt to send errors, even if the status was 'disabled', cURL was missing, or an invalid API key was provided
- 1.0.1: Added 404 error handling; enabled tag support; misc UX improvements