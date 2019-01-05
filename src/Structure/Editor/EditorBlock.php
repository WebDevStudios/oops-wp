<?php
/**
 * Defines a contract for registering new editor blocks.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */

namespace WebDevStudios\OopsWP\Structure\Editor;

use WebDevStudios\OopsWP\Utility\Registerable;
use WebDevStudios\OopsWP\Utility\FilePathDependent;

/**
 * Class EditorBlock
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */
abstract class EditorBlock implements Registerable {
	use FilePathDependent;

	/**
	 * Register the block with WordPress.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 * @return void
	 */
	public function register() {
		$this->register_script();
		$this->register_style();
		$this->register_type();
	}

	/**
	 * Register the JavaScript assets that power the block.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 */
	abstract public function register_script();

	/**
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-05
	 * @return mixed
	 */
	abstract public function register_style();

	/**
	 * Register the block type information.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 */
	abstract public function register_type();
}
