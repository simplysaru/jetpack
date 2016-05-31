<?php
/**
 * This is the base class for every Core API endpoint Jetpack uses.
 *
 */
abstract class Jetpack_Core_API_XMLRPC_Consumer_Endpoint extends Jetpack_Core_API_Endpoint {

	/**
	 * An instance of the Jetpack XMLRPC client to make WordPress.com requests
	 *
	 * @private
	 * @var Jetpack_IXR_Client
	 */
	private $xmlrpc;

	/**
	 * @param Jetpack_IXR_Client $xmlrpc
	 */
	public function __construct( $xmlrpc ) {
		$this->xmlrpc = $xmlrpc;
	}

	/**
	 * Checks if the site is private and returns the result.
	 * @return Boolean $is_private
	 */
	protected function is_site_private() {
		if ( $this->xmlrpc->query( 'jetpack.isSitePubliclyAccessible' ) ) {
			return $this->xmlrpc->getResponse();
		}
		return false;
	}
}