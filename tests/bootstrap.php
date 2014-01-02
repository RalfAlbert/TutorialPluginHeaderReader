<?php
// Load WordPress test environment
// https://github.com/nb/wordpress-tests
//
$GLOBALS['wp_tests_options'] = array (
		'active_plugins' => array (
				'tutorial_pluginheader_reader/index.php'
		),
		'template'   => 'twentyfourteen',
		'stylesheet' => 'twentyfourteen'
);

// define path to plugin folder
$plugin_path = dirname( dirname( __FILE__ ) );
! defined( 'PLUGIN_BASE_PATH' ) and define( 'PLUGIN_BASE_PATH', $plugin_path );
! defined( 'WPTESTS_CONFIG_FILE' ) and define( 'WPTESTS_CONFIG_FILE', dirname( __FILE__ ) . '/unittests-config.php' );
! defined( 'WPTESTS_QUIET_INSTALL' ) and define( 'WPTESTS_QUIET_INSTALL', true );

! defined( 'DO_WPUNITTESTING' ) and define( 'DO_WPUNITTESTING', true );

// include bootstrap
try {
	require_once '/WordPressTests/bootstrap.php';
}
catch ( Exception $e ) {
	exit( "Couldn't find path to WordPressTests/bootstrap.php\n" );
}

