<?php
/*
Plugin Name: TGM New Media Plugin
Plugin URI: http://thomasgriffinmedia.com/
Description: This plugin gives an example of how to customize the new media manager experience in WordPress 3.5.
Author: Thomas Griffin
Author URI: http://thomasgriffinmedia.com/
Version: 1.0.0
License: GNU General Public License v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/*
    Copyright 2013   Thomas Griffin  (email : thomas@thomasgriffinmedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Main class for the plugin.
 *
 * @since 1.0.0
 *
 * @package TGM New Media Plugin
 * @author  Thomas Griffin
 */
class TGM_New_Media_Plugin {

    /**
     * Constructor for the class.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Load the plugin textdomain.
        load_plugin_textdomain( 'tgm-nmp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Load our custom assets.
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

        // Generate the custom metabox to hold our example media manager.
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

    }

    /**
     * Loads any plugin assets we may have.
     *
     * @since 1.0.0
     *
     * @return null Return early if not on a page add/edit screen
     */
    public function assets() {

        // Bail out early if we are not on a page add/edit screen.
        if ( ! ( 'post' == get_current_screen()->base && 'page' == get_current_screen()->id ) )
            return;

        // This function loads in the required media files for the media manager.
        wp_enqueue_media();

        // Register, localize and enqueue our custom JS.
        wp_register_script( 'tgm-nmp-media', plugins_url( '/js/media.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'tgm-nmp-media', 'tgm_nmp_media',
            array(
                'title'     => __( 'Upload or Choose Your Custom Image File', 'tgm-nmp' ), // This will be used as the default title
                'button'    => __( 'Insert Image into Input Field', 'tgm-nmp' )            // This will be used as the default button text
            )
        );
        wp_enqueue_script( 'tgm-nmp-media' );

    }

    /**
     * Create the custom metabox.
     *
     * @since 1.0.0
     */
    public function add_meta_boxes() {

        // This metabox will only be loaded for pages.
        add_meta_box( 'tgm-new-media-plugin', __( 'TGM New Media Plugin Settings', 'tgm-nmp' ), array( $this, 'metabox' ), 'page', 'normal', 'high' );

    }

    /**
     * Callback function to output our custom settings page.
     *
     * @since 1.0.0
     *
     * @param object $post Current post object data
     */
    public function metabox( $post ) {

        echo '<div id="tgm-new-media-settings">';
            echo '<p>' . __( 'Click on the button below to open up the media modal and watch your customizations come to life!', 'tgm-nmp' ) . '</p>';
            echo '<p><strong>' . __( 'Please note that none of this will save when you update the page. This is just for demonstration purposes only!', 'tgm-nmp' ) . '</strong></p>';
            echo '<p><a href="#" class="tgm-open-media button button-primary" title="' . esc_attr__( 'Click Here to Open the Media Manager', 'tgm-nmp' ) . '">' . __( 'Click Here to Open the Media Manager', 'tgm-nmp' ) . '</a></p>';
            echo '<p><label for="tgm-new-media-image">' . __( 'Our Image Goes Here!', 'tgm-nmp' ) . '</label> <input type="text" id="tgm-new-media-image" size="70" value="" /></p>';
        echo '</div>';

    }

}

// Instantiate the class.
$tgm_new_media_plugin = new TGM_New_Media_Plugin();