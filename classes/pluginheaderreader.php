<?php
/**
 * PluginHeaderReader
 * @author Ralf Albert
 * @version 1.0
 *
 * Reads the plugin header from a given file and stores the data
 */
namespace RalfAlbert\Tutorial\PluginHeader_Reader;

class PluginHeaderReader implements I_PluginHeaderReader
{
	/**
	 * Object for data from plugin header
	 * @var Object
	 */
	public static $data = array();

	/**
	 * Flag to show if the pluginheaders was read
	 * @var boolean
	 */
	public static $headers_was_set = false;

	/**
	 * Reads the plugin header from given filename
	 * @param string $filename File with plugin header
	 * @return boolean False if the file does not exists
	 */
	public static function init( $filename = '' ) {

		if ( empty( $filename ) || ! file_exists( $filename ) )
			return false;

		if ( ! function_exists( 'get_plugin_data' ) )
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		$headers = get_plugin_data( $filename );

		if ( ! empty( $headers ) && is_array( $headers ) ) {

			self::$data = (object) $headers;
			self::$data->headers_was_set = true;

		}

		unset( $headers );

	}

	/**
	 * Returns an instance of itself
	 * @return object Instance of itself
	 */
	public static function get_instance() {
		return new self();
	}

	/**
	 * Returns a value
	 * @param string $name Name of the value
	 * @return mixed The value if it is set, else null
	 */
	public function __get( $name ) {

		if ( empty( $name ) )
			trigger_error( 'Error in ' . __METHOD__ . ': string expected', E_USER_NOTICE );

		return ( isset( self::$data->$name ) ) ? self::$data->$name : null;

	}

	/**
	 * Set a value
	 * @param string $name Name of the value
	 * @param string $value The value itself
	 */
	public function __set( $name, $value = null ) {

		if ( empty( $name ) )
			trigger_error( 'Error in ' . __METHOD__ . ': string expected', E_USER_NOTICE );

		if ( ! is_object( self::$data ) )
			self::$data = new \stdClass();

		self::$data->$name = $value;

	}

	/**
	 * Implements the isset() functionality to check if a propperty is set with isset()
	 * @param string $name Name of the propperty to check
	 * @return boolean True if the popperty is set, else false
	 */
	public function __isset( $name ) {

		if ( ! is_object( self::$data ) )
			return false;

		return ( property_exists( self::$data, $name ) ) ?
			true : false;

	}

}