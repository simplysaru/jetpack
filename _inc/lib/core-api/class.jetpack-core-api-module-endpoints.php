<?php
/**
 * This is the base class for every Core API endpoint Jetpack uses.
 *
 */
class Jetpack_Core_API_Module_Activate_Endpoint
	extends Jetpack_Core_API_XMLRPC_Consumer_Endpoint
	implements Jetpack_Core_API_Writable {

	public function process() {
		Jetpack::activate_module( 'carousel', false, false );
	}

	public function can_write() {
		return current_user_can( 'jetpack_manage_modules' );
	}
}