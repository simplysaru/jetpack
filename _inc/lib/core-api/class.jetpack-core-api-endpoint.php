<?php
/**
 * This is the base class for every Core API endpoint Jetpack uses.
 *
 */
abstract class Jetpack_Core_API_Endpoint {

	abstract public function process();
}