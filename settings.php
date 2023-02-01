<div class="wrap">

    <h1>Raygun4WP Settings</h1>

    <form method="post" action="options.php">

        <?php settings_fields('rg4wp'); ?>

        <table class="form-table">

            <tr>
                <th><label for="apiKey"><?php _e("API Key"); ?></label></th>
                <td>
                    <input type="text" class="regular-text ltr" id="apiKey" name="rg4wp_apikey"
                           value="<?php echo get_option('rg4wp_apikey'); ?>"/>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="ignoreDomains"><?php _e("Domains To Ignore"); ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text ltr" id="ignoreDomains" name="rg4wp_ignoredomains"
                           value="<?php echo get_option('rg4wp_ignoredomains'); ?>"/>
                    <p class="description"><?php _e("Domains that shouldn't be tracked. Useful for development or multisite installations. Separate with commas."); ?></p>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="rg4wp_usertracking"><?php _e("Customers"); ?></label>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e("Customers"); ?></span></legend>
                        <label for="rg4wp_usertracking">
                            <input type="checkbox" name="rg4wp_usertracking"
                                   id="rg4wp_usertracking"<?php echo get_option('rg4wp_usertracking') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Track user information"); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>

        </table>

        <h2 class="title">Crash Reporting</h2>

        <table class="form-table">

            <tr>
                <th scope="row">
                    <?php _e("Error Tracking"); ?>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Error Tracking</span></legend>

                        <label for="rg4wp_status">
                            <input type="checkbox" name="rg4wp_status"
                                   id="rg4wp_status"<?php echo get_option('rg4wp_status') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Server-side errors"); ?> (PHP)
                        </label>
                        <br/>
                        <label for="rg4wp_js">
                            <input type="checkbox" name="rg4wp_js"
                                   id="rg4wp_js"<?php echo get_option('rg4wp_js') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Client-side errors"); ?> (JavaScript)
                        </label>
                        <br/>
                        <br/>
                        <label for="rg4wp_noadmintracking">
                            <input type="checkbox" name="rg4wp_noadmintracking"
                                   id="rg4wp_noadmintracking"<?php echo get_option('rg4wp_noadmintracking') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Disable tracking on admin pages"); ?>
                        </label>
                        <br/>
                        <label for="rg4wp_sendfatalerrors">
                            <input type="checkbox" name="rg4wp_sendfatalerrors"
                                   id="rg4wp_sendfatalerrors"<?php echo get_option('rg4wp_sendfatalerrors') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Capture fatal errors on shutdown"); ?>
                        </label>

                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="rg4wp_404s"><?php _e("Missing Pages"); ?></label></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Missing Pages</span></legend>

                        <label for="rg4wp_404s">
                            <input type="checkbox" name="rg4wp_404s"
                                   id="rg4wp_404s"<?php echo get_option('rg4wp_404s') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Send 404 errors"); ?>
                        </label>
                        <p class="description"><?php _e("Requires server-side error tracking"); ?></p>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="rg4wp_async"><?php _e("Serverside sending method") ?></label></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Serverside sending method</span></legend>

                        <label for="rg4wp_async">
                            <input type="checkbox" name="rg4wp_async"
                                   id="rg4wp_async"<?php echo get_option('rg4wp_async') ? ' checked="checked"' : ''; ?>
                                   value="1"/>
                            <?php _e("Send errors asynchronously"); ?>
                        </label>
                        <p class="description"><?php _e("Use asynchronous when sending server-side errors."); ?><em>(Only available on *Unix operating systems)</em></p>
                    </fieldset>
                </td>
            </tr>

        </table>

        <h3 class="title">Crash Reporting - Tags</h3>
        <p><?php _e("Tags are custom text that you can send with each error, for identification, testing and more. Separate with commas e.g 'tag1, tag2'"); ?></p>

        <table class="form-table">

            <tr>
                <th scope="row">
                    <label for="rg4wp_tags">PHP</label>
                </th>
                <td>
                    <input type="text" class="regular-text ltr" id="rg4wp_tags" name="rg4wp_tags"
                           value="<?php echo get_option('rg4wp_tags'); ?>"/>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="rg4wp_js_tags">JavaScript</label>
                </th>
                <td>
                    <input type="text" class="regular-text ltr" id="rg4wp_js_tags" name="rg4wp_js_tags"
                           value="<?php echo get_option('rg4wp_js_tags'); ?>"/>
                </td>
            </tr>

        </table>

        <p class="submit">
            <?php
            $current_user = wp_get_current_user();
            $testErrorUrl = plugins_url('sendtesterror.php?rg4wp_status=' . get_option('rg4wp_status') . '&rg4wp_apikey=' . urlencode(get_option('rg4wp_apikey')), __FILE__) . '&rg4wp_usertracking=' . urlencode(get_option('rg4wp_usertracking')) . '&user=' . urlencode($current_user->user_email);
            ?>
            <a id="js-send-test-error-link" class="button-secondary button-large" target="_blank"
               href="<?php echo $testErrorUrl; ?>">Send Test Error</a>
        </p>

        <h2 class="title">Real User Monitoring</h2>

        <table class="form-table">

            <tr>
                <th scope="row" class="th-full">
                    <label for="rg4wp_pulse">
                        <input type="checkbox" name="rg4wp_pulse"
                               id="rg4wp_pulse"<?php echo get_option('rg4wp_pulse') ? ' checked="checked"' : ''; ?>
                               value="1"/>
                        <?php _e("Enable Real User Monitoring"); ?>
                    </label>
                </th>
            </tr>

        </table>

        <input type="hidden" name="action" value="update"/>
        <input type="hidden" name="page_options"
               value="rg4wp_status,rg4wp_apikey,rg4wp_tags,rg4wp_404s,rg4wp_js,rg4wp_usertracking,rg4wp_ignoredomains,rg4wp_pulse,rg4wp_js_tags,rg4wp_noadmintracking,rg4wp_sendfatalerrors"/>

        <p class="submit">
            <?php
            submit_button("Save Changes", "primary", "submitForm", false, array('value' => 'submit'));
            ?>
        </p>
        <script>
            (function ($) {
                var $sendTestErrorLink = $('#js-send-test-error-link');
                var serverSideEnabled = $('#rg4wp_status').prop('checked');
                var clientSideEnabled = $('#rg4wp_js').prop('checked');
                var apiKeyValue = $('#apiKey').val();

                // Test if the API key has a value, and that either the server-side or client-side checkboxes have been checked on load
                var isValid = function () {
                    return apiKeyValue.length > 0 && (serverSideEnabled || clientSideEnabled);
                };

                // Disable the send test link immediately if the state is invalid
                if (!isValid()) {
                    $sendTestErrorLink
                        .prop('disabled', true)
                        .attr('title', 'Add your Raygun API key, select an Error Tracking option and click Save Changes to send a test error')
                        .addClass('button-disabled')
                        .css({cursor: 'help'});
                }

                // Disable link default behavior if invalid
                $sendTestErrorLink.on('click', function (e) {
                    if (!isValid()) {
                        e.preventDefault();
                    }
                });
            })(window.jQuery);
        </script>
    </form>
