<?php

/**
 * Alter default login, registration, password_reset login and logout url
 */
class Modify_Redirect_Default_Links {

	/** @type  object instance */
	private static $instance;

	/** @type  array plugin settings data */
	private $db_settings_data;


	/** Class constructor */
	public function __construct() {

		// initialize plugin settings data and save to its property
		$this->db_settings_data = get_option( 'pp_settings_data' );

		// if the default password have been change i.e not empty add the filter and action
		if ( ! empty( $this->db_settings_data['set_lost_password_url'] ) ) {
			add_action( 'init', array( $this, 'redirect_password_reset_page' ) );
			add_filter( 'lostpassword_url', array( $this, 'lost_password_url_func' ), 99 );
		}

		// if the default login have been change i.e not empty add the filter and action
		if ( ! empty( $this->db_settings_data['set_login_url'] ) ) {
			add_action( 'init', array( $this, 'redirect_login_page' ) );
			add_filter( 'login_url', array( $this, 'set_login_url_func' ), 99, 2 );
		}


		// if the default registration have been change i.e not empty add the filter and action
		if ( ! empty( $this->db_settings_data['set_registration_url'] ) ) {
			add_action( 'init', array( $this, 'redirect_reg_page' ) );
			add_filter( 'register_url', array( $this, 'register_url_func' ), 99 );
		}

		// if the default logout have been change i.e not empty add the filter
		if ( ! empty( $this->db_settings_data['set_log_out_url'] ) ) {
			add_filter( 'logout_url', array( $this, 'logout_url_func' ), 99, 2 );
		}

		// redirect default logout page to blog homepage
		add_action( 'init', array( $this, 'redirect_logout_page' ) );

	}


	/**
	 * Modify the lost password url returned by wp_lostpassword_url() function.
	 *
	 * @return string|void
	 */
	public function lost_password_url_func() {
		if ( isset( $this->db_settings_data['set_lost_password_url'] ) ) {

			$page_id = absint( $this->db_settings_data['set_lost_password_url'] );

			return get_permalink( $page_id );
		}
	}

	/** Force redirection of default registration to the page with custom registration. */
	public function redirect_password_reset_page() {
		if ( isset( $this->db_settings_data['set_lost_password_url'] ) ) {

			$password_reset_url = get_permalink( absint( $this->db_settings_data['set_lost_password_url'] ) );

			$page_viewed = basename( esc_url( $_SERVER['REQUEST_URI'] ) );

			if ( $page_viewed == "wp-login.php?action=lostpassword" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
				wp_redirect( $password_reset_url );
				exit;
			}
		}
	}


	/**
	 * Modify the login url returned by wp_login_url()
	 *
	 * @return string page with login shortcode
	 */
	public function set_login_url_func() {
		if ( isset( $this->db_settings_data['set_login_url'] ) ) {
			$login_url = get_permalink( $this->db_settings_data['set_login_url'] );

			return $login_url;
		}
	}


	/** Force redirect default login to page with login shortcode */
	function redirect_login_page() {

		if ( isset( $this->db_settings_data['set_login_url'] ) ) {
			$login_url = get_permalink( absint( $this->db_settings_data['set_login_url'] ) );

			$page_viewed = basename( esc_url( $_SERVER['REQUEST_URI'] ) );

			if ( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
				wp_redirect( $login_url );
				exit;
			}
		}
	}


	/**
	 * Modify the url returned by wp_registration_url().
	 *
	 * @return string page url with registration shortcode.
	 */
	function register_url_func() {
		if ( isset( $this->db_settings_data['set_registration_url'] ) ) {
			$reg_url = get_permalink( absint( $this->db_settings_data['set_registration_url'] ) );

			return $reg_url;
		}
	}


	/** force redirection of default registration to custom one */
	function redirect_reg_page() {
		if ( isset( $this->db_settings_data['set_registration_url'] ) ) {

			$reg_url = get_permalink( absint( $this->db_settings_data['set_registration_url'] ) );

			$page_viewed = basename( esc_url( $_SERVER['REQUEST_URI'] ) );

			if ( $page_viewed == "wp-login.php?action=register" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
				wp_redirect( $reg_url );
				exit;
			}
		}
	}


	/**
	 * Add query string (url) to logout url which is url to redirect to after logout
	 *
	 * @param $logout_url string filter default login url to be modified
	 * @param $redirect string where to redirect to after logout
	 *
	 * @return string
	 */
	public function logout_url_func( $logout_url, $redirect ) {
		if ( isset( $this->db_settings_data['set_log_out_url'] ) ) {
			$db_logout_url = get_permalink( absint( $this->db_settings_data['set_log_out_url'] ) );

			if ( empty( $db_logout_url ) || $db_logout_url == 'current_view_page' ) {

				// make redirect currently viewed page
				$set_redirect = esc_url( get_permalink() );
			}
			else {
				$set_redirect = $db_logout_url;
			}

			$set_redirect = apply_filters('pp_logout_redirect', $set_redirect);

			return add_query_arg( 'redirect_to', $set_redirect, $logout_url );
		}
	}


	/** Redirect the default logout page (/wp-login.php?loggedout=true) to blog homepage */
	public function redirect_logout_page() {

		$page_viewed = basename( esc_url( $_SERVER['REQUEST_URI'] ) );

		if ( $page_viewed == "wp-login.php?loggedout=true" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			wp_redirect( home_url() );
			exit;
		}
	}


	/** Singleton poop */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

Modify_Redirect_Default_Links::get_instance();