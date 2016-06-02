<?php
require_once dirname( __FILE__ ) . '/../lib/class-wp-test-rest-controller-testcase.php';
require_once dirname( __FILE__ ) . '/../lib/class-wp-test-spy-rest-server.php';

use function Patchwork\redefine;
use function Patchwork\restore;

class WP_Test_Jetpack_Core_Api_Module_Activate_Endpoint extends WP_Test_REST_Controller_Testcase {

	public static $xmlrpc_response = true;

	public static $current_user_can = true;

	public $redefines = array();

	public function setUp() {
		require_once dirname( __FILE__ ) . '/../../../_inc/lib/class.core-rest-api-endpoints.php';

		parent::setUp();

		Jetpack::load_xml_rpc_client();

		$this->redefines[] = redefine( 'Jetpack_IXR_Client::query', function() {
			return true; // noop
		} );

		$this->redefines[] = redefine( 'Jetpack_IXR_Client::getResponse', function() {
			return WP_Test_Jetpack_Core_Api_Module_Activate_Endpoint::$xmlrpc_response;
		} );

		$this->redefines[] = redefine( 'current_user_can', function( $permission ) {
			if ( 'jetpack_manage_modules' === $permission ) {
				return WP_Test_Jetpack_Core_Api_Module_Activate_Endpoint::$current_user_can;
			}
			return false;
		} );

		$this->redefines[] = redefine( 'Jetpack::state', function( $slug ) { } );

		$this->redefines[] = redefine( 'Jetpack::is_development_mode', function() {
			return true;
		} );
	}

	public function tearDown() {
		foreach ( $this->redefines as $redefine ) {
			restore( $redefine );
		}
		parent::tearDown();
	}

	/**
	 * @author zinigor
	 * @covers Jetpack_Core_Module_Activate_Endpoint
	 * @requires PHP 5.2
	 */
	public function test_Jetpack_Core_API_Module_Activate_Endpoint_class_structure() {

		$reflection = new ReflectionClass( 'Jetpack_Core_API_Module_Activate_Endpoint' );

		$this->assertFalse( $reflection->isAbstract() );
		$this->assertTrue( $reflection->isSubclassOf( 'Jetpack_Core_API_XMLRPC_Consumer_Endpoint' ) );
		$this->assertTrue( $reflection->implementsInterface( 'Jetpack_Core_API_Writable' ) );
	}

	/**
	 * @author zinigor
	 * @covers Jetpack_Core_API_Module_Activate_Endpoint
	 * @requires PHP 5.2
	 */
	public function test_register_routes() {
		$routes = $this->server->get_routes();
		$this->assertArrayHasKey( '/jetpack/v4/module/(?P<slug>[a-z\-]+)/activate', $routes );

		$route = $routes['/jetpack/v4/module/(?P<slug>[a-z\-]+)/activate'][0];
		$this->assertInstanceOf(
			'Jetpack_Core_API_Module_Activate_Endpoint',
			$route['callback'][0]
		);
		$this->assertInstanceOf(
			'Jetpack_Core_API_Module_Activate_Endpoint',
			$route['permission_callback'][0]
		);
	}

	/**
	 * @author zinigor
	 * @covers Jetpack_Core_API_Module_Activate_Endpoint
	 * @requires PHP 5.2
	 * @dataProvider permission_provider
	 */
	public function test_activate_module( $can_write, $is_public ) {
		self::$xmlrpc_response = $is_public;
		self::$current_user_can = $can_write;

		Jetpack::deactivate_module( 'carousel' );

		$request = new WP_REST_Request( 'POST', '/jetpack/v4/module/carousel/activate' );
		$response = $this->server->dispatch( $request );

		if ( $can_write ) {
			$this->assertEquals( 200, $response->status );

			$this->assertTrue( Jetpack::is_module_active( 'carousel' ) );
		} else {
			$this->assertEquals( 403, $response->status );

			$this->assertFalse( Jetpack::is_module_active( 'carousel' ) );
		}
	}

	public function permission_provider() {
		return array(
			array( true, true ),
			array( true, false ),
			array( false, false )
		);
	}

	public function test_update_item() {}
	public function test_context_param() {}
	public function test_get_items() {}
	public function test_get_item() {}
	public function test_create_item() {}
	public function test_delete_item() {}
	public function test_prepare_item() {}
	public function test_get_item_schema() {}
}