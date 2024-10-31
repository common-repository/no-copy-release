<?php
/**
* Plugin Name: [Enqtran] No Copy Release
* Plugin URI: http://enqtran.com/
* Description: No Copy Release
* Author: enqtran
* Version: 1.0
* Author URI: http://enqtran.com/
* Donate link: http://enqtran.com/
* License: GPLv3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Tags: enqtran, enq, enqpro, no, copy release
*/

/*
* Plugin support
* Last update: 09/12/2015
*/

add_action( 'admin_menu', 'register_plugins_no_copy_release_page' );
function register_plugins_no_copy_release_page() {
    // add_menu_page( 'No Copy Release', 'No Copy Release', 'manage_options', 'no-copy-release', 'no_copy_release_setting_page', 'dashicons-lock' /*get_template_directory_uri().'/images/options.png'*/,160 );
    add_theme_page( 'No Copy Release', 'No Copy Release', 'manage_options', 'no-copy-release', 'no_copy_release_setting_page' );
}

add_action( 'admin_init' , 'plugin_register_option_no_copy_release' );
function plugin_register_option_no_copy_release() {
    register_setting( 'no_copy_release' , 'no_copy_all' );
    register_setting( 'no_copy_release' , 'copy_and_link' );
    register_setting( 'no_copy_release' , 'copy_and_info' );
}

function no_copy_release_setting_page() { ?>
    <div class="wrap">
        <?php echo get_screen_icon(); ?>
        <div>
            <h1>No Copy Release</h1>
        </div>
        <div class="box-form-option">
            <form action="options.php" method="post" id="theme_setting" onsubmit="if( (document.getElementById('no_copy_all').checked) && (document.getElementById('copy_and_link').checked) ) { alert('You cant choose the same 2 properties at once !' ); return false; } else { return true; }">
            <?php settings_fields( 'no_copy_release' ); ?>
            <?php submit_button( 'Save Changes','primary' ); ?>
            <style>
                .fix-width {
                    width:200px;
                }
                .pad {
                    padding:10px 20px;
                }
            </style>
            <table class="theme_page widefat" >
                <tr>
                    <th class="fix-width">Turn On No Copy All</th>
                    <td>
                        <input type="checkbox" id="no_copy_all" name="no_copy_all" <?php checked( get_option( 'no_copy_all' ), 'on');?> /> No Copy All. Disabled Ctrl+C, Ctrl+X, Click right mouse, Select.
                    </td>
                </tr>
                <tr>
                    <th class="fix-width">Turn On Copy And Link</th>
                    <td>
                        <p><input type="checkbox" id="copy_and_link" name="copy_and_link" <?php checked( get_option( 'copy_and_link' ), 'on');?> /> Content copy will insert text link of website.</p>
                        <p>
                            <textarea class="widefat" name="copy_and_info" rows="4" placeholder="Caption after link"><?php echo get_option( 'copy_and_info' ); ?></textarea>
                        </p>
                    </td>
                </tr>
            </table>
            <?php submit_button( 'Save Changes','primary' ); ?>

        </form>
        </div>
    </div>
<?php
}

/**
* Turn on no copy
*/
if ( (get_option( 'copy_and_link' ) != 'on') && (get_option( 'no_copy_all' ) == 'on' ) ) {
	add_action( 'wp_footer', 'nocopy_release_javascript', 7);
	function nocopy_release_javascript() {
	    wp_register_script('NoCopyAll', plugins_url( 'no-copy-release/js/NoCopyAll.js', dirname(__FILE__) ) );
	    wp_enqueue_script('NoCopyAll');
	}
}
if ( (get_option( 'copy_and_link' ) == 'on') && (get_option( 'no_copy_all' ) != 'on' ) ) {
    add_action( 'wp_footer', 'nocopy_release_javascript', 7);
    function nocopy_release_javascript() {
        $content = get_option( 'copy_and_info' );
        echo "<script>";
        echo "var copy_and_info = '$content'";
        echo "</script>";
        wp_register_script('CopyAndLink', plugins_url( 'no-copy-release/js/CopyAndLink.js', dirname(__FILE__) ) );
        wp_enqueue_script('CopyAndLink');
    }
}

