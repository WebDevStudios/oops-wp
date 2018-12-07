<?php
/**
 * Class structure that defines a registered service to run within a plugin or theme.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure
 * @since   1.0.0
 */

namespace WebDevStudios\OopsWP\Structure;

use WebDevStudios\OopsWP\Utility\Runnable;
use WebDevStudios\OopsWP\Utility\Hookable;

/**
 * Class Service
 *
 * @package WebDevStudios\OopsWP\Structure
 * @since   1.0.0
 */
abstract class Service implements Runnable, Hookable {
	/**
	 * Run the initialization process.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->register_hooks();
	}
}
