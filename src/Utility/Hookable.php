<?php
/**
 * Interface for objects that need to register hooks with WordPress.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WDS\OopsWP\Utility
 */

namespace WDS\OopsWP\Utility;

/**
 * Interface Hookable
 *
 * @package WDS\OopsWP\Utility
 */
interface Hookable {
	/**
	 * Register actions and filters with WordPress.
	 */
	public function register_hooks();
}
