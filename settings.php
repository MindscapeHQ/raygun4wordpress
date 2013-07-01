<?php

echo '<div class="wrap">
     <h2>Raygun4WP Configuration</h2>
     <p>You can add your API key and customize your settings here.</p>
     <p>If you don\'t already have an account, you can create one at  <a href="http://app.raygun.io/signup" target="_blank">raygun.io/signup</a>. Then, in your <a href="http://app.raygun.io/dashboard" target="_blank">dashboard</a> create a new application, and copy the API key from its Settings page. Finally, paste it below and turn error reporting on. Any PHP errors or exceptions will be sent to Raygun and appear on your app\'s dashboard.</p>

     <form method="post" action="options.php">';

wp_nonce_field( 'update-options' );

echo '<table class="form-table">
      <tr valign="top">
      <th scope="row">Error Reporting Status</th>
      <td>
		  <select name="rg4wp_status">
		  <option value="0"';
echo ! get_option( 'rg4wp_status' ) ? ' selected="selected"': '';
echo  '>Disabled</option>
		  <option value="1"';
echo get_option( 'rg4wp_status' ) ? ' selected="selected"': '';
echo  '>Enabled</option>
      </select>

      <tr valign="top">
      <th scope="row">API Key</th>
      <td><input type="text" size="60" name="rg4wp_apikey" value="';
echo get_option( 'rg4wp_apikey' );
echo  '" /></td>
      </tr>
	    </td>
      </tr>

      <tr valign="top">
      <th scope="row">Tags</th>
      <td><input type="text" size="60" name="rg4wp_tags" value="';
echo get_option('rg4wp_tags');
echo '" /></td>
      </tr>

      </table>
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="rg4wp_status,rg4wp_apikey,rg4wp_tags" />';
    
submit_button();
?>