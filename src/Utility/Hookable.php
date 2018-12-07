<?php
/**
 * Interface for objects that need to register hooks with WordPress.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Utility
 * @since   1.0.0
 */

namespace WebDevStudios\OopsWP\Utility;

/**
 * Interface Hookable
 *
 * @package WebDevStudios\OopsWP\Utility
 * @since   1.0.0
 */
interface Hookable {
	/**
	 * Register actions and filters with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register_hooks();
}
