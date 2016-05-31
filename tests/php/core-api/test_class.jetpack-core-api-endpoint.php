<?php

class WP_Test_Jetpack_Core_Api_Endpoint extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		require_once dirname( __FILE__ ) . '/../../../_inc/lib/core-api/class.jetpack-core-api-endpoint.php';
	}

	/**
	 * @author zinigor
	 * @covers Jetpack_Core_API_Endpoint
	 * @requires PHP 5.2
	 */
	public function test_Jetpack_Core_API_Endpoint_class_structure() {

		$reflection = new ReflectionClass( 'Jetpack_Core_API_Endpoint' );

		$this->assertTrue( $reflection->isAbstract() );

		$processMethod = $reflection->getMethod( 'process' );
		$this->assertTrue( $processMethod->isPublic() );
		$this->assertTrue( $processMethod->isAbstract() );
	}

}
