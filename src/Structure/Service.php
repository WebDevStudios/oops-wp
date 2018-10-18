<?php
/**
 * Class structure that defines a registered service to run within a plugin or theme.
 *
 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WDS\OopsWP\Structure
 */

namespace WDS\OopsWP\Structure;

use WDS\OopsWP\Utility\Hookable;
use WDS\OopsWP\Utility\Runnable;

/**
 * Class Service
 *
 * @package WDS\OopsWP\Structure
 */
abstract class Service implements Runnable, Hookable {
	/**
	 * Run the initialization process.
	 */
	public function run() {
		$this->register_hooks();
	}
}
