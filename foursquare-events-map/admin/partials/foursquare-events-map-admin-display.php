<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.thecyberworld.org
 * @since      1.0.0
 *
 * @package    Foursquare_Events_Map
 * @subpackage Foursquare_Events_Map/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
/**
*
* admin/partials/wp-cbf-admin-display.php - Don't add this comment
*
**/
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
    <form method="post" name="cleanup_options" action="options.php">
    
        <!-- remove some meta and generators from the <head> -->
        <fieldset>
            <legend class="screen-reader-text"><span>API</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-cleanup">
                <input type="text" id="<?php echo $this->plugin_name; ?>-cleanup" name="<?php echo $this->plugin_name; ?> [cleanup]" value="API KEY"/>
                <span><?php esc_attr_e('FourSquare API Key', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <!-- remove injected CSS from comments widgets -->
        <fieldset>
            <legend class="screen-reader-text"><span>Secret Key</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-comments_css_cleanup">
                <input type="text" id="<?php echo $this->plugin_name; ?>-comments_css_cleanup" name="<?php echo $this->plugin_name; ?>[comments_css_cleanup]" value="SECRET KEY"/>
                <span><?php esc_attr_e('Secret Key', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        
        

        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>
