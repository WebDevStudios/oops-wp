<?php
/**
 * Defines the contract for registering a shortcode with WordPress.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since 2019-04-01
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use WebDevStudios\OopsWP\Utility\Registerable;
use WebDevStudios\OopsWP\Utility\Renderable;

/**
 * Interface ShortcodeInterface
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-04-01
 */
interface ShortcodeInterface extends Registerable, Renderable {
	/**
	 * Intermediary callback for a shortcode object.
	 *
	 * Implementing classes should consider extending this method to perform any necessary validation of
	 * attributes and content from the database, before finally calling `render` from within this method.
	 *
	 * @see Shortcode::process_output() for example default implementation.
	 *
	 * @param array  $attributes The shortcode attributes.
	 * @param string $content    The shortcode content.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2020-01-31
	 */
	public function process_output( array $attributes = [], string $content = '' );
}
