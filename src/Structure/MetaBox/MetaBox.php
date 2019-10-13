<?php
/**
 * Abstract class for meta box registration.
 *
 * @see     https://developer.wordpress.org/reference/functions/add_meta_box/
 *
 * @author  Tom McFarlin <tom.mcfarlin@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\MetaBox
 * @since   2019-05-01
 */

namespace WebDevStudios\OopsWP\Structure\MetaBox;

use WP_Screen;
use UnexpectedValueException;

/**
 * Class MetaBox
 *
 * @author  Tom McFarlin <tom.mcfarlin@webdevstudios.com>
 * @since   2019-05-01
 * @package WebDevStudios\OopsWP\Structure\MetaBox
 */
abstract class MetaBox implements MetaBoxInterface {
	/**
	 * The ID attribute used to identify this meta box.
	 *
	 * @since 2019-05-01
	 * @var   string
	 */
	protected $id;

	/**
	 * The title displayed at the top of the meta box.
	 *
	 * @since 2019-05-01
	 * @var   string
	 */
	protected $title;

	/**
	 * The types of post in which this meta box should be displayed.
	 *
	 * @since 2019-05-01
	 * @var   string|array|WP_Screen Optional.
	 */
	protected $screen;

	/**
	 * The context within the screen where the boxes should display.
	 *
	 * Post edit screen contexts include 'normal', 'side', and 'advanced'.
	 * Comments screen contexts include 'normal' and 'side'.
	 * Menus meta boxes all use the 'side' context.
	 *
	 * @since 2019-05-01
	 * @var   string Optional.
	 */
	protected $context = 'side';

	/**
	 * The priority within the context where the boxes should show.
	 *
	 * Available values are 'high', 'low', and 'default'.
	 *
	 * @since 2019-05-01
	 * @var   string Optional.
	 */
	protected $priority = 'default';

	/**
	 * Data that should be set as the $args property of the meta box array
	 * (which is the second parameter passed to your callback).
	 *
	 * @since 2019-05-01
	 * @var   array Optional.
	 */
	protected $callback_args;

	/**
	 * Register the metabox with WordPress.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @since  2019-05-01
	 * @throws UnexpectedValueException If the meta box requirements are invalid.
	 * @return void
	 */
	public function register() {
		$this->set_dynamic_properties();
		$this->check_requirements();
		$this->register_meta_box();
	}

	/**
	 * Register our defined metabox with WordPress.
	 *
	 * Note: this method has private visibility because it provides the exact contract for registering a metabox
	 * provided by WordPress and should not be overrideable by extending classes.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-10-13
	 * @return void
	 */
	private function register_meta_box() {
		add_meta_box(
			$this->id,
			$this->title,
			[ $this, 'render' ],
			$this->screen,
			$this->context,
			$this->priority,
			$this->callback_args
		);
	}

	/**
	 * Provides a protected interface for developers to customize dynamic properties before metabox initialization.
	 *
	 * These properties might include $screen, certain values within the $callback_args, location of the metabox
	 * in given scenarios, etc. Because we shouldn't be performing operations on an object within the __construct
	 * method, this method gives developers an opportunity to declare property values before the metabox is registered.
	 *
	 * The method returns void: the result of this process should be, at minimum, a populated value for each of the
	 * required properties of the metabox: $id, $title, and $screen.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-10-13
	 * @return void
	 */
	protected function set_dynamic_properties() : void {
		// Logic optionally implemented by concrete classes.
	}

	/**
	 * Verifies the meta box has the requirements for proper registration with WordPress.
	 *
	 * This method is a guard against attempts to register a metabox that is improperly defined. Its only responsibility
	 * is to throw an Exception if any are found.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @since  2019-05-01
	 * @throws UnexpectedValueException If meta box registration requirements are missing.
	 * @return void
	 */
	private function check_requirements() : void {
		if ( ! is_string( $this->id ) ) {
			throw new UnexpectedValueException(
				'$id property of registered MetaBox must be of type string. ' . gettype( $this->id ) . ' found.'
			);
		}

		if ( ! is_string( $this->title ) ) {
			throw new UnexpectedValueException(
				'$title property of registered MetaBox must be of type string. ' . gettype( $this->title ) . ' found.';
			)
		}

		if ( ! in_array( gettype( $this->screen ), [ 'string', 'array' ], true ) && ! $this->screen instanceof WP_Screen ) {
			throw new UnexpectedValueException( 'The MetaBox $screen property must be one of: string, array, WP_Screen' );
		}

		if ( ! in_array( $this->context, [ 'normal', 'side', 'advanced' ], true ) ) {
			throw new UnexpectedValueException( 'The MetaBox $context property must be one of: normal, side, advanced' );
		}

		if ( ! in_array( $this->priority, [ 'high', 'low', 'default' ], true ) ) {
			throw new UnexpectedValueException( 'The MetaBox $priority property must be one of: high, low, default' );
		}

		if ( $this->callback_args && ! is_array( $this->callback_args ) ) {
			throw new UnexpectedValueException(
				'The MetaBox $callback_args property, when defined, must be of type array. Found ' . gettype( $this->callback_args )
			);
		}
	}
}
