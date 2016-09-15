<iframe id="rgFrame" src='https://app.raygun.com?utm_source=wordpress&utm_medium=admin&utm_campaign=raygun4wp' frameborder="0" height="900px" width="100%"></iframe>

<script type="text/javascript">
  (function($) {

    $(document).ready(function() {

      var $dashboard = $('#rgFrame'),
        $adminBar = $('#wpadminbar');

      if( $dashboard.length == 0 ) {
        return;
      }

      var setHeight = function() {
        var height = window.innerHeight - $adminBar.height();
        $dashboard.height( String( height ) + "px");
      }

      setHeight();
      $(window).resize(setHeight);

    });

  })(jQuery)
</script>
