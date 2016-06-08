<?php

/**
 * A collection of helper functions used in the SSO module.
 *
 * @since 4.1
 */
class Jetpack_SSO_Helpers {
	/**
	 * Determine if the login form should be hidden or not
	 *
	 * @return bool
	 **/
	static function should_hide_login_form() {
		/**
		 * Remove the default log in form, only leave the WordPress.com log in button.
		 *
		 * @module sso
		 *
		 * @since 3.1.0
		 *
		 * @param bool get_option( 'jetpack_sso_remove_login_form', false ) Should the default log in form be removed. Default to false.
		 */
		return (bool) apply_filters( 'jetpack_remove_login_form', get_option( 'jetpack_sso_remove_login_form', false ) );
	}

	/**
	 * Returns a boolean value for whether logging in by matching the WordPress.com user email to a
	 * Jetpack site user's email is allowed.
	 *
	 * @return bool
	 */
	static function match_by_email() {
		$match_by_email = ( 1 == get_option( 'jetpack_sso_match_by_email', true ) ) ? true: false;
		$match_by_email = defined( 'WPCC_MATCH_BY_EMAIL' ) ? WPCC_MATCH_BY_EMAIL : $match_by_email;

		/**
		 * Link the local account to an account on WordPress.com using the same email address.
		 *
		 * @module sso
		 *
		 * @since 2.6.0
		 *
		 * @param bool $match_by_email Should we link the local account to an account on WordPress.com using the same email address. Default to false.
		 */
		return (bool) apply_filters( 'jetpack_sso_match_by_email', $match_by_email );
	}

	/**
	 * Returns a boolean for whether users are allowed to register on the Jetpack site with SSO,
	 * even though the site disallows normal registrations.
	 *
	 * @return bool
	 */
	static function new_user_override() {
		$new_user_override = defined( 'WPCC_NEW_USER_OVERRIDE' ) ? WPCC_NEW_USER_OVERRIDE : false;

		/**
		 * Allow users to register on your site with a WordPress.com account, even though you disallow normal registrations.
		 *
		 * @module sso
		 *
		 * @since 2.6.0
		 *
		 * @param bool $new_user_override Allow users to register on your site with a WordPress.com account. Default to false.
		 */
		return (bool) apply_filters( 'jetpack_sso_new_user_override', $new_user_override );
	}

	/**
	 * Returns a boolean value for whether two-step authentication is required for SSO.
	 *
	 * @since 4.1
	 *
	 * @return bool
	 */
	static function is_two_step_required() {
		/**
		 * Is it required to have 2-step authentication enabled on WordPress.com to use SSO?
		 *
		 * @module sso
		 *
		 * @since 2.8.0
		 *
		 * @param bool get_option( 'jetpack_sso_require_two_step' ) Does SSO require 2-step authentication?
		 */
		return (bool) apply_filters( 'jetpack_sso_require_two_step', get_option( 'jetpack_sso_require_two_step', false ) );
	}

	/**
	 * Returns a boolean for whether a user that is attempting to log in will be automatically
	 * redirected to WordPress.com to begin the SSO flow.
	 *
	 * @return bool
	 */
	static function bypass_login_forward_wpcom() {
		/**
		 * Redirect the site's log in form to WordPress.com's log in form.
		 *
		 * @module sso
		 *
		 * @since 3.1.0
		 *
		 * @param bool false Should the site's log in form be automatically forwarded to WordPress.com's log in form.
		 */
		return (bool) apply_filters( 'jetpack_sso_bypass_login_forward_wpcom', false );
	}
}
