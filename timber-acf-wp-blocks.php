<?php

/**
 * Timber ACF WP Blocks
 *
 * @package     palmiak/timber-acf-wp-blocks
 * @author      Maciej Palmowski <m.palmowski@freshpixels.pl>
 * @copyright   2019 Maciej Palmowski
 * @license     MIT https://github.com/szepeviktor/palmiak_timber-acf-wp-blocks/blob/master/LICENSE
 * @link        https://palmiak.github.io/timber-acf-wp-blocks/
 */

// Prevent direct execution.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if class exists before redefining it.
 */
if ( ! class_exists( 'Timber_Acf_Wp_Blocks' ) ) {
	require __DIR__ . '/inc/class-timber-acf-wp-blocks.php';
}

add_action(
	'after_setup_theme',
	function () {
		new Timber_Acf_Wp_Blocks();
	}
);
