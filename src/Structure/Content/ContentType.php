<?php
/**
 * Define a structure for a generic type of content.
 *
 * This class will be extended by other OOPS-WP content types, such as PostType and Taxonomy,
 * in order to help define the interface for creating new concrete instances of those entities.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-03-01
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use WebDevStudios\OopsWP\Utility\Registerable;

/**
 * Class ContentType
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-03-01
 */
abstract class ContentType implements Registerable {
	/**
	 * Slug for the content.
	 *
	 * @var string
	 * @since 2019-03-01
	 */
	protected $slug;

	/**
	 * Get the arguments for the content type.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 */
	abstract protected function get_args() : array;

	/**
	 * Get the default arguments for the content type.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 */
	abstract protected function get_default_args() : array;

	/**
	 * Get the labels for the content type.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 */
	abstract protected function get_labels() : array;
}
