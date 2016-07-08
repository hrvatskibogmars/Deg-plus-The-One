<?php

class Registration_Builder_Shortcode_Parser {

	/**
	 * define all registration builder sub shortcode.
	 */
	public static function initialize() {
		add_shortcode( 'reg-username', array( __CLASS__, 'reg_username' ) );
		add_shortcode( 'reg-password', array( __CLASS__, 'reg_password' ) );
		add_shortcode( 'reg-email', array( __CLASS__, 'reg_email' ) );
		add_shortcode( 'reg-website', array( __CLASS__, 'reg_website' ) );
		add_shortcode( 'reg-nickname', array( __CLASS__, 'reg_nickname' ) );
		add_shortcode( 'reg-display-name', array( __CLASS__, 'reg_display_name' ) );
		add_shortcode( 'reg-first-name', array( __CLASS__, 'reg_first_name' ) );
		add_shortcode( 'reg-last-name', array( __CLASS__, 'reg_last_name' ) );
		add_shortcode( 'reg-bio', array( __CLASS__, 'reg_bio' ) );
		add_shortcode( 'reg-submit', array( __CLASS__, 'reg_submit' ) );

	}


	/**
	 * Normalize unamed shortcode
	 *
	 * @param array $atts
	 *
	 * @return mixed
	 */
	public static function normalize_attributes( $atts ) {
		foreach ( $atts as $key => $value ) {
			if ( is_int( $key ) ) {
				$atts[ $value ] = true;
				unset( $atts[ $key ] );
			}
		}

		return $atts;
	}


	/**
	 * parse the [login-username] shortode
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public static function reg_username( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_username'] ) ? 'value="' . esc_attr( $_POST['reg_username'] ) . '"' : 'value="' . $atts['value'] . '"';
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : 'required="required"';

		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name='reg_username' type='text' $title $value $class $id $placeholder $required />";

		return $html;
	}

	/**
	 * @param array $atts
	 *
	 * parse the [login-password] shortcode
	 *
	 * @return string
	 */
	public static function reg_password( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_password'] ) ? 'value="' . esc_attr( $_POST['reg_password'] ) . '"' : 'value="' . $atts['value'] . '"';
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : 'required="required"';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name=\"reg_password\" type='password' $title $value $class $id $placeholder $required />";

		return $html;


	}


	/**
	 * Callback function for email
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_email( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_email'] ) ? 'value="' . esc_attr( $_POST['reg_email'] ) . '"' : 'value="' . $atts['value'] . '"';
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : 'required="required"';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name='reg_email' type='email' $title $value $class $id $placeholder $required />";

		return $html;

	}


	/**
	 * Callback function for website
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_website( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_website'] ) ? esc_attr( $_POST['reg_website'] ) : $atts['value'];
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : '';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name='reg_website' value='" . $value . "' type='text' $title $class $id $placeholder $required />";

		return $html;

	}


	/**
	 * Callback function for nickname
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_nickname( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_nickname'] ) ? esc_attr( $_POST['reg_nickname'] ) : $atts['value'];
		$required = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : '';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name='reg_nickname' value='" . $value . "' type='text' $title $class $id $placeholder $required />";

		return $html;

	}

	/**
	 * Callback function for nickname
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_display_name( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_display_name'] ) ? esc_attr( $_POST['reg_display_name'] ) : $atts['value'];
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : '';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name='reg_display_name' value='" . $value . "' type='text' $title $class $id $placeholder $required />";

		return $html;

	}


	/**
	 * Callback function for first name
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_first_name( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_first_name'] ) ? esc_attr( $_POST['reg_first_name'] ) : $atts['value'];
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : '';

		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name=\"reg_first_name\" type='text' value='" . $value . "' $title $class $id $placeholder $required />";

		return $html;

	}


	/**
	 * Callback for last name
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_last_name( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_last_name'] ) ? esc_attr( $_POST['reg_last_name'] ) : $atts['value'];
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : '';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name=\"reg_last_name\" value=\"$value\" type=\"text\" $title $class $placeholder $id $required />";

		return $html;

	}


	/**
	 * Handles BIO
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_bio( $atts ) {

		$atts = self::normalize_attributes( $atts );

		$atts = shortcode_atts(
			array(
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'title'       => '',
				'required'    => '',
				'placeholder' => ''
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['reg_bio'] ) ? esc_textarea( $_POST['reg_bio'] ) : $atts['value'];
		$required    = ( ! empty( $atts['required'] ) && $atts['required'] ) ? 'required="required"' : '';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<textarea name=\"reg_bio\" $title $class $placeholder $id $required>$value</textarea>";

		return $html;

	}


	/**
	 * Callback function for submit button
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function reg_submit( $atts ) {

		$atts = shortcode_atts(
			array(
				'class' => '',
				'name'  => 'reg_submit',
				'id'    => '',
				'value' => 'Sign Up',
				'title' => '',
			),
			$atts
		);

		$name        = 'name="' . $atts['name'] . '"';
		$class       = 'class="' . $atts['class'] . '"';
		$value       = 'value="' . $atts['value'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input type='submit' $name $title $value $id $class  />";

		return $html;
	}
}

Registration_Builder_Shortcode_Parser::initialize();