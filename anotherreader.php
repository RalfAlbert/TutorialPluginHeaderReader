<?php
/**
 * Plugin Name: Tutorial PluginHeaderReader 2
 * Plugin URI:  http://yoda.neun12.de
 * Text Domain: pluginheaderreader
 * Domain Path: /languages
 * Description: Testing multiple instances
 * Author:      Ralf Albert
 * Author URI:  http://yoda.neun12.de/
 * Version:     1.0
 * License:     GPLv3
 * DB:					2.0.14
 * PHPVersion:	5.3
 */
namespace RalfAlbert\Tutorial\PluginHeaderReader2;

use RalfAlbert\Tutorial\PluginHeaderReader\PluginHeaderReader;

!( defined( 'ABSPATH' ) ) AND die( 'Standing On The Shoulders Of Giants' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\plugin_construct', 0, 0 );


function plugin_construct() {

	/*
	 * include classes & interfaces
	 */
	$classes = glob( plugin_dir_path( __FILE__ ) . 'classes/*.php' );

	foreach( $classes as $class ) {
		require_once $class;
	}

	/*
	 * add a dashboard widget for the output
	 */
	add_action( 'wp_dashboard_setup',	__NAMESPACE__ . '\add_dashboard_widget' );

	/*
	 * creates a PluginHeaderReader and read the plugin header
	 */
	add_filter(
		"extra_plugin_headers",
		function( $extra_headers ) {
			return array( 'DB', 'PHPVersion' );
		},
		0,
		1
	);

	PluginHeaderReader::init( __FILE__, 'second' );

}

function add_dashboard_widget() {

	wp_add_dashboard_widget( 'debug-widget' . __NAMESPACE__, 'Debug Widget 2', __NAMESPACE__ . '\debug_output', $control_callback = null );

}

function debug_output() {

	/*
	 * re-create an instance of the PluginHeaderReader
	 */
	$pluginheaders = PluginHeaderReader::get_instance( 'second' );

	/*
	 * outputs some data from the stored pluginheaders
	 */
	printf(
		'<p>%s: <strong>%s</strong></p>',
		__( 'Name of the plugin which inserts this metabox', $pluginheaders->TextDomain ),
		$pluginheaders->Name
	);


	$items = '';

	foreach ( $pluginheaders::$data->second as $header => $value ) {
		$items .= sprintf( "<li>%s:\t\t%s</li>", $header, $value );
	}

	printf(
		'<h3>%s</h3><ol>%s</ol>',
		__( 'All headers:', $pluginheaders->TextDomain ),
		$items
	);

}
