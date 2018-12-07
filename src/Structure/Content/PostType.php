<?php
/**
 * Abstract class for a custom post type.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use WebDevStudios\OopsWP\Utility\Registerable;

/**
 * Class PostType
 *
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   1.0.0
 */
abstract class PostType implements Registerable {
	/**
	 * Post type slug.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $slug;

	/**
	 * Callback to register the post type with WordPress.
	 *
	 * @TODO  Add exception if slug is null. Extending classes should be defining their own.
	 * @since 1.0.0
	 */
	public function register() {
		register_post_type(
			$this->slug,
			wp_parse_args( $this->get_registration_arguments(), $this->get_default_registration_arguments() )
		);
	}

	/**
	 * Get the post type arguments.
	 *
	 * Defaults: Everything is set to true by default, with full post type support. Extending classes
	 * can turn off unwanted settings.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function get_default_registration_arguments() {
		return [
			'labels'   => $this->get_labels(),
			'public'   => true,
			'supports' => [ 'title', 'editor' ],
		];
	}

	/**
	 * Define customizations to the post type.
	 *
	 * At a minimum, the extending class should return an empty array.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	abstract protected function get_registration_arguments(): array;

	/**
	 * Get the post type labels.
	 *
	 * Extending classes should be responsible for adding their own post type labels for translation purposes.
	 *
	 * @see   https://codex.wordpress.org/Function_Reference/register_post_type#labels
	 * @return array
	 * @since 1.0.0
	 */
	abstract protected function get_labels(): array;
}
