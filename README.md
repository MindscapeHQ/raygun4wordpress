Raygun4WP
==========

[Raygun.io](http://raygun.io) provider plugin for Wordpress

This provider is a Wordpress plugin that allows you to easily send errors and exceptions from your Wordpress site to the Raygun.io error reporting service.
It features an admin panel for easy configuration. It uses the lower-level Raygun4php provider (which is included in the plugin). 

## Installation

Firstly, ensure that the **curl** extension is installed and enabled in your server's php.ini file. If you are using a *nix system, the package php5-curl may contain the required dependencies.

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

Changelog
---------

Version 1.0.3:

* Added button to test setup on config page

* Added status indicator, improved handling when API key missing or invalid

* Fixed a major bug where the provider would attempt to send errors, even if the status was 'disabled', cURL was missing, or an invalid API key
 was provided

Version 1.0.1:

* Added 404 error handling

* Enabled tag support

* Misc UX improvements