<?php
/**
 * Abstract class for a custom REST API Endpoint type.
 *
 * @author  Evan Hildreth <evan.hildreth@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   0.3.0
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use WebDevStudios\OopsWP\Utility\Runnable;

/**
 * Class ApiEndpoint
 *
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   0.3.0
 */
abstract class ApiEndpoint extends ContentType implements Runnable {
	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 * @since 0.3.0
	 */
	protected $namespace;

	/**
	 * Endpoint route.
	 *
	 * @var string
	 * @since 0.3.0
	 */
	protected $route;

	/**
	 * Callback to register the route type with WordPress.
	 *
	 * @TODO  Add exception if namespace or route are null. Extending classes should be defining their own.
	 * @author Evan Hildreth <evan.hildreth@webdevstudios.com>
	 * @since  0.3.0
	 */
	public function register() {
		register_rest_route( $this->namespace, $this->route, array_merge( $this->get_default_args(), $this->get_args() ) );
	}

	/**
	 * Get the arguments for this post type.
	 *
	 * Extending classes can override this method to pass in their own customizations specific to the endpoint.
	 *
	 * @author Evan Hildreth <evan.hildreth@webdevstudios.com>
	 * @since  0.3.0
	 * @return array
	 */
	protected function get_args() : array {
		return [];
	}

	/**
	 * Get default arguments so subclasses don't have to define them
	 *
	 * @author Evan Hildreth <evan.hildreth@webdevstudios.com>
	 * @since  0.3.0
	 * @return array
	 */
	protected function get_default_args() : array {
		return [
			'methods'  => [ 'GET' ],
			'callback' => [ $this, 'run' ],
		];
	}

	protected function get_labels() : array {
		return [];
	}
}
