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
use Exception;

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
	 * This is optional. Default is 'side'.
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
	 * This is optional. Available values are 'high', 'low', and 'default'.
	 *
	 * The default value is 'default.'
	 *
	 * @since 2019-05-01
	 * @var   string Optional.
	 */
	protected $priority = 'default';

	/**
	 * Data that should be set as the $args property of the meta box array
	 * (which is the second parameter passed to your callback).
	 *
	 * This is optional. The default value is an empty array.
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
	 * @throws Exception If the meta box requirements are missing.
	 * @return void
	 */
	public function register() {
		if ( ! $this->meets_requirements() ) {
			return;
		}

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
	 * Verifies the meta box has the requirements for proper registration with WordPress.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @since  2019-05-01
	 * @throws Exception If meta box registration requirements are missing.
	 * @return bool
	 */
	private function meets_requirements() {
		if ( ! $this->id ) {
			throw new Exception( __( 'You must give your meta box a slug to register it.', 'oops-wp' ) );
		}

		if ( empty( $this->screen ) ) {
			throw new Exception( __( 'You must specify at least one post type to display your meta box.', 'oops-wp' ) );
		}

		// @TODO Add Exception for missing render method.

		return true;
	}
}
