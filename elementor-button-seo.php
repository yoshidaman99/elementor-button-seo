<?php
/**
 * Plugin Name: Elementor Button SEO
 * Plugin URI: https://github.com/yoshidaman99/elementor-button-seo
 * Description: Adds SEO and accessibility enhancements to Elementor Button widgets — Schema.org JSON-LD, aria-label, and title attributes to fix "Links do not have descriptive text" audit issues.
 * Version: 1.0.0
 * Requires at least: 5.9
 * Requires PHP: 7.4
 * Author: yoshidaman99
 * Author URI: https://github.com/yoshidaman99
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elementor-button-seo
 * Domain Path: /languages
 *
 * @package Elementor_Button_SEO
 */

namespace Elementor_Button_SEO;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ELEMENTOR_BUTTON_SEO_VERSION', '1.0.0' );
define( 'ELEMENTOR_BUTTON_SEO_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_BUTTON_SEO_URL', plugin_dir_url( __FILE__ ) );
define( 'ELEMENTOR_BUTTON_SEO_BASENAME', plugin_basename( __FILE__ ) );

spl_autoload_register( function ( $class ) {
	$prefix = 'Elementor_Button_SEO\\';
	$base_dir = __DIR__ . '/src/';

	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$relative_class = substr( $class, $len );
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
} );

function elementor_button_seo_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', function () {
			$message = sprintf(
				esc_html__( '%1$s requires Elementor to be installed and activated.', 'elementor-button-seo' ),
				'<strong>' . esc_html__( 'Elementor Button SEO', 'elementor-button-seo' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning"><p>%s</p></div>', $message );
		} );
		return;
	}

	new \Elementor_Button_SEO\Elementor\Button_SEO();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\elementor_button_seo_init' );
