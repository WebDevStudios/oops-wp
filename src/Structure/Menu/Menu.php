<?php
/**
 * Abstract class for a custom menu.
 *
 * @author  Chrispian Burks <chrispian.burks@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Menu
 */

namespace WebDevStudios\OopsWP\Structure\Menu;

use UnexpectedValueException;

/**
 * Class Menu
 *
 * @package WebDevStudios\OopsWP\Structure\Menu
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
	 * Verifies the menu has the requirements for proper registration with WordPress.
	 *
	 * This method is a guard against attempts to register a menu that is improperly defined. Its only responsibility
	 * is to throw an Exception if any are found.
	 *
	 * @author Chrispian H. Burks <chrispian.burks@webdevstudios.com>
	 * @since  2019-11-01
	 * @throws UnexpectedValueException If menu box registration requirements are missing.
	 * @return void
	 */
	private function check_requirements(): void {
		foreach ( [ 'location', 'description' ] as $property ) {
			if ( ! is_string( $this->{$property} ) ) {
				throw new UnexpectedValueException( '${$property} must be of type string in ' . __CLASS__ );
			}
		}
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

