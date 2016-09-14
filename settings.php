<div class="wrap">

   <h1>Raygun4WP Configuration</h1>

   <form method="post" action="options.php">

     <?php settings_fields( 'rg4wp' ); ?>

      <table class="form-table">

        <tr>
          <th><label for="apiKey">API Key</label></th>
          <td>
            <input type="text" size="60" id="apiKey" name="rg4wp_apikey" value="<?php echo get_option( 'rg4wp_apikey' ); ?>" />
          </td>
        </tr>

        <tr>
          <th>
            <label for="ignoreDomains">Domains to ignore</label>
          </th>
          <td>
            <input type="text" size="60" id="ignoreDomains" name="rg4wp_ignoredomains" value="<?php echo get_option( 'rg4wp_ignoredomains' ); ?>" />
          </td>
        </tr>

        <tr>
          <th>
            <label for="rg4wp_usertracking">User tracking</label>
          </th>
          <td>
            <input type="checkbox" name="rg4wp_usertracking" id="rg4wp_usertracking"<?php echo get_option('rg4wp_usertracking') ? ' checked="checked"': '';?> value="1" />
          </td>
        </tr>

      </table>

      <h2>Crash Reporting</h2>

      <table class="form-table">

        <tr>
          <th>
            <label for="rg4wp_status">Track PHP errors<label>
          </th>
          <td>
            <input type="checkbox" name="rg4wp_status" id="rg4wp_status"<?php echo get_option('rg4wp_status') ? ' checked="checked"': ''; ?> value="1" />
          </td>
        </tr>

        <tr>
          <th>
            <label for="rg4wp_js">Track JavaScript errors</label>
          </th>
          <td>
            <input type="checkbox" name="rg4wp_js" id="rg4wp_js"<?php echo get_option('rg4wp_js') ? ' checked="checked"': '';?> value="1" />
          </td>
        </tr>

        <tr>
          <th>
            <label for="rg4wp_404s">Send 404 errors</label>
          </th>
          <td>
            <input type="checkbox" name="rg4wp_404s" id="rg4wp_404s"<?php echo get_option('rg4wp_404s') ? ' checked="checked"': ''; ?> value="1" />
          </td>
        </tr>

        <tr>
          <th>
            <label for="rg4wp_tags">PHP Tags</label>
          </th>
          <td>
            <input type="text" size="60" id="rg4wp_tags" name="rg4wp_tags" value="<?php echo get_option('rg4wp_tags'); ?>" />
          </td>
        </tr>

        <tr>
          <th>
            <label for="rg4wp_js_tags">JavaScript Tags</label>
          </th>
          <td>
            <input type="text" size="60" id="rg4wp_js_tags" name="rg4wp_js_tags" value="<?php echo get_option('rg4wp_js_tags'); ?>" />
          </td>
        </tr>

      </table>

      <h2>Pulse - Real User Monitoring</h2>

      <table class="form-table">

        <tr>
          <th>
            <label for="rg4wp_pulse">Enable</label>
          </th>
          <td>
            <input type="checkbox" name="rg4wp_pulse" id="rg4wp_pulse"<?php echo get_option('rg4wp_pulse') ? ' checked="checked"': '';?> value="1" />
          </td>
        </tr>

      </table>

      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="rg4wp_status,rg4wp_apikey,rg4wp_tags,rg4wp_404s,rg4wp_js,rg4wp_usertracking,rg4wp_ignoredomains,rg4wp_pulse,rg4wp_js_tags" />

      <?php
        $current_user = wp_get_current_user();
        $testErrorUrl = plugins_url('sendtesterror.php?rg4wp_status='.get_option('rg4wp_status').
          '&rg4wp_apikey='.urlencode(get_option('rg4wp_apikey')), __FILE__).'&rg4wp_usertracking='
          .get_option('rg4wp_usertracking').'&user=' . $current_user->user_email;
      ?>

      <div style="display: inline; margin-top: 10px;">
        <div style="margin-right: 10px; float: left;">
          <?php
            submit_button("Save Changes", "primary", "submitForm", false, array('value' => 'submit'));
          ?>
        </div>
        <a class="button-secondary button-large" target="_blank" href="<?php echo $testErrorUrl; ?>" style="float: left;">Send Test Error</a>
      </div>
    </form>
