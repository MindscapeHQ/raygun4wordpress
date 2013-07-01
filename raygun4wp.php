<?php
/*
Plugin Name: Raygun4WP
Plugin URI: http://github.com/mindscapehq/raygun4wordpress
Description: Official Wordpress plugin for the Raygun.io error reporting service
Version: 1.0.0.0
Author: Mindscape
Author URI: http://raygun.io
License: MIT
*/

register_activation_hook( __FILE__, 'rg4wp_install' );
register_deactivation_hook( __FILE__, 'rg4wp_uninstall' );

add_action( 'admin_menu', 'rg4wp_admin' );

function rg4wp_admin()
{
  add_menu_page('Raygun4WP', 'Raygun4WP', 'administrator', 'rg4wp', 'rg4wp_about');
  add_submenu_page('rg4wp', 'About Raygun4WP', 'About', 'administrator', 'rg4wp', 'rg4wp_about');
  add_submenu_page('rg4wp', 'Raygun4WP Configuration', 'Configuration', 'administrator', 'rg4wp-settings', 'rg4wp_settings');
  add_submenu_page('rg4wp', 'raygun.io dashboard', 'Raygun Dashboard', 'administrator', 'rg4wp-dash', 'rg4wp_dash');
  add_submenu_page('rg4wp', 'raygun.io', 'Visit raygun.io', 'administrator', 'rg4wp-visit', 'rg4wp_visit');
}

function rg4wp_settings()
{
  include dirname(__FILE__).'/settings.php';
}

function rg4wp_about()
{  
  include dirname(__FILE__).'/about.php';
}

function rg4wp_visit()
{
  include dirname(__FILE__).'/visit.php';
}

function rg4wp_dash()
{
  include dirname(__FILE__).'/dash.php';
}

function rg4wp_install()
{
  add_option('rg4wp_apikey', '', '', 'yes');
  add_option('rg4wp_tags', '', '', 'yes');
  add_option('rg4wp_status', '0', '', 'yes');
}

function rg4wp_uninstall()
{
  delete_option('rg4wp_setting_apikey');
}

if (get_option('rg4wp_status'))
{
   require_once dirname(__FILE__).'/external/raygun4php/src/Raygun4php/RaygunClient.php';
   $client = new Raygun4php\RaygunClient(get_option('rg4wp_apikey'));
   //$tags = get_option('rg4wp_tags');   

   function error_handler($errno, $errstr, $errfile, $errline ) {
        global $client;
        $client->SendError($errno, $errstr, $errfile, $errline);//, $tags);
    }

    function exception_handler($exception)
    {
        global $client;
        $client->SendException($exception);
    }

    set_exception_handler('exception_handler');
    set_error_handler("error_handler");
}

if (!get_option('rg4wp_apikey'))
  {
    function rg4wp_warning()
    {
      echo '<div class=\'updated fade\'><p><strong>Raygun4WP is almost ready to go.</strong> Enter your Raygun API key on the Configuration page then set the plugin to \'enabled\'.</p></div>';
    }
    add_action('admin_notices', 'rg4wp_warning');
  }