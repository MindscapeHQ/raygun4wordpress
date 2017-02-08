Raygun4WP
==========

[Raygun](http://raygun.com) provider plugin for Wordpress

Wordpress plugin providing the easy integration of Raygun to Wordpress websites. [Crash reporting](https://raygun.com/products/crash-reporting) allows developers to easily track errors, exceptions and crashes automatically while pulse provides you with [real user monitoring](https://raygun.com/products/real-user-monitoring).

This provider uses the lower-level [Raygun4PHP](https://github.com/MindscapeHQ/raygun4php) provider for server-side crash reporting and [Raygun4JS](https://github.com/MindscapeHQ/raygun4js) for both client-side crash reporting and real user monitoring.

**Multisite support**: This plugin supports Multisite installations, but a specific installation procedure should be followed. Read the instructions below for more information.

## Installation

Ensure that your server is running
- PHP 5.3.3 or newer
- **curl** library enabled

### Manually with Git

Clone this repository into your Wordpress installation's `/plugins` folder - e.g. `/wordpress/wp-content/plugins`. Use the --recursive flag to also pull down the [Raygun4PHP](https://github.com/MindscapeHQ/raygun4php) and [Raygun4JS](https://github.com/MindscapeHQ/raygun4js) dependencies:

```
git clone --recursive https://github.com/MindscapeHQ/raygun4wordpress.git
```

### From Wordpress Plugin Directory

Add it from the official repository using your admin panel - the plugin is available on [wordpress.org/plugins/raygun4wp/](http://wordpress.org/plugins/raygun4wp/).

## Usage

1. Navigate to your Wordpress admin panel, click on Plugins, and then **Activate Raygun4WP**
2. Go to the Raygun4WP settings panel either by the sidebar or admin notification
3. Copy your application's API key from the [Raygun dashboard](https://app.raygun.com/dashboard/) and place it in the API key field
4. Enable `Error Tracking` (both server-side and client-side), `Real User Monitoring` and any other options
5. Save your changes
6. Done!

## Pulse - Real User Monitoring

As of 1.8 of Raygun4WP plugin you can enable [real user monitoring](https://raygun.com/products/real-user-monitoring).

This feature can be enabled via the Settings page under **Pulse - Real User Monitoring**.

User information will be sent along if you have the unique user tracking feature enabled.

## Client-side error tracking

Since 1.4 of the Raygun4WP plugin you can enable client-side error monitoring.

This feature automatically tracks JavaScript errors that occur in your user's browsers when they are loaded.

This setting can be activated via the Settings page.

## Unique user tracking

This feature can be enabled via the Settings page.

Enabling this feature will send through the currently logged in user's email address, first name and last name with each message to Raygun. This applies to both Crash Reporting and Pulse payloads.

If a user is not logged in, no user data will be sent and a random ID will be assigned to the user.

The user's information will then be available to you when viewing crash reports and user sessions. If the user has an associated Gravatar with that address, you will see their picture.

If this feature is not enabled, a random ID will be assigned to each user.

## Tagging errors

Since 1.8 both client-side and server-side errors can be tagged. Tags are custom test allowing you to easily identify errors.

JavaScript and PHP errors can be tagged independently through a comma-delimited list in the field on the settings page.   

For example: `Error, JavaScript` would add two tags. The first being `Error` second one being `JavaScript`

## Ignored domains

You can enter a comma-delimited list in the field on the settings page to prevent certain domains from sending errors and from being tracked with real user monitoring.

## Async sending

Introduced in 1.1.3, this provider will now send asynchronously on *nix servers (async sockets) resulting in a massive speedup - POSTing to Raygun now takes ~56ms including SSL handshakes. This behaviour can be disabled in code if desired to fall back to blocking socket sends. Async sending is also unavailable on Windows due to a bug in PHP 5.3, and as a result it uses cURL processes. This can be disabled if your server is running a newer environment; please create an issue if you'd like help with this.

## Multisite Support

It is recommended to use the most recent version WordPress and PHP possible. This procedure should be first followed on a staging server that matches your production environment as closely as possible, then replicated live.

1. On your root network site, install the plugin using the Admin dashboard's **plugin page** as standard, but **do not activate it**.
2. FTP in and modify `wp-content/plugins/raygun4wp/raygun4wp.php` - change the value on `line 12` to `true`.
3. Visit the Admin dashboard of a child site (not the root network site). Go to its Plugin page, and you should see Raygun4WP ready to be activated - do so.
4. A new Raygun4WP submenu will be added to the left. In there click on the **Raygun4WP settings page**, paste in your API key, change the top dropdown to Enabled then click *Save Changes*. You can now click *Send Test Error* and one will appear in your dashboard.
5. Repeat the above process for any other child sites - you can use different API keys (to send to different Raygun apps) or the same one.

Finally, if you so desire you should be able to visit the root network site, activate it there and configure it. You must however activate it on at least one child site first.

Changelog
---------

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
