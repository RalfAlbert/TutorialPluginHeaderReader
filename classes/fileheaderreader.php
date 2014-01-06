<?php
/**
 * WordPress Class to read and keep the file headers
 *
 * PHP version 5.3
 *
 * @category   PHP
 * @package    WordPress
 * @subpackage FileHeaderReader
 * @author     Ralf Albert <me@neun12.de>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       http://wordpress.com
 */

/**
 * FileHeaderReader
 * @author Ralf Albert
 * @version 1.0
 *
 * Reads the plugin header from a given file and stores the data
 */
namespace RalfAlbert\Tutorial\FileHeaderReader;

abstract class FileHeaderReader implements I_FileHeaderReader, \IteratorAggregate
{
	/**
	 * Object for data from plugin header
	 * @var Object
	 */
	public static $data = array();

	/**
	 * Instance identifier
	 * @var string
	*/
	public static $id = '';

	/**
	 * Flag to show if the pluginheaders was read
	 * @var boolean
	 */
	public static $headers_was_set = false;

	/**
	 * Returns a value
	 * @param string $name Name of the value
	 * @return mixed The value if it is set, else null
	 */
	public function __get( $name ) {

		if ( empty( $name ) )
			trigger_error( 'Error in ' . __METHOD__ . ': parameter (string) name expected', E_USER_NOTICE );

		if ( empty( self::$id ) )
			trigger_error( 'Error in ' . __METHOD__ . ': call get_instance( $id ) first to set up the id', E_USER_NOTICE );

		$id = self::$id;

		return ( isset( self::$data->$id->$name ) ) ?
			self::$data->$id->$name : null;

	}

	/**
	 * Set a value
	 * @param string $name Name of the value
	 * @param string $value The value itself
	 */
	public function __set( $name, $value = null ) {

		if ( empty( $name ) )
			trigger_error( 'Error in ' . __METHOD__ . ': parameter (string) name expected', E_USER_NOTICE );

		if ( empty( self::$id ) )
			trigger_error( 'Error in ' . __METHOD__ . ': call get_instance( $id ) first to set up the id', E_USER_NOTICE );

		$id = self::$id;

		if ( ! is_object( self::$data ) )
			self::$data = new \stdClass();

		if ( ! is_object( self::$data->$id ) )
			self::$data->$id = new \stdClass();

		self::$data->$id->$name = $value;

	}

	/**
	 * Implements the isset() functionality to check if a propperty is set with isset()
	 * @param string $name Name of the propperty to check
	 * @return boolean True if the popperty is set, else false
	 */
	public function __isset( $name ) {

		if ( empty( self::$id ) )
			trigger_error( 'Error in ' . __METHOD__ . ': call get_instance( $id ) first to set up the id', E_USER_NOTICE );

		$id = self::$id;

		if ( ! is_object( self::$data->$id ) )
			return false;

		return ( property_exists( self::$data->$id, $name ) ) ?
			true : false;

	}

	/**
	 * Returns the iterator
	 * @return \ArrayIterator
	 */
	public function getIterator() {

		if ( empty( self::$id ) )
			trigger_error( 'Error in ' . __METHOD__ . ': call get_instance( $id ) first to set up the id', E_USER_NOTICE );

		$id = self::$id;

		return new \ArrayIterator( self::$data->$id );

	}

}