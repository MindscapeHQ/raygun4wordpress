<style type="text/css">
   .rgleft
  {
      float: left;
  }

   .robbie
   {
      width: 85%;
      height: auto;
      margin-bottom: -25px;
   }

   .rgclear
   {
      clear: both;
   }

   .rgcol1
   {
      width: 65%;
      margin-right: 40px;
   }

   .rgButton
   {
      font-size: 110%;
      color: white;
      background: #0E5077;
      width: 140px;
      padding: 10px 14px;
      margin-top: 20px;
      text-align: center;
      border-radius: 5px;
   }

   .rgButton:hover
   {
      background: #1475AD;      
      cursor: default;
   }   
</style>

<div class="wrap">
   <div>
   <div class="rgleft rgcol1">
   <h2>About Raygun</h2>
   <p><a href="http://raygun.io" target="_blank">Raygun</a> is a leading error and crash reporting tool that allows developers to discover, track and resolve errors faster than before.</p>
   <p>Using the powerful web-based dashboard, you can view errors as they occur, and visualize their impact over time with the built-in charts.</p>
   <p><strong>Raygun</strong> is trusted by a multitude of developers creating and maintaining web, desktop and mobile applications. It has a simple, fast workflow with a beautiful interface that gives you the information you need to help keep your code running smoothly. Customizable email alerts can also be sent when an error occurs so you never miss out.</p>
<p>You can check it out right now with the <a href="http://app.raygun.io/signup" target="_blank">30-day free trial</a>.</p>
   </div>
   <div class="rgleft">
      <img src="http://raygun.io/images/robots/featurebot_handsup.png" class="robbie" />
   </div>
   </div>
   <div class="rgclear">
   <h2>Now available for Wordpress</h2>
   <p><strong>Raygun4WP</strong> is the official Raygun plugin for the Wordpress platform. It allows you to easily send and track all errors that occur on your Wordpress site, including HTTP errors and PHP exceptions.</p>
   <p>This plugin simplifies the installation and configuration of Raygun4php, the lower-level Raygun plugin. If you're reading this you have everything you need, and in a couple of minutes your site will be sending its errors to Raygun!</p>
   <p>If you don't already have an account, you can create one below. Then, in your <a href="http://app.raygun.io/dashboard" target="_blank">dashboard</a> create a new application, and copy the API key from its Settings page. Finally, paste it below and turn error reporting on. Any PHP errors or exceptions will be sent to Raygun and appear on your app's dashboard.</p>
   <h2>Next steps</h2>
   <ol>
   <li>Create a trial account at Raygun (it's quick and you can use many popular web accounts as your login info).</li>
   <li>In the Raygun Dashboard, create a new application to represent your Wordpress site.</li>
   <li>Copy the API key (including the '==' at the end) to the clipboard.</li>
   <li>Head to the <a href="admin.php?page=rg4wp-settings">Raygun4WP Configuration page</a> in this admin panel, and paste your API key into the appropriate field.</li>
   <li>Finally, change Error Reporting to 'Enabled', hit Submit, and you're done!</li>
   </ol>

   <div class="rgButton" onclick="rgSignup();" ><p>Create an account now</p></div>
   </div>
</div>

<script type="text/javascript">
  function rgSignup()
  {
    window.open("http://app.raygun.io/signup");
  }
</script>