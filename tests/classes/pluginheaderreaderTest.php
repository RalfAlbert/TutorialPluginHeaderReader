<?php
namespace RalfAlbert\Tutorial\PluginHeaderReaderTest;

use RalfAlbert\Tutorial\PluginHeaderReader\PluginHeaderReader;

require_once dirname( dirname( dirname( __FILE__ ) ) ) . '/classes/interface_pluginheaderreader.php';
require_once dirname( dirname( dirname( __FILE__ ) ) ) . '/classes/pluginheaderreader.php';

class PluginHeaderReaderTest extends \WP_UnitTestCase
{

	public $object;

	/**
	 * ID for headers
	 * @var string
	 */
	public $id;

	public function setUp() {}

	public function tearDown() {}

	/**
	 * @covers PluginHeaderReader::init()
	 */
	public function testInit() {

		$filename = dirname( dirname( dirname( __FILE__ ) ) ) . '/index.php';
		$this->assertTrue( file_exists( $filename ) );

		PluginHeaderReader::init( $filename, 'test' );

		$object = PluginHeaderReader::get_instance( 'test' );

		$this->assertObjectHasAttribute( 'data', $object );

	}

}
