<?php
/**
 * Abstract class for a custom post type.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use WebDevStudios\OopsWP\Exception\RequirementNotMetException;

/**
 * Class PostType
 *
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   0.1.0
 */
abstract class PostType extends ContentType {
	/**
	 * Post type slug.
	 *
	 * @var string
	 * @since 0.1.0
	 */
	protected $slug;

	/**
	 * Callback to register the post type with WordPress.
	 *
	 * @throws RequirementNotMetException If post type registration requirements are missing.
	 * @since 0.1.0
	 */
	public function register() {
		$this->check_requirements();

		register_post_type( $this->slug, array_merge( $this->get_default_args(), $this->get_args() ) );
	}

	/**
	 * Check whether the post type meets the requirements for registration. Throws exception if not.
	 *
	 * @author Evan Hildreth <evan.hildreth@webdevstudios.com>
	 * @throws RequirementNotMetException If post type registration requirements are missing.
	 * @since  2020-02-28
	 */
	private function check_requirements() {
		if ( ! $this->slug ) {
			throw new RequirementNotMetException( __( 'You must give your post type a slug in order to register it.', 'oops-wp' ) );
		}
	}

	/**
	 * Define customizations to the post type.
	 *
	 * At a minimum, the extending class should return an empty array.
	 *
	 * @deprecated
	 * @see get_args
	 *
	 * @return array
	 * @since 0.1.0
	 */
	protected function get_registration_arguments(): array {
		return [];
	}

	/**
	 * Get the arguments for this post type.
	 *
	 * Extending classes can override this method to pass in their own customizations specific to that post type.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 * @return array
	 */
	protected function get_args() : array {
		return $this->get_registration_arguments();
	}

	/**
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 * @return array
	 */
	protected function get_default_args() : array {
		return [
			'labels'   => $this->get_labels(),
			'public'   => true,
			'supports' => [ 'title', 'editor' ],
		];
	}
}
