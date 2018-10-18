<?php
/**
 * The ServiceRegistrar class can be extended to define an object that provides some kind of "service" to WordPress.
 *
 * Example: a developer wants to initialize a service within the plugin that is responsible for registering custom post
 * types and taxonomies, and maybe another to register some custom WP REST API endpoints. They create a class that
 * extends this ServiceRegistrar class
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WDS\OopsWP\Structure
 */

namespace WDS\OopsWP\Structure;

use WDS\OopsWP\Utility\Runnable;

/**
 * Class ServiceRegistrar
 */
abstract class ServiceRegistrar implements Runnable {
	/**
	 * Array of fully-qualified namespaces of services to instantiate.
	 *
	 * @var array
	 */
	protected $services = [];

	/**
	 * Run the initialization process.
	 */
	public function run() {
		$this->register_services();
	}

	/**
	 * Register this object's services.
	 *
	 * @TODO Update this method to make registration fail if a service class doesn't extend our Service abstract.
	 */
	private function register_services() {
		foreach ( $this->services as $service_class ) {
			/* @var $service \WDS\OopsWP\Structure\Service Class instance of a Service. */
			$service = new $service_class();
			$service->run();
		}
	}
}
