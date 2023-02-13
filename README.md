Raygun4WP
==========

**[Raygun](http://raygun.com) for WordPress**

The WordPress plugin providing an easy integration of Raygun into WordPress websites. [Crash Reporting](https://raygun.com/platform/crash-reporting) allows developers to easily track errors, exceptions and crashes automatically, while [Real User Monitoring](https://raygun.com/platform/real-user-monitoring) allows developers to identify issues, measure trends in application performance, and improve customer experiences.

This provider uses the lower-level [Raygun4PHP](https://github.com/MindscapeHQ/raygun4php) provider for server-side crash reporting and [Raygun4JS](https://github.com/MindscapeHQ/raygun4js) for both client-side crash reporting and real user monitoring.

**Multisite support**: This plugin supports multisite installations, but a specific installation procedure should be followed. Read the instructions below for more information.

## Installation

Ensure that your server is running PHP 7.4 or newer.

### From Wordpress Plugin Directory

Add it from the official repository using your admin panel - the plugin is available from [wordpress.org/plugins/raygun4wp/](http://wordpress.org/plugins/raygun4wp/).

### Manually with Git

Clone this repository into your WordPress installation's `/plugins` folder - e.g. `/wordpress/wp-content/plugins`.

```
git clone https://github.com/MindscapeHQ/raygun4wordpress
```

## Usage

1. Navigate to your WordPress admin panel, click on Plugins, and then **Activate Raygun**
2. Go to the Raygun settings panel either by the sidebar or admin notification
3. Copy your application's API key from your [Raygun dashboard](https://app.raygun.com/dashboard/) and place it in the API key field
4. Enable `Error Tracking` (both server-side and client-side), `Real User Monitoring` and any other options
5. Save your changes
6. Done!

## Real User Monitoring

As of 1.8, you can enable [real user monitoring](https://raygun.com/platform/real-user-monitoring) by navigating to the Raygun settings page and checking the **Enable Real User Monitoring** checkbox.

User information will be sent along if you have the Customers feature enabled.

## Client-side error tracking

As of 1.4, this plugin now also includes [Raygun4JS](https://raygun.com/documentation/language-guides/javascript) so you can automatically track JavaScript errors that occur in your user's browser once your site's pages are loaded.

To activate this, turn on the JavaScript error tracking option in the Raygun settings page.

## Customers

If you enable this feature in your Raygun Plugin settings, the currently logged in user's email address, first name and last name will be transmitted along with each error or session. This will be visible in the Raygun dashboard.

If they have associated a Gravatar with that address, you will see their picture.

If this feature is not enabled, a random ID will be assigned to each user. Either way, you can view a count of the affected users for each error.

## Tagging errors

Since 1.8 both client-side and server-side errors can be tagged. Tags are custom test allowing you to easily identify errors.

JavaScript and PHP errors can be tagged independently through a comma-delimited list in the field on the settings page.

For example: `Error, JavaScript` would add two tags. The first being `Error` second one being `JavaScript`

## Ignored domains

You can enter a comma-delimited list in the field on the settings page to prevent certain domains from sending errors and from being tracked with real user monitoring.

## Async sending

As of 2.0.0, async sending is avaliable on both Unix and Windows servers. Enabling async sending should yeild a performance increase.

Changelog
---------
- 2.0.0: Switch to Composer for dependency management; Bump Raygun4PHP dependency to v2.3.0; Use new async sending guzzle (adds support for async on Windows); Switch Raygun4JS dependency to grab latest CDN distribution; Add error type tagging; Log errors that fail to send to Raygun; Add setting to disable tracking on admin pages; Rename Mindscape namespace to Raygun (src); Improve RaygunClientManager such that setting changes take effect immediately; Correct relationship between error handler and shutdown handler; Miscellaneous bug fixes, code improvements, UI and documentation updates
- 1.9.3: Updated User Tracking to Customers.
- 1.9.2: Update Pulse to Real User Monitoring (RUM)
- 1.9.1: Don't set user cookie when user tracking is disabled.
- 1.9.0: Add async sending option to dashboard; Bump Raygun4JS dependency to v2.8.5; Bump Raygun4PHP dependency to v1.8.2
- 1.8.3: Fix XSS vulnerability in settings; Replace the iframe with a link to the Raygun dashboard
- 1.8.2: Bump Raygun4JS version to v2.6.2
- 1.8.1: XSS bug fix
- 1.8.0: Bump Raygun4JS dependency to v2.4.0; Bump Raygun4PHP dependency to v1.7.0; Pulse support added; Raygun4JS also includes the unique user tracking feature; Restructured the settings screen; JavaScript error tagging option added; Fixed an issue where the Send Test Error page wouldn't display results; Various content and style updates; Updated notifications; Raygun4JS tracks the version Wordpress being used; Unique user tracking also tracks the users first & last names
- 1.7.3: Fixed issue with WP 4.5.2 plugin api
- 1.7.2: Fixed redundant cURL check when running in socket mode
- 1.7.1: Fix issue with tags not being provided for caught exceptions
- 1.7.0: Bump Raygun4JS dependency to v1.18.4
- 1.6.0: Bump Raygun4php dependency to v1.6.1
- 1.5.2: Ignored domains are now obeyed for JS errors; fix admin menu appearing for users without that role
- 1.5.1: Fix settings change errors
- 1.5.0: Added flag to enable multisite support; bump RG4PHP and RG4JS dependencies
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
