<?php
/**
 * Abstract class for a custom menu.
 *
 * @author  Chrispian Burks <chrispian.burks@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use UnexpectedValueException;

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
	 * @throws UnexpectedValueException If validation fails throw an exception.
	 * @since 2019-05-01
	 */
	public function register() {
		$this->check_requirements();
		$this->register_menu();
	}

	/**
	 * Validate the provided menu location.
	 *
	 * @author Chrispian Burks <chrispian.burks@webdevstudios.com>
	 * @throws UnexpectedValueException If the menu location is not valid.
	 * @since  2019-05-01
	 */
	private function validate_location() {
		if ( empty( $this->location ) ) {
			throw new UnexpectedValueException(
				'You must define the $location property for your menu in ' . __CLASS__
			);
		}

		if ( ! is_string( $this->location ) ) {
			throw new UnexpectedValueException(
				'The $location property defined in your menu class ' . __CLASS__ . ' must be a string'
			);
		}
	}

	/**
	 * Validate the provided menu description.
	 *
	 * @author Chrispian Burks <chrispian.burks@webdevstudios.com>
	 * @throws UnexpectedValueException If the menu description is not valid.
	 * @since  2019-05-01
	 */
	private function validate_description() {
		if ( empty( $this->description ) ) {
			throw new UnexpectedValueException(
				'You must define the $description property for your menu in ' . __CLASS__
			);
		}

		if ( ! is_string( $this->description ) ) {
			throw new UnexpectedValueException(
				'The $description property defined in your menu class ' . __CLASS__ . ' must be a string'
			);
		}
	}

	/**
	 * Verifies the menu has the requirements for proper registration with WordPress.
	 *
	 * This method is a guard against attempts to register a menu that is improperly defined. Its only responsibility
	 * is to throw an Exception if any are found.
	 *
	 * @author Chrispian H. Burks <chrispian.burks@webdevstudios.com>
	 * @since 2019-11-01
	 * @throws UnexpectedValueException If menu box registration requirements are missing.
	 * @return void
	 */
	private function check_requirements() : void {
		$this->validate_location();
		$this->validate_description();
	}

	/**
	 * Register our menu with WordPress
	 *
	 * @author Chrispian H. Burks <chrispian.burks@webvdevstudios.com>
	 * @since  2019-11-01
	 * @return void
	 */
	private function register_menu() {

		register_nav_menu(
			$this->location,
			$this->description
		);

	}

}

