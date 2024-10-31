<?php

use ResponsiveSidebar\ResponsiveSidebarPlugin;

/**
 *
 * Plugin Name:       Responsive Sidebar
 * Plugin URI:        https://processby.com/responsive-sidebar-wordpress-plugin/
 * Description:       Makes your sidebar responsive.
 * Version:           1.2.2
 * Author:            Processby
 * Author URI:        https://processby.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       responsive-sidebar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

call_user_func( function () {

	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

	$main = new ResponsiveSidebarPlugin( __FILE__ );

	register_activation_hook( __FILE__, [ $main, 'activate' ] );

	register_deactivation_hook( __FILE__, [ $main, 'deactivate' ] );

	register_uninstall_hook( __FILE__, [ ResponsiveSidebarPlugin::class, 'uninstall' ] );

	$main->run();
} );