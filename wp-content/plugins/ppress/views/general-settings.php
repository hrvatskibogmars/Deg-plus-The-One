<?php

/** General settings page **/
class General_settings_page {

	static $instance;
	private $db_settings_data;

	/** class constructor */
	public function __construct() {
		$this->db_settings_data = get_option( 'pp_settings_data' );
		add_action( 'admin_menu', array( $this, 'register_general_settings_page' ), 1 );

	}

	public function register_general_settings_page() {
		add_menu_page(
			__( 'ProfilePress Lite - Account Form Builder', 'profilepress' ),
			'ProfilePress',
			'manage_options',
			'pp-config',
			array(
				$this,
				'general_settings_page_function',
			),
			ASSETS_URL . '/images/dashicon.png',
			'80.0015'
		);

		add_submenu_page(
			'pp-config',
			__( 'General Settings - ProfilePress', 'profilepress' ),
			__( 'Settings', 'profilepress' ),
			'manage_options',
			'pp-config',
			array( $this, 'general_settings_page_function' )
		);
	}

	public function general_settings_page_function() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2><?php _e( 'General Settings - ProfilePress Lite', 'profilepress' ); ?></h2>
			<?php if ( isset( $_GET['settings-update'] ) && $_GET['settings-update'] ) { ?>
				<div id="message" class="updated notice is-dismissible"><p><strong><?php _e( 'Settings saved', 'profilepress' ); ?>.</strong>
					</p></div>
				<?php
			}

			$db_settings_data = $this->db_settings_data;

			$this->save_settings_data( $_POST );
			?>

			<?php require_once 'include.settings-page-tab.php'; ?>

			<div id="poststuff" class="ppview">

				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<div class="postbox">
									<div class="handlediv" title="Click to toggle"><br></div>
									<h3 class="hndle ui-sortable-handle">
										<span><?php _e( 'Global Settings', 'profilepress' ); ?></span></h3>

									<div class="inside">
										<table class="form-table">
											<tr>
												<th scope="row"><?php _e( 'Password-reset Page', 'profilepress' ); ?></th>
												<td><?php
													$lostp_args = array(
														'name'             => 'set_lost_password_url',
														'show_option_none' => 'Select...',
														'selected'         => isset( $db_settings_data['set_lost_password_url'] ) ? $db_settings_data['set_lost_password_url'] : ''
													);

													wp_dropdown_pages( $lostp_args ); ?>

													<p class="description">
														<?php echo sprintf( __( 'Select the page you wish to make WordPress default "Lost Password page". %s This should be the page that contains the %s', 'profilepress' ),
															'<br/><strong>' . __( 'Note:', 'profilepress' ) . '</strong>',
															'<a href="?page=pp-password-reset"><strong>' . __( 'password reset  shortcode', 'profilepress' ) . '</strong></a>' );
														?>
													</p>
												</td>
											</tr>

											<tr>
												<th scope="row">Login Page</th>
												<td><?php
													$login_args = array(
														'name'             => 'set_login_url',
														'show_option_none' => 'Select...',
														'selected'         => isset( $db_settings_data['set_login_url'] ) ? $db_settings_data['set_login_url'] : ''
													);

													wp_dropdown_pages( $login_args ); ?>
													<p class="description">
														<?php echo sprintf( __( 'Select the page you wish to make WordPress default Login page. %s This should be the page that contains the %s', 'profilepress' ),
															'<br/><strong>' . __( 'Note:', 'profilepress' ) . '</strong>',
															'<a href="?page=pp-login"><strong>' . __( 'login form  shortcode', 'profilepress' ) . '</strong></a>' );
														?>
													</p>
												</td>
											</tr>

											<tr>
												<th scope="row">Registration Page</th>
												<td><?php
													$registration_args = array(
														'name'             => 'set_registration_url',
														'show_option_none' => 'Select...',
														'selected'         => isset( $db_settings_data['set_registration_url'] ) ? $db_settings_data['set_registration_url'] : ''
													);

													wp_dropdown_pages( $registration_args ); ?>
													<p class="description">
														<?php echo sprintf( __( 'Select the page you wish to make WordPress default Registration page. %s This should be the page that contains the %s', 'profilepress' ),
															'<br/><strong>' . __( 'Note:', 'profilepress' ) . '</strong>',
															'<a href="?page=pp-registration"><strong>' . __( 'registration form  shortcode', 'profilepress' ) . '</strong></a>' );
														?>
													</p>
												</td>
											</tr>

											<tr id="edit_user_profile_page">
												<th scope="row">Remove Data on Uninstall?</th>
												<td>
													<label for="remove_plugin_data"><strong>Delete</strong></label>
													<input type="checkbox" id="remove_plugin_data" name="remove_plugin_data" value="yes" <?php isset( $db_settings_data['remove_plugin_data'] ) ? checked( $db_settings_data['remove_plugin_data'], 'yes' ) : ''; ?>>

													<p class="description"><?php _e( 'Check this box if you would like ProfilePress to completely remove all of its data when the plugin is deleted.', 'profilepress' ); ?></p>
												</td>
											</tr>

										</table>
										<p>
											<?php wp_nonce_field( 'general_settings_nonce' ); ?>
											<input class="button-primary" type="submit" name="general_settings_submit"
											       value="Save All Changes">
										</p>
									</div>
								</div>

								<div class="postbox">
									<div class="handlediv" title="Click to toggle"><br></div>
									<h3 class="hndle ui-sortable-handle"><span>Redirections</span></h3>

									<div class="inside">
										<table class="form-table">
											<tr>
												<th scope="row">Log out</th>
												<td><?php
													$log_out_args = array(
														'name'              => 'set_log_out_url',
														'show_option_none'  => 'Default..',
														'option_none_value' => 'current_view_page',
														'selected'          => isset( $db_settings_data['set_log_out_url'] ) ? $db_settings_data['set_log_out_url'] : ''
													);

													wp_dropdown_pages( $log_out_args ); ?>
													<p class="description">
														Select the page users will be redirected to after logout.
													</p>
												</td>
											</tr>

											<tr>
												<th scope="row">Login</th>
												<?php /** @todo add option to redirect to currently viewed page */ ?>
												<td><?php
													$set_reg_args = array(
														'name'              => 'set_login_redirect',
														'show_option_none'  => 'WordPress Dashboard',
														'option_none_value' => 'dashboard',
														'selected'          => isset( $db_settings_data['set_login_redirect'] ) ? $db_settings_data['set_login_redirect'] : ''
													);

													wp_dropdown_pages( $set_reg_args ); ?>
													<p class="description">
														Select the page users will be redirected to after login.
													</p>
												</td>
											</tr>
										</table>
										<p>
											<?php wp_nonce_field( 'general_settings_nonce' ); ?>
											<input class="button-primary" type="submit" name="general_settings_submit" value="Save All Changes">
										</p>
									</div>
								</div>
							</form>
						</div>

					</div>
					<?php include_once 'include.plugin-settings-sidebar.php'; ?>

				</div>
				<br class="clear">
			</div>
		</div>
		<style type="text/css">
			.CodeMirror {
				height: 300px !important;
				width: 570px !important;
			}
		</style>
		<script>
			function editor(id) {
				CodeMirror.fromTextArea(document.getElementById(id));
			}
			editor('pp_welcome_message_after_reg');
			editor('password_reset_message');
			editor('account_status_pending_message');
			editor('account_status_approval_message');
			editor('account_status_block_message');
			editor('account_status_unblock_message');

		</script>
		<?php
	}

	/**
	 * Save the settings page data
	 *
	 * @param $post_data
	 */
	function save_settings_data( $post_data ) {
		flush_rewrite_rules();

		if ( isset( $_POST['general_settings_submit'] ) && check_admin_referer( 'general_settings_nonce', '_wpnonce' ) ) {

			$settings_data = array();
			foreach ( $post_data as $key => $value ) {

				// do not save the nonce value to DB
				if ( $key == '_wpnonce' ) {
					continue;
				}
				// do not save the nonce referer to DB
				if ( $key == '_wp_http_referer' ) {
					continue;
				}
				// do not save the submit button value
				if ( $key == 'general_settings_submit' ) {
					continue;
				}

				$settings_data[ $key ] = stripslashes( $value );
			}

			update_option( 'pp_settings_data', $settings_data );

			// redirect with added query string after submission
			wp_redirect( esc_url_raw( add_query_arg( 'settings-update', 'true' ) ) );
			exit;
		}
	}

	static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

General_settings_page::get_instance();