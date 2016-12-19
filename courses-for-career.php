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
use C4C\Includes\Courses_For_Career_Activator ;
use C4C\Includes\Courses_For_Career_Deactivator ;
/**
 * plugin activation. 
 */
function activate_courses_for_career() {

	Courses_For_Career_Activator::activate();	
}

/**
 * plugin deactivation.
 */
function deactivate_courses_for_career() {

	Courses_For_Career_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_courses_for_career' );
register_deactivation_hook( __FILE__, 'deactivate_courses_for_career' );

/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
function run_courses_for_career() {
	//$plugin = new C4C\Courses_For_Career\ Courses_For_Career();
	$plugin = new Courses_For_Career();
	$plugin->run();
}
run_courses_for_career();
