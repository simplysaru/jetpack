<?php

class WP_Test_Jetpack_Core_Api_Writable_Interface extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		require_once dirname( __FILE__ ) . '/../../../_inc/lib/core-api/class.jetpack-core-api-writable.php';
	}

	/**
	 * @author zinigor
	 * @covers Jetpack_Core_API_Endpoint
	 * @requires PHP 5.2
	 */
	public function test_Jetpack_Core_API_Writable_interface_structure() {

		$reflection = new ReflectionClass( 'Jetpack_Core_API_Writable' );

		$this->assertTrue( $reflection->isInterface() );

		$processMethod = $reflection->getMethod( 'can_write' );
		$this->assertTrue( $processMethod->isPublic() );
		$this->assertTrue( $processMethod->isAbstract() );
	}

}
