<?php

echo '  
    <style type="text/css">
      .tooltip {
      display:none;
      position:absolute;
      border:2px solid #333;
      background-color:#efefef;
      border-radius:5px;
      padding:10px;
      color:#111;
      font-size:12px Arial;
      width: 300px;
    }
    </style>
     <div class="wrap">
     <h2>Raygun4WP Configuration</h2>
     <p>You can add your API key and customize your settings here.</p>     

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
      <td style="width: 336px;"><input type="text" size="60" name="rg4wp_tags" value="';
echo get_option('rg4wp_tags');
echo '" /></td><td><img src="'.plugin_dir_url(__FILE__).'img/q.gif'.'" class="masterTooltip" title="Tags are custom text that you can send with each error, for identification, testing and more. They should be a comma-separated list e.g. \'tag1,tag2\'"
      style=" width: 20px; height: 20px;" /></td></td>      
      </tr>      
      </table>
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="rg4wp_status,rg4wp_apikey,rg4wp_tags" />

      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

      <script type="text/javascript">
$(document).ready(function() {
// Tooltip only Text
$(\'.masterTooltip\').hover(function(){
        // Hover over code
        var title = $(this).attr(\'title\');
        $(this).data(\'tipText\', title).removeAttr(\'title\');
        $(\'<p class="tooltip"></p>\')
        .text(title)
        .appendTo(\'body\')
        .fadeIn(\'slow\');
}, function() {
        // Hover out code
        $(this).attr(\'title\', $(this).data(\'tipText\'));
        $(\'.tooltip\').remove();
}).mousemove(function(e) {
        var mousex = e.pageX + 20; //Get X coordinates
        var mousey = e.pageY + 10; //Get Y coordinates
        $(\'.tooltip\')
        .css({ top: mousey, left: mousex })
});
});
</script>
      ';
    
submit_button();
?>