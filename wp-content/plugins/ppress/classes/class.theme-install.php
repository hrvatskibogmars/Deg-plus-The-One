<?php

/**
 * ProfilePress theme installer class.
 *
 * @package ProfilePress theme installer.
 */
class PP_Theme_Installer_Class {

	private $tmp_folder;

	/**
	 * @var string file name of the theme zip file
	 * @access private
	 */
	public $theme_file_name;

	/** @var string The structure of the theme being processed be it login, registration etc. */
	private $theme_structure;

	/** @var string CSS stylesheet of the theme being processed */
	private $theme_css;

	/** @var string The message displayed when a builder action is successfully done. */
	private $theme_success_message;

	/** @var string The name or title of the theme */
	public $theme_name;

	/** @var string Login theme folder */
	private $login_theme_folder;

	/** @var string registration theme folder */
	private $registration_theme_folder;

	/** @var string password-reset theme folder */
	private $password_reset_theme_folder;

	/** @var  string edit-user-profile theme folder */
	private $edit_profile_theme_folder;

	/** @var string front-end-profile theme folder */
	private $front_end_profile_theme_folder;

	/** @var string front-end-profile theme folder */
	private $melange_theme_folder;

	private $melange_reg_success;
	private $melange_reset_success;
	private $melange_edit_profile_success;

	private $password_reset_handler_structure;

	/**
	 *  Class initializer
	 *
	 * @param string $theme_file Index into the $_FILES array of the upload
	 *
	 * @return bool|WP_Error
	 */
	public function initialize( $theme_file ) {
		// if upload was done or a success ($_FILES['key']['name'] would be set), set the filename property.
		if ( isset( $theme_file['name'] ) ) {
			$this->theme_file_name = self::get_file_name_without_extension( $theme_file['name'] );
		} else {
			return new WP_Error( 'no_file', __( 'No theme file has been received.', 'profilepress' ) );
		}

		// filename check
		if ( isset( $theme_file['name'] ) && preg_match( '/[^a-z0-9-]+/', $this->theme_file_name ) === 1 ) {
			return new WP_Error( 'invalid_name', __( 'Invalid file name, Please try again.', 'profilepress' ) );
		}

		// define theme folders
		$this->tmp_folder                     = CLASSES . '/' . 'tmp_themes';
		$this->login_theme_folder             = TEMPLATES_FOLDER . '/login';
		$this->registration_theme_folder      = TEMPLATES_FOLDER . '/registration';
		$this->password_reset_theme_folder    = TEMPLATES_FOLDER . '/password-reset';
		$this->edit_profile_theme_folder      = TEMPLATES_FOLDER . '/edit-user-profile';
		$this->front_end_profile_theme_folder = TEMPLATES_FOLDER . '/front-end-profile';
		$this->melange_theme_folder           = TEMPLATES_FOLDER . '/melange';

		// unzip the theme file
		$unzip_theme_zip_file = $this->unzip_file( $theme_file['tmp_name'], $this->tmp_folder );
		if ( is_wp_error( $unzip_theme_zip_file ) ) {
			return $unzip_theme_zip_file;
		}

		// scan temporary(aka tmp) storage folder and take action
		$scan = $this->scan_process_tmp_folder( $this->tmp_folder, $this->theme_file_name );

		// delete the content of the tmp working folder after installation process
		self::delete_dir( $this->tmp_folder );

		if ( is_wp_error( $scan ) ) {
			self::delete_dir( $this->tmp_folder );

			return $scan;
		}

		return true;


	}

	/**
	 * Unzip the theme zip file to the temporary working "tmp_themes" folder
	 *
	 * @param string $file Theme file name
	 * @param string $location extraction location
	 *
	 * @return mixed
	 */
	public function unzip_file( $file, $location ) {
		WP_Filesystem();
		if ( ! is_dir( $location ) ) {
			mkdir( $location, 0755 );
		}

		return unzip_file( $file, $location );
	}


	/**
	 * Scan the temporary working folder and install the each individual themes.
	 *
	 * @param string $folder temporary working folder
	 * @param $theme_zip_name
	 *
	 * @return bool|WP_Error
	 */
	public function scan_process_tmp_folder( $folder, $theme_zip_name ) {
		$dir_files = scandir( $folder );

		foreach ( $dir_files as $file ) {
			if ( $file == '.' || $file == '..' ) {
				continue;
			}

			// if the working folder contain a builder sub-folder eg, process it.
			if ( $file == 'login' ) {
				$result = $this->process_theme_installation( 'login', $folder, $theme_zip_name );
			}
			if ( $file == 'registration' ) {
				$result = $this->process_theme_installation( 'registration', $folder, $theme_zip_name );
			}
			if ( $file == 'password-reset' ) {
				$result = $this->process_theme_installation( 'password-reset', $folder, $theme_zip_name );
			}
			if ( $file == 'edit-user-profile' ) {
				$result = $this->process_theme_installation( 'edit-user-profile', $folder, $theme_zip_name );
			}
			if ( $file == 'front-end-profile' ) {
				$result = $this->process_theme_installation( 'front-end-profile', $folder, $theme_zip_name );
			}
			if ( $file == 'melange' ) {
				$result = $this->process_theme_installation( 'melange', $folder, $theme_zip_name );
			}
		}

		if ( isset( $result ) && is_wp_error( $result ) ) {
			return $result;
		}
	}


	/**
	 * Process the theme installation.
	 *
	 * copy the css, structure, assets and success_message of the theme eing installed.
	 *
	 * @param $theme_type
	 * @param $tmp_folder
	 * @param $theme_zip_name
	 *
	 * @return bool|WP_Error
	 */
	public function process_theme_installation( $theme_type, $tmp_folder, $theme_zip_name ) {

		$copy_assets = $this->copy_theme_assets( $theme_type, $tmp_folder, $theme_zip_name );
		if ( is_wp_error( $copy_assets ) ) {
			return $copy_assets;
		}

		$process_name = $this->process_theme_name( $theme_type, $tmp_folder );
		if ( is_wp_error( $process_name ) ) {
			return $process_name;
		}

		$process_css = $this->process_theme_css( $theme_type, $tmp_folder );
		if ( is_wp_error( $process_css ) ) {
			return $process_css;
		}
		$process_structure = $this->process_theme_structure( $theme_type, $tmp_folder );
		if ( is_wp_error( $process_structure ) ) {
			return $process_structure;
		}

		if ( $theme_type == 'registration'
		     || $theme_type == 'password-reset'
		     || $theme_type == 'edit-user-profile'
		) {
			$process_success_message = $this->process_success_message( $theme_type, $tmp_folder );
			if ( is_wp_error( $process_success_message ) ) {
				return $process_success_message;
			}
		}

		if ( $theme_type == 'melange' ) {
			$process_melange_success_msgs = $this->process_melange_success_messages( $theme_type, $tmp_folder );
			if ( is_wp_error( $process_melange_success_msgs ) ) {
				return $process_melange_success_msgs;
			}
		}

		$insert_theme_db = $this->insert_theme_to_db( $theme_type );
		if ( is_wp_error( $insert_theme_db ) ) {
			return $insert_theme_db;
		}
	}


	/**
	 * Copy the to-be-installed-theme assets to the themes assets folder.
	 *
	 * @param $theme_type string theme being process for installation
	 * @param $folder string temporary working folder
	 * @param $theme_zip_name string theme zip file name without extension(.zip)
	 *
	 * @return bool|WP_Error
	 */
	public function copy_theme_assets( $theme_type, $folder, $theme_zip_name ) {

		$dir_files = scandir( "$folder/$theme_type" );

		/*
		if ( ! in_array( 'assets', $dir_files ) ) {
			return new WP_Error( 'assets_folder_missing', '<strong>Error:</strong>' . __( 'Folder for assets not found, Please try again.', 'profilepress' ) );
		}
		*/

		if ( $theme_type == 'login' ) {
			$theme_copy_folder = $this->login_theme_folder;
		}
		if ( $theme_type == 'registration' ) {
			$theme_copy_folder = $this->registration_theme_folder;
		}
		if ( $theme_type == 'password-reset' ) {
			$theme_copy_folder = $this->password_reset_theme_folder;
		}
		if ( $theme_type == 'edit-user-profile' ) {
			$theme_copy_folder = $this->edit_profile_theme_folder;
		}
		if ( $theme_type == 'front-end-profile' ) {
			$theme_copy_folder = $this->front_end_profile_theme_folder;
		}
		if ( $theme_type == 'melange' ) {
			$theme_copy_folder = $this->melange_theme_folder;
		}
		foreach ( $dir_files as $content ) {
			if ( $content == '.' || $content == '..' ) {
				continue;
			}
			if ( $content == 'assets' ) {
				$copy = self::copy_content( "{$this->tmp_folder}/$theme_type/assets", "$theme_copy_folder/$theme_zip_name/assets" );

				// if copy fail, throw exception
				if ( ( $copy !== true ) ) {
					return new WP_Error( 'assets_copy_failed', '<strong>Error:</strong>' . __( "Failed to copy assets of $theme_type theme.", 'profilepress' ) );
				}
			}
		}

		return true;
	}


	/**
	 * Retrieve and save the each theme CSS to the "theme_css" property.
	 *
	 * @param $theme_type
	 * @param $tmp_folder
	 *
	 * @return bool|WP_Error
	 */
	public function process_theme_css( $theme_type, $tmp_folder ) {
		$dir_content = scandir( "$tmp_folder/$theme_type" );

		if ( ! in_array( 'stylesheet.css', $dir_content ) ) {
			return new WP_Error( 'stylesheet_missing', __( "<strong>Error:</strong> stylesheet.css file not found in $theme_type theme, Please try again.", 'profilepress' ) );
		}

		// theme assets url
		$theme_assets_folder_url = TEMPLATES_URL . "/$theme_type/{$this->theme_file_name}/assets";
		foreach ( $dir_content as $file ) {
			if ( $file == 'stylesheet.css' ) {
				$theme_css       = file_get_contents( "$tmp_folder/$theme_type/stylesheet.css" );
				$this->theme_css = str_replace( '{{theme_assets}}', $theme_assets_folder_url, $theme_css );
			}
		}

		return true;
	}


	/**
	 * Retrieve and save the each theme structure to the "theme_structure" property.
	 *
	 * @param $theme_type
	 * @param $tmp_folder string temporary working folder.
	 *
	 * @return bool
	 */
	public function process_theme_structure( $theme_type, $tmp_folder ) {
		$dir_content = scandir( "$tmp_folder/$theme_type" );

		if ( ! in_array( 'structure.html', $dir_content ) ) {
			return new WP_Error( 'structure_missing', __( '<strong>Error:</strong> structure.html file not found, Please try again', 'profilepress' ) );
		}

		// theme assets url
		$theme_assets_folder_url = TEMPLATES_URL . "/$theme_type/{$this->theme_file_name}/assets";
		foreach ( $dir_content as $file ) {
			if ( $file == 'structure.html' ) {
				$theme_structure       = file_get_contents( "$tmp_folder/$theme_type/structure.html" );
				$this->theme_structure = str_replace( '{{theme_assets}}', $theme_assets_folder_url, $theme_structure );
			} elseif ( $file == 'handler_structure.html' ) {
				$handler_structure                      = file_get_contents( "$tmp_folder/$theme_type/handler_structure.html" );
				$this->password_reset_handler_structure = str_replace( '{{theme_assets}}', $theme_assets_folder_url, $handler_structure );
			}
		}

		return true;
	}


	/**
	 * Retrieve and save success_message to the "theme_success_message" property.
	 *
	 * @param $theme_type
	 * @param $tmp_folder
	 *
	 * @return bool|WP_Error
	 */
	public function process_success_message( $theme_type, $tmp_folder ) {

		$dir_content = scandir( "$tmp_folder/$theme_type" );

		if ( ! in_array( 'success.txt', $dir_content ) ) {
			return new WP_Error( 'success_missing', __( '<strong>Error:</strong> success.txt file not found, Please try again', 'profilepress' ) );
		}

		foreach ( $dir_content as $file ) {
			if ( $file == 'success.txt' ) {
				$this->theme_success_message = file_get_contents( "$tmp_folder/$theme_type/success.txt" );
			}
		}

		return true;
	}


	/**
	 * Process melange success messages.
	 *
	 * @param string $theme_type
	 * @param string $tmp_folder
	 *
	 * @return bool|WP_Error
	 *
	 */
	public function process_melange_success_messages( $theme_type, $tmp_folder ) {

		$dir_content = scandir( "$tmp_folder/$theme_type" );

		if ( ! in_array( 'registration-success.txt', $dir_content ) ) {
			return new WP_Error( 'success_missing', __( '<strong>Error:</strong> registration-success.txt file not found, Please try again', 'profilepress' ) );
		}
		if ( ! in_array( 'password-reset-success.txt', $dir_content ) ) {
			return new WP_Error( 'success_missing', __( '<strong>Error:</strong> password-reset-success.txt file not found, Please try again', 'profilepress' ) );
		}
		if ( ! in_array( 'edit-profile-success.txt', $dir_content ) ) {
			return new WP_Error( 'success_missing', __( '<strong>Error:</strong> edit-profile-success.txt file not found, Please try again', 'profilepress' ) );
		}

		foreach ( $dir_content as $file ) {
			if ( $file == 'registration-success.txt' ) {
				$this->melange_reg_success = file_get_contents( "$tmp_folder/$theme_type/registration-success.txt" );
			}
			if ( $file == 'password-reset-success.txt' ) {
				$this->melange_reset_success = file_get_contents( "$tmp_folder/$theme_type/password-reset-success.txt" );
			}
			if ( $file == 'edit-profile-success.txt' ) {
				$this->melange_edit_profile_success = file_get_contents( "$tmp_folder/$theme_type/edit-profile-success.txt" );
			}
		}

		return true;
	}


	public function process_theme_name( $theme_type, $tmp_folder ) {

		$dir_content = scandir( "$tmp_folder/$theme_type" );

		if ( ! in_array( 'name.txt', $dir_content ) ) {
			return new WP_Error( 'name_missing', __( '<strong>Error:</strong> name.txt file not found, Please try again', 'profilepress' ) );
		}

		foreach ( $dir_content as $file ) {
			if ( $file == 'name.txt' ) {
				$this->theme_name = file_get_contents( "$tmp_folder/$theme_type/name.txt" );
			}
		}

		return true;
	}

	/**
	 * Insert the theme structure, CSS and success_message to the Database
	 *
	 * @param $theme_type
	 *
	 * @return bool|WP_Error
	 */
	public function insert_theme_to_db( $theme_type ) {
		$title           = $this->theme_name;
		$structure       = $this->theme_structure;
		$css             = $this->theme_css;
		$date            = date( 'Y-m-d' );
		$success_message = isset( $this->theme_success_message ) ? $this->theme_success_message : null;

		// melange success messages
		$reg_success          = $this->melange_reg_success;
		$reset_success        = $this->melange_reset_success;
		$edit_profile_success = $this->melange_edit_profile_success;

		$handler_structure = $this->password_reset_handler_structure;

		switch ( $theme_type ) {
			case 'login':
				$insert = PROFILEPRESS_sql::sql_insert_login_builder( $title, $structure, $css, $date );
				break;
			case 'registration':
				$insert = PROFILEPRESS_sql::sql_insert_registration_builder( $title, $structure, $css, $success_message, $date );
				break;
			case 'password-reset':
				$handler_structure = $this->password_reset_handler_structure;

				if ( empty( $handler_structure ) ) {
					$handler_structure = <<<FORM
<div class="pp-reset-password-form">
	<h3>Enter your new password below.</h3>
	<label for="password1">New password<span class="req">*</span></label>
	[enter-password id="password1" required autocomplete="off"]

	<label for="password2">Re-enter new password<span class="req">*</span></label>
	[re-enter-password id="password2" required autocomplete="off"]

	[password-reset-submit class="pp-reset-button pp-reset-button-block" value="Save"]
</div>
FORM;
				}
				$insert = PROFILEPRESS_sql::sql_insert_password_reset_builder( $title, $structure, $handler_structure, $css, $success_message, $date );
				break;
			case 'edit-user-profile':
				$insert = PROFILEPRESS_sql::sql_insert_edit_profile_builder( $title, $structure, $css, $success_message, $date );
				break;
			case 'front-end-profile':
				$insert = PROFILEPRESS_sql::sql_insert_user_profile_builder( $title, $structure, $css, $date );
				break;
			case 'melange':
				$insert = PROFILEPRESS_sql::sql_insert_melange_builder( $title, $structure, $css, $reg_success, $edit_profile_success, $reset_success, $date );
				break;
		}

		if ( isset( $insert ) && ! $insert ) {
			return new WP_Error( 'install_failed', __( '<strong>Error:</strong> Theme installation failed. Please try again.', 'profilepress' ) );
		}

		return true;

	}

	/**
	 * Return the name of a file.
	 *
	 * @param $file string Filename with its extension eg hello.zip
	 *
	 * @return string name of file
	 */
	public static function get_file_name_without_extension( $file ) {

		$info = pathinfo( $file );

		// +1 because of the dot(.) that precede zip or any file extension eg .zip
		$ext_len = (int) strlen( $info['extension'] ) + 1;

		return substr( $file, 0, - $ext_len );
	}


	/**
	 * function for copying content of a folder.
	 *
	 * @param string $source path to the file or folder to be copied
	 * @param string $dest path to the destination to copy to.
	 * @param int $permissions file permission
	 *
	 * @return bool
	 */
	public static function copy_content( $source, $dest, $permissions = 0755 ) {
		// Check for symlinks
		if ( is_link( $source ) ) {
			return symlink( readlink( $source ), $dest );
		}

		// Simple copy for a file
		if ( is_file( $source ) ) {
			return copy( $source, $dest );
		}

		// Make destination directory
		if ( ! is_dir( $dest ) ) {
			mkdir( $dest, $permissions, true );
		}

		// create index.php file in theme assets folder
		if ( ! file_exists( TEMPLATES_FOLDER . '/index.php' ) ) {
			pp_create_index_file( TEMPLATES_FOLDER );
		}

		// Loop through the folder
		$dir = dir( $source );
		while ( false !== $entry = $dir->read() ) {
			// Skip pointers
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}

			// Deep copy directories
			self::copy_content( "$source/$entry", "$dest/$entry", $permissions );
		}

		// Clean up
		$dir->close();

		return true;
	}


	/**
	 * Delete content in a folder and finally the folder itself.
	 *
	 * @param string $dirPath
	 *
	 * @return bool
	 */
	public static function delete_dir( $dirPath ) {
		if ( ! is_dir( $dirPath ) ) {
			return new WP_Error( 'delete_failed', 'Error deleting temporary working folder' );
		}
		if ( substr( $dirPath, strlen( $dirPath ) - 1, 1 ) != '/' ) {
			$dirPath .= '/';
		}
		$files = glob( $dirPath . '*', GLOB_MARK );
		foreach ( $files as $file ) {
			if ( is_dir( $file ) ) {
				self::delete_dir( $file );
			} else {
				unlink( $file );
			}
		}

		return rmdir( $dirPath );
	}
}