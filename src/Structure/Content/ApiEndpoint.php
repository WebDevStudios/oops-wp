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
use WebDevStudios\OopsWP\Exception\RequirementNotMetException;

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
	 * Whether to override any existing matching routes. Defaults to false.
	 *
	 * @var bool
	 * @since 2020-02-28
	 */
	protected $override = false;

	/**
	 * Callback to register the route type with WordPress.
	 *
	 * @throws RequirementNotMetException If post type registration requirements are missing.
	 * @author Evan Hildreth <evan.hildreth@webdevstudios.com>
	 * @since  0.3.0
	 */
	public function register() {
		if ( $this->slug && ! $this->route ) {
			$this->route = $this->slug;
		}

		$this->check_requirements();

		$args = array_merge( $this->get_default_args(), $this->get_args() );

		register_rest_route( $this->namespace, $this->route, $args, $this->override );
	}

	/**
	 * Check whether the endpoint meets the requirements for registration. Throws exception if not.
	 *
	 * @author Evan Hildreth <evan.hildreth@webdevstudios.com>
	 * @throws RequirementNotMetException If post type registration requirements are missing.
	 * @since  2020-02-28
	 */
	private function check_requirements() {
		if ( ! $this->namespace ) {
			throw new RequirementNotMetException( __( 'You must give your endpoint a namespace in order to register it.', 'oops-wp' ) );
		}

		if ( ! $this->route ) {
			throw new RequirementNotMetException( __( 'You must give your endpoint a route in order to register it.', 'oops-wp' ) );
		}
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
			'methods'  => \WP_REST_Server::READABLE,
			'callback' => [ $this, 'run' ],
		];
	}
}
