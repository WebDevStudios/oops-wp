<?php
/**
 * Abstract class for a custom post type.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 */

namespace WebDevStudios\OopsWP\Structure\Content;

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
	 * @TODO  Add exception if slug is null. Extending classes should be defining their own.
	 * @since 0.1.0
	 */
	public function register() {
		register_post_type( $this->slug, array_merge( $this->get_default_args(), $this->get_args() ) );
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
		return $this->get_args();
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
		return [];
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
