<?php
namespace C4C ;

/**
 * @wordpress-plugin
 * Plugin Name:       Courses4Career
 * Plugin URI:        brbaso.com
 * Description:       Choose suitable Sensei courses depending on career chosen.
 * Version:           1.0.0
 * Author:            brbaso
 * Author URI:        brbaso.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       courses-for-career
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require __DIR__ . '/vendor/autoload.php';

use C4C\Includes\Courses_For_Career ;

/**
 * Plugin activation deactivation.
 */
register_activation_hook( __FILE__, array( 'C4C\Includes\Courses_For_Career_Activator', 'courses_for_career_create_db' ) );
register_deactivation_hook( __FILE__, array( 'C4C\Includes\Courses_For_Career_Deactivator', 'deactivate' ) );

/**
 * Run the plugin.
 * @since    1.0.0
 */
$plugin = new Courses_For_Career();
$plugin->run();
