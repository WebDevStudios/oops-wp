<?php
/**
 * Interface for a controller class to initialize a process following class instantiation.
 *
 * One example might be a service object that bootstraps the registration process for a custom post type.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WDS\OopsWP\Utility
 */

namespace WDS\OopsWP\Utility;

/**
 * Interface Runnable
 *
 * @package WDS\OopsWP\Utility
 */
interface Runnable {
	/**
	 * Run the initialization process.
	 */
	public function run();
}
