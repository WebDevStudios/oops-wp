<?php
/**
 * Define a contract for an object that can be rendered.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Utility
 * @since 2019-04-01
 */

namespace WebDevStudios\OopsWP\Utility;

/**
 * Interface Renderable
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Utility
 * @since   2019-04-01
 */
interface Renderable {
	/**
	 * Render a value from the object.
	 *
	 * @since  2019-04-01
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	public function render();
}
