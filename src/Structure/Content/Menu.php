<?php
/**
 * Abstract class for a custom menu.
 *
 * @author  Chrispian Burks <chrispian.burks@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 */

namespace WebDevStudios\OopsWP\Structure\Content;

/**
 * Class Menu
 *
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-05-01
 */
abstract class Menu implements MenuInterface {
	/**
	 * Menu Location.
	 *
	 * @var string
	 * @since 2019-05-01
	 */
	protected $location;

	/**
	 * Menu Description.
	 *
	 * @var string
	 * @since 2019-05-01
	 */
	protected $description;

	/**
	 * Callback to register the menu with WordPress.
	 *
	 * @author Chrispian H. Burks <chrispian.burks@webdevstudios.com>
	 * @throws \Exception If validation fails throw an exception.
	 * @since 2019-05-01
	 */
	public function register() {
		$this->validate_location();
		$this->validate_description();

		register_nav_menu( $this->location, $this->description );
	}

	/**
	 * Validate the provided menu location.
	 *
	 * @author Chrispian Burks <chrispian.burks@webdevstudios.com>
	 * @throws \Exception If the menu location is not valid.
	 * @since  2019-05-01
	 */
	private function validate_location() {
		if ( empty( $this->location ) ) {
			throw new \Exception( 'You must define the $location property for your menu in ' . __CLASS__ );
		}

		if ( ! is_string( $this->location ) ) {
			throw new \Exception( 'The $location property defined in your menu class ' . __CLASS__ . ' must be a string' );
		}
	}

	/**
	 * Validate the provided menu description.
	 *
	 * @author Chrispian Burks <chrispian.burks@webdevstudios.com>
	 * @throws \Exception If the menu description is not valid.
	 * @since  2019-05-01
	 */
	private function validate_description() {
		if ( empty( $this->description ) ) {
			throw new \Exception( 'You must define the $description property for your menu in ' . __CLASS__ );
		}

		if ( ! is_string( $this->description ) ) {
			throw new \Exception( 'The $description property defined in your menu class ' . __CLASS__ . ' must be a string' );
		}
	}
}
