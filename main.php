<?php

use Raygun\Raygun4WP\RaygunClient;
use Raygun\Raygun4WP\RaygunClientManager;

register_activation_hook(__FILE__, 'rg4wp_install');
register_deactivation_hook(__FILE__, 'rg4wp_uninstall');

add_action('admin_init', 'rg4wp_register_settings');
add_action('admin_menu', 'rg4wp_admin');
add_action('admin_enqueue_scripts', 'rg4wp_admin_styles');
add_action('template_redirect', 'rg4wp_404_handler');
add_action('wp_enqueue_script', 'load_jquery');

if (
    (1 == get_option('rg4wp_js') || 1 == get_option('rg4wp_pulse'))
    && get_option('rg4wp_apikey')
    && !rg4wp_isIgnoredDomain()
    && !(1 == get_option('rg4wp_noadmintracking', 0) && is_admin())
) {
    add_action('wp_head', 'rg4wp_js', 0);
    add_action('admin_head', 'rg4wp_js', 0);
}

function rg4wp_js() {
    $script = '
        <script type="text/javascript">
          !function(a,b,c,d,e,f,g,h){a.RaygunObject=e,a[e]=a[e]||function(){
          (a[e].o=a[e].o||[]).push(arguments)},f=b.createElement(c),g=b.getElementsByTagName(c)[0],
          f.async=1,f.src=d,g.parentNode.insertBefore(f,g),h=a.onerror,a.onerror=function(b,c,d,f,g){
          h&&h(b,c,d,f,g),g||(g=new Error(b)),a[e].q=a[e].q||[],a[e].q.push({
          e:g})}}(window,document,"script","//cdn.raygun.io/raygun4js/raygun.min.js","rg4js");
        </script>
        <script type="text/javascript">
        rg4js("apiKey", "%s");
		rg4js("setVersion", "%s");
    ';

    if (1 == get_option('rg4wp_js')) {
        $script .= 'rg4js("enableCrashReporting", true);' . "\n";
    }

    if (get_option('rg4wp_js_tags')) {
        $script .= 'rg4js("withTags",[';
        $tags = explode(',', get_option('rg4wp_js_tags'));
        foreach ($tags as $key => $tag) {
            if (0 !== $key) {
                $script .= ',';
            }
            $script .= '"' . trim($tag) . '"';
        }
        $script .= ']);' . "\n";
    }

    if (1 == get_option('rg4wp_pulse')) {
        $script .= 'rg4js("enablePulse", true);' . "\n";
    }

    if (1 == get_option('rg4wp_usertracking') && is_user_logged_in()) {
        $user = wp_get_current_user();
        $script .= sprintf(
                'rg4js("setUser", {isAnonymous: false, identifier: "%s", email: "%s", firstName: "%s", fullName: "%s" });',
                $user->user_email,
                $user->user_email,
                $user->user_firstname,
                $user->user_firstname . ' ' . $user->user_lastname
            ) . "\n";
    }

    $script .= '</script>';
    printf($script, get_option('rg4wp_apikey'), get_bloginfo('version'));
}

function load_jquery() {
    wp_enqueue_script('jquery');
}

function rg4wp_admin() {
    $logourl = plugins_url('img/logo.png', __FILE__);
    add_menu_page('Raygun4WP', 'Raygun4WP', 'administrator', 'rg4wp', 'rg4wp_about', $logourl);
    add_submenu_page('rg4wp', 'About Raygun4WP', 'About', 'administrator', 'rg4wp', 'rg4wp_about');
    add_submenu_page('rg4wp', 'Settings', 'Settings', 'administrator', 'rg4wp-settings', 'rg4wp_settings');
    add_submenu_page('rg4wp', 'Dashboard', 'Raygun Dashboard', 'administrator', 'rg4wp-dash', 'rg4wp_dash');
}

function rg4wp_settings() {
    include dirname(__FILE__) . '/settings.php';
}

function rg4wp_about() {
    include dirname(__FILE__) . '/about.php';
}

function rg4wp_dash() {
    include dirname(__FILE__) . '/dash.php';
}

function rg4wp_install() {
    add_option('rg4wp_apikey', '', '', 'yes');
    add_option('rg4wp_tags', '', '', 'yes');
    add_option('rg4wp_status', '0', '', 'yes');
    add_option('rg4wp_usertracking', '0', '', 'yes');
    add_option('rg4wp_404s', '1', '', 'yes');
    add_option('rg4wp_js', '1', '', 'yes');
    add_option('rg4wp_ignoredomains', '', '', 'yes');
    add_option('rg4wp_pulse', '', '', 'yes');
    add_option('rg4wp_js_tags', '', '', 'yes');
    add_option('rg4wp_async', '0', '', 'yes');
    add_option('rg4wp_noadmintracking', '0', '', 'yes');
    add_option('rg4wp_sendfatalerrors', '0', '', 'yes');
}

function rg4wp_uninstall() {
    delete_option('rg4wp_apikey');
    delete_option('rg4wp_tags');
    delete_option('rg4wp_status');
    delete_option('rg4wp_404s');
    delete_option('rg4wp_js');
    delete_option('rg4wp_usertracking');
    delete_option('rg4wp_ignoredomains');
    delete_option('rg4wp_pulse');
    delete_option('rg4wp_js_tags');
    delete_option('rg4wp_async');
    delete_option('rg4wp_noadmintracking');
    delete_option('rg4wp_sendfatalerrors');
}

function rg4wp_checkUser(RaygunClient $client): RaygunClient {
    if (1 == get_option('rg4wp_usertracking') && is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $client->SetUser(
            $current_user->user_email,
            $current_user->user_firstname,
            $current_user->user_firstname . ' ' . $current_user->user_lastname,
            $current_user->user_email,
            false
        );
    }
    return $client;
}

function rg4wp_isIgnoredDomain(): bool {
    $domains = array_map('trim', explode(',', get_option('rg4wp_ignoredomains', '')));
    return array_key_exists('SERVER_NAME', $_SERVER) && in_array($_SERVER['SERVER_NAME'], $domains);
}

function rg4wp_useAsyncSending(): bool {
    return 1 == get_option('rg4wp_async');
}

function rg4wp_404_handler() {
    if (
        1 == get_option('rg4wp_status')
        && 1 == get_option('rg4wp_404s')
        && !rg4wp_isIgnoredDomain()
        && is_404()
        && get_option('rg4wp_apikey')
        && !(1 == get_option('rg4wp_noadmintracking', 0) && is_admin())
    ) {
        $tags = array_map('trim', explode(',', get_option('rg4wp_tags')));
        if (!is_array($tags)) {
            $tags = [];
        }

        $client = rg4wp_checkUser(RaygunClientManager::getInstance());
        $client->SetVersion(get_bloginfo('version'));
        $uri = $_SERVER['REQUEST_URI'];
        $client->SendError(404, '404 Not Found: ' . $uri, home_url() . $uri, '0', $tags);
    }
}

if (
    1 == get_option('rg4wp_status')
    && !rg4wp_isIgnoredDomain()
    && get_option('rg4wp_apikey')
    && !(1 == get_option('rg4wp_noadmintracking', 0) && is_admin())
) {
    $tags = array_map('trim', explode(',', get_option('rg4wp_tags')));
    if (!is_array($tags)) {
        $tags = [];
    }

    $client = RaygunClientManager::getInstance();
    $client->SetVersion(get_bloginfo('version'));

    add_action('plugins_loaded', 'rg4wp_get_user_details');

    function rg4wp_get_user_details()
    {
        if (1 == get_option('rg4wp_status')) {
            global $client;
            $client = rg4wp_checkUser($client);
        }
    }

    function rg4wp_get_user_details() {
        if ( 1 == get_option('rg4wp_status')) {
            global $client;
            $client = rg4wp_checkUser($client);
        }
    }

    set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($client, $tags) {
        if (1 == get_option('rg4wp_status')) {
            $client->SendError($errno, $errstr, $errfile, $errline, $tags);
        }
    });

    set_exception_handler(function ($exception) use ($client, $tags) {
        if (1 == get_option('rg4wp_status')) {
            $client->SendException($exception, $tags);
        }
    });

    register_shutdown_function(function () use ($client, $tags) {
        if (1 == get_option('rg4wp_sendfatalerrors') && 1 == get_option('rg4wp_status')) {
            $lastError = error_get_last();
            if (!is_null($lastError) && $lastError['type'] === E_ERROR) {
                // A fatal error has occurred
                [$type, $message, $file, $line] = $lastError;
                $tags = array_merge($tags, ['fatal-error']);
                $client->SendError($type, $message, $file, $line, $tags);
            }
        }
    });

    if ($client->isAsync()) {
        register_shutdown_function([$client->getTransport(), 'wait']);
    }
}

if (!get_option('rg4wp_apikey')) {
    function rg4wp_warn_key() {
        echo '<div class=\'updated fade\'><p>Raygun is almost ready to go. Enter your API key on the <a href="' . menu_page_url(
                'rg4wp-settings',
                false
            ) . '">settings page</a>.</p></div>';
    }

    add_action('admin_notices', 'rg4wp_warn_key');
}

if (!function_exists('curl_version')) {
    function rg4wp_warn_curl() {
        echo '<div class=\'updated fade\'><p><strong>Raygun4WP: the cURL extension is not available in your PHP server.</strong> Raygun4WP requires this library to send errors - please install and enable it (in your php.ini file).</p></div>';
    }

    add_action('admin_notices', 'rg4wp_warn_curl');
}

function rg4wp_register_settings() {
    register_setting('rg4wp', 'rg4wp_apikey');
    register_setting('rg4wp', 'rg4wp_tags');
    register_setting('rg4wp', 'rg4wp_status');
    register_setting('rg4wp', 'rg4wp_404s');
    register_setting('rg4wp', 'rg4wp_js');
    register_setting('rg4wp', 'rg4wp_usertracking');
    register_setting('rg4wp', 'rg4wp_ignoredomains');
    register_setting('rg4wp', 'rg4wp_pulse');
    register_setting('rg4wp', 'rg4wp_js_tags');
    register_setting('rg4wp', 'rg4wp_async');
    register_setting('rg4wp', 'rg4wp_noadmintracking');
    register_setting('rg4wp', 'rg4wp_sendfatalerrors');
}

function rg4wp_admin_styles($hook) {
    wp_register_style('rg4wp_css', plugins_url('css/style.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('rg4wp_css');
}
