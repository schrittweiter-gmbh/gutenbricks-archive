<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://schrittweiter.de
 * @since             1.0.0
 * @package           GutenBricks_Archive
 *
 * @wordpress-plugin
 * Plugin Name:       GutenBricks Archive
 * Description:       Adds ability to use GutenBricks also on archive and term pages
 * Version:           1.0.0
 * Requires PHP:      8.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gutenbricks-archive
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
use GutenBricks_Archive\Activator;
use GutenBricks_Archive\Deactivator;
use GutenBricks_Archive\GutenBricks_Archive;
use GutenBricks_Archive\Uninstallor;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin absolute path
 */
require plugin_dir_path( __FILE__ ) . 'constants.php';

/**
 * Use Composer PSR-4 Autoloading
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require plugin_dir_path( __FILE__ ) . 'vendor/vendor-prefixed/autoload.php';

/**
 * The code that runs during plugin activation.
 */
function activate_gutenbricks_archive(): void {
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_gutenbricks_archive(): void {
	Deactivator::deactivate();
}

/**
 * The code that runs during plugin uninstallation.
 */
function uninstall_gutenbricks_archive(): void {
	Uninstallor::uninstall();
}

register_activation_hook( __FILE__, 'activate_gutenbricks_archive' );
register_deactivation_hook( __FILE__, 'deactivate_gutenbricks_archive' );
register_uninstall_hook( __FILE__, 'uninstall_gutenbricks_archive' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gutenbricks_archive(): void {
	$plugin = new GutenBricks_Archive();
	$plugin->run();
}
run_gutenbricks_archive();
