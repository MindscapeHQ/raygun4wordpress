<?php
/*
Plugin Name: Raygun4WP
Plugin URI: http://github.com/mindscapehq/raygun4wordpress
Description: Exceptional error, exception and 404 tracking with Raygun.io for your Wordpress site. This service lets you monitor your site's health with beautiful graphs and comprehensive reports, so you are always aware of any points of failure. Daily digests are emailed to you, so an overview is available at a glance- no effort required. This plugin has a simple one-minute, no-code-required installation.
Version: 1.0.0.3
Author: Mindscape
Author URI: http://raygun.io
License: MIT
*/

register_activation_hook( __FILE__, 'rg4wp_install' );
register_deactivation_hook( __FILE__, 'rg4wp_uninstall' );

add_action( 'admin_menu', 'rg4wp_admin' );
add_action( 'admin_menu', 'rg4wp_external');
add_action( 'template_redirect', 'rg4wp_404_handler');

function rg4wp_admin()
{
  add_menu_page('Raygun4WP', 'Raygun4WP', 'administrator', 'rg4wp', 'rg4wp_about');
  add_submenu_page('rg4wp', 'About Raygun4WP', 'About', 'administrator', 'rg4wp', 'rg4wp_about');
  add_submenu_page('rg4wp', 'Raygun4WP Configuration', 'Configuration', 'administrator', 'rg4wp-settings', 'rg4wp_settings');
  add_submenu_page('rg4wp', 'raygun.io dashboard', 'Raygun Dashboard', 'administrator', 'rg4wp-dash', 'rg4wp_dash');  
}

function rg4wp_external()
{
  global $submenu;
  $submenu['rg4wp'][500] = array('Open raygun.io', 'administrator', 'javascript:window.open("http://raygun.io?utm_source=wordpress&utm_medium=admin&utm_campaign=raygun4wp");return false;');
}

function rg4wp_settings()
{
  include dirname(__FILE__).'/settings.php';
}

function rg4wp_about()
{  
  include dirname(__FILE__).'/about.php';
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
  add_option('rg4wp_404s', '1', '', 'yes');
}

function rg4wp_uninstall()
{
  delete_option('rg4wp_setting_apikey');
  delete_option('rg4wp_tags');
  delete_option('rg4wp_status');
  delete_option('rg4wp_404s');
}

function rg4wp_404_handler()
{
    if (get_option('rg4wp_404s') && is_404())
    {
      require_once dirname(__FILE__).'/external/raygun4php/src/Raygun4php/RaygunClient.php';
      $client = new Raygun4php\RaygunClient(get_option('rg4wp_apikey'));
      $tags = explode(',', get_option('rg4wp_tags'));  

      $uri = $_SERVER['REQUEST_URI']; 

      $client->SendError(404, '404 Not Found: '.$uri, home_url().$uri, '0', $tags); 
    }
}

if (get_option('rg4wp_status'))
{
   require_once dirname(__FILE__).'/external/raygun4php/src/Raygun4php/RaygunClient.php';
   $client = new Raygun4php\RaygunClient(get_option('rg4wp_apikey'));
   $tags = explode(',', get_option('rg4wp_tags'));   
   
   function error_handler($errno, $errstr, $errfile, $errline ) {
        global $client, $tags;        
        $client->SendError($errno, $errstr, $errfile, $errline, $tags);
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
  function rg4wp_warn_key()
  {
    echo '<div class=\'updated fade\'><p><strong>Raygun4WP is almost ready to go.</strong> Enter your Raygun API key on the Configuration page then set the plugin to \'enabled\'.</p></div>';
  }
  add_action('admin_notices', 'rg4wp_warn_key');
}

if (!function_exists('curl_version'))
{
  function rg4wp_warn_curl()
  {
    echo '<div class=\'updated fade\'><p><strong>Raygun4WP: the cURL extension is not available in your PHP server.</strong> Raygun4WP requires this library to send errors - please install and enable it (in your php.ini file).</p></div>';
  }
  add_action('admin_notices', 'rg4wp_warn_curl');
}