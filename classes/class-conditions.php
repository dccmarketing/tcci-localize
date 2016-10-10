<?php

/**
 * Checks conditions for metaboxes.
 *
 * @since 		1.0.0
 *
 * @package 	Decks
 */

class TCCI_Localize_Conditions {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Checks if the condition is met.
	 *
	 * @param 		string 		$type 			The type of condition to check.
	 * @param 		string 		$condition 		The condition to check.
	 * @param 		object 		$post_obj 		The post object.
	 * @return 		bool 						TRUE if the condition is met, otherwise FALSE.
	 */
	public function check( $type, $condition, $post_obj ) {

		$check_type = $check_condition = $check_post_obj = '';

		if ( empty( $type ) ) {

			$check_type = new WP_Error( 'type_empty', __( 'The type for the metabox is empty.', 'tcci-localize' ) );

		}

		if ( is_wp_error( $check_type ) ) {

			wp_die( $check_type->get_error_message(), __( 'Type is empty.', 'tcci-localize' ) );

		}

		if ( empty( $condition ) ) {

			$check_condition = new WP_Error( 'condition_empty', __( 'The condition for the metabox is empty.', 'tcci-localize' ) );

		}

		if ( is_wp_error( $check_condition ) ) {

			wp_die( $check_condition->get_error_message(), __( 'Condition is empty.', 'tcci-localize' ) );

		}

		if ( empty( $post_obj ) ) {

			$check_post_obj = new WP_Error( 'post_object_empty', __( 'The post object for the metabox is empty.', 'tcci-localize' ) );

		}

		if ( is_wp_error( $check_post_obj ) ) {

			wp_die( $check_post_obj->get_error_message(), __( 'Post object is empty.', 'tcci-localize' ) );

		}

		switch( $type ) {

			case 'cap' 			: $return = current_user_can( $condition, $post_obj ); break;
			case 'page' 		: $return = $this->check_page( $condition, $post_obj ); break;
			case 'post_type'	: $return = $this->check_post_type( $condition, $post_obj ); break;
			case 'status'		: $return = $this->check_status( $condition, $post_obj ); break;
			case 'template'		: $return = $this->check_template( $condition, $post_obj ); break;
			default 			: $return = FALSE;

		} // switch

		if ( ! $return ) {

			return FALSE;

		}

		return TRUE;

	} // check()

	/**
	 * Returns whether the user has the capapbility level set in the conditions.
	 *
	 * @exits 		If $condition is empty.
	 * @exits 		If $post_obj is empty or not an object.
	 * @param 		array 		$condition 		The requested condition.
	 * @param 		obj 		$post_obj 		The post object.
	 * @return 		bool 						TRUE if the capability matches, otherwise FALSE.
	 */
	private function check_capability( $condition, $post_obj ) {

		if ( empty( $condition ) ) { return FALSE; }
		if ( empty( $post_obj ) || ! is_object( $post_obj ) ) { return FALSE; }

		return current_user_can( $condition, $post_obj->ID );

	} // check_capability()

	/**
	 * Returns TRUE if the requested page is the same as the post's name.
	 *
	 * @exits 		If $condition is empty.
	 * @exits 		If $post_obj is empty or not an object.
	 * @param 		string 		$condition 		The requested condition.
	 * @param 		obj 		$post_obj 		The post object.
	 * @return 		bool 						TRUE if the post name matches, otherwise FALSE.
	 */
	private function check_page( $condition, $post_obj ) {

		if ( empty( $condition ) ) { return FALSE; }
		if ( empty( $post_obj ) || ! is_object( $post_obj ) ) { return FALSE; }

		return $condition === $post_obj->post_name;

	} // check_page()

	/**
	 * Returns TRUE if the post type is correct.
	 *
	 * The logic for the $condition[2] value doesn't currently do anything.
	 * Its intended to allow for displaying a metabox on every post except the
	 * one listed.
	 *
	 * @exits 		If $condition is empty.
	 * @exits 		if $post_obj is empty or not an object.
	 * @param 		string 		$condition 		The requested condition.
	 * @param 		obj 		$post_obj 		The post object.
	 * @return 		bool 						TRUE if the post type is correct, otherwise FALSE.
	 */
	private function check_post_type( $condition, $post_obj ) {

		if ( empty( $condition ) ) { return FALSE; }
		if ( empty( $post_obj ) || ! is_object( $post_obj ) ) { return FALSE; }

		return $condition == $post_obj->post_type;

	} // check_post_type()

	/**
	 * Returns TRUE if the requested post status is the same as the post's status.
	 *
	 * @exits 		If $condition is empty.
	 * @exits 		If $post_obj is empty or not an object.
	 * @param 		string 		$condition 		The requested condition.
	 * @param 		obj 		$post_obj 		The post object.
	 * @return 		bool 						TRUE if the post status matches, otherwise FALSE.
	 */
	private function check_status( $condition, $post_obj ) {

		if ( empty( $condition ) ) { return FALSE; }
		if ( empty( $post_obj ) || ! is_object( $post_obj ) ) { return FALSE; }

		return $condition === $post_obj->post_status;

	} // check_status()

	/**
	 * Returns TRUE if the requested page template is same as the page's template.
	 *
	 * @exits 		If $condition is empty.
	 * @exits 		If $post_obj is empty or not an object.
	 * @param 		string 		$condition 		The requested condition.
	 * @param 		obj 		$post_obj 		The post object.
	 * @return 		bool 						TRUE if the template matches, otherwise FALSE.
	 */
	private function check_template( $condition, $post_obj ) {

		if ( empty( $condition ) ) { return FALSE; }
		if ( empty( $post_obj ) || ! is_object( $post_obj ) ) { return FALSE; }

		$page_template = get_post_meta( $post_obj->ID, '_wp_page_template', true );

		return $condition === $page_template;

	} // check_template()

} // class
