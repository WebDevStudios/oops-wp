<?php
/**
 * Abstract class for meta box registration.
 *
 * @author  Tom McFarlin <tom.mcfarlin@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-05-01
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use Exception;
use WebDevStudios\OopsWP\Utility\Registerable;

/**
 * Class MetaBox
 *
 * @author  Tom McFarlin <tom.mcfarlin@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-05-01
 */
abstract class MetaBox extends ContentType implements Registerable {

	/**
	 * The slug used to identify this meta box.
	 *
	 * @var   string
	 * @since 2019-05-01
	 */
	protected $slug;

	/**
	 * The title displayed at the top of the meta box.
	 *
	 * @var   string
	 * @since 2019-05-01
	 */
	protected $title;

	/**
	 * The types of post in which this meta box should be displayed.
	 *
	 * @var   array
	 * @since 2019-05-01
	 */
	protected $post_types;

	/**
	 * The context within the screen where the boxes should display.
	 *
	 * This is optional. The default value is 'side.'
	 *
	 * @var   string
	 * @since 2019-05-01
	 */
	protected $context;

	/**
	 * The priority within the context where the boxes should show ('high', 'low', 'default').
	 *
	 * This is optional. The default value is 'default.'
	 *
	 * @var   string
	 * @since 2019-05-01
	 */
	protected $priority;

	/**
	 * Data that should be set as the $args property of the meta box array
	 * (which is the second parameter passed to your callback).
	 *
	 * This is optional. The default value is an empty array.
	 *
	 * @var   array
	 * @since 2019-05-01
	 */
	protected $callback_args;

	/**
	 * Initializes the meta box with the specified arguments.
	 *
	 * @param string $slug                    Slug used to identify this meta box.
	 * @param string $title                   Title displayed at the top of the meta box.
	 * @param array  $post_types              Types of posts in which this meta box should be displayed.
	 * @param string $context       Optional. Where the boxes should display.
	 * @param string $priority      Optional. Where the boxes should show ('high', 'low', 'default').
	 * @param array  $callback_args Optional. Data that should be set as the $args property of the meta box array.
	 */
	public function __construct(
		string $slug,
		string $title,
		array $post_types,
		string $context = 'side',
		string $priority = 'default',
		array $callback_args = []
	) {
		$this->slug          = $slug;
		$this->title         = $title;
		$this->post_types    = $post_types;
		$this->context       = $context;
		$this->priority      = $priority;
		$this->callback_args = $callback_args;
	}

	/**
	 * Register the metabox with WordPress.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @throws Exception If the meta box requirements are missing.
	 * @return void
	 * @since  2019-05-01
	 */
	public function register() {
		if ( ! $this->meets_requirements() ) {
			return;
		}

		call_user_func_array(
			'add_meta_box',
			$this->get_default_args()
		);
	}

	/**
	 * Verifies the meta box has the requirements for proper registration with WordPress.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @throws Exception If meta box registration requirements are missing.
	 * @since  2019-05-01
	 * @return bool
	 */
	private function meets_requirements() {
		if ( ! $this->slug ) {
			throw new Exception( __( 'You must give your meta box a slug to register it.', 'oops-wp' ) );
		}

		if ( empty( $this->post_types ) ) {
			throw new Exception( __( 'You must specify at least one post type to display your meta box.', 'oops-wp' ) );
		}

		return true;
	}

	/**
	 * Get the arguments for the meta box.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @return array
	 * @since  2019-05-01
	 */
	protected function get_args() : array {
		return $this->get_default_args();
	}

	/**
	 * Generates the array of default arguments as defined by the constructor's arguments.
	 * Invokes the subclasses 'render' function for displaying the contents of the meta box.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @return array argumnets used to populate the properties of the meta box.
	 * @since  2019-05-01
	 */
	protected function get_default_args(): array {
		return [
			'id'            => $this->slug,
			'title'         => $this->title,
			'callback'      => [ $this, 'render' ],
			'screen'        => $this->post_types,
			'context'       => $this->context,
			'priority'      => $this->priority,
			'callback_args' => $this->callback_args,
		];
	}

	/**
	 * Note: There are no labels for this content type. Provided by abstract
	 * class implementation.
	 *
	 * @author Tom McFarlin <tom.mcfarlin@webdevstudios.com>
	 * @return array
	 * @since  2019-05-01
	 */
	protected function get_labels() : array {
		return [];
	}
}
