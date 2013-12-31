<?php
/**
 * Plugin Name: Tutorial PluginHeaderReader
 * Plugin URI:  http://yoda.neun12.de
 * Text Domain: pluginheaderreader
 * Domain Path: /languages
 * Description: Tutorial for the PluginHeaderReader class.
 * Author:      Ralf Albert
 * Author URI:  http://yoda.neun12.de/
 * Version:     1.0
 * License:     GPLv3
 * DBVersion:		1.0.13
 * PHPMin:			5.3
 */
namespace RalfAlbert\Tutorial\PluginHeaderReader;

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
			return array( 'DBVersion', 'PHPMin' );
		},
		0,
		1
	);

	PluginHeaderReader::init( __FILE__, 'first' );

	/*
	 *  load the textdomain in a very complicated way ;)
	 */
	add_action( 'init', __NAMESPACE__ . '\init_textdomain', 0, 0 );

}

function add_dashboard_widget() {

	wp_add_dashboard_widget( 'debug-widget' . __NAMESPACE__, 'Debug Widget', __NAMESPACE__ . '\debug_output', $control_callback = null );

}

function debug_output() {

	/*
	 * re-create an instance of the PluginHeaderReader
	 */
	$pluginheaders = PluginHeaderReader::get_instance( 'first' );

	/*
	 * outputs some data from the stored pluginheaders
	 */
	printf(
		'<p>%s: <strong>%s</strong></p>',
		__( 'Name of the plugin which inserts this metabox', $pluginheaders->TextDomain ),
		$pluginheaders->Name
	);

	/*
	 * was the textdomain loaded?
	 *
	 * this is an example how to store additional data in the PluginHeaderReader class and use it in combination with the
	 * pluginheaders to load a textdomain
	 */
	$td_loaded = ( true == PluginStarter::$textdomain_loaded ) ? __( 'Yes', $pluginheaders->TextDomain ) : __( 'No', $pluginheaders->TextDomain );

	printf(
		'<p>%s %s</p>',
		__( 'The textdomain was successfully loaded?', $pluginheaders->TextDomain ),
		$td_loaded
	);

	$items = '';

	foreach ( $pluginheaders::$data->first as $header => $value ) {
		$items .= sprintf( "<li>%s:\t\t%s</li>", $header, $value );
	}

	printf(
		'<h3>%s</h3><ol>%s</ol>',
		__( 'All headers:', $pluginheaders->TextDomain ),
		$items
	);

}

function init_textdomain() {

	/*
	 * setup additional data for loading a textdomain
	 *
	 * to load the textdomain, we need the basename of the plugin
	 */
	$pluginheaders           = PluginHeaderReader::get_instance( 'first' );
	$pluginheaders->basename = dirname( plugin_basename( __FILE__ ) );

	PluginStarter::init_textdomain( $pluginheaders );

}