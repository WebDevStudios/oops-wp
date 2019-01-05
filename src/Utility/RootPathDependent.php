<?php
/**
 * Trait for classes that need to locate assets relative to a root path.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Utility
 * @since 2019-01-04
 */

namespace WebDevStudios\OopsWP\Utility;

/**
 * Trait RootPathDependent
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Utility
 * @since   2019-01-04
 */
trait RootPathDependent {
	/**
	 * @var
	 * @since 2019-01-04
	 */
	protected $root_path;

	/**
	 * Set the relative root path for an object.
	 *
	 * @param string $path The root file path.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 */
	public function set_root_path( string $path ) {
		$this->root_path = $path;
	}

	/**
	 * Get the root file path.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 * @return string
	 */
	public function get_root_path() : string {
		return $this->root_path;
	}
}
