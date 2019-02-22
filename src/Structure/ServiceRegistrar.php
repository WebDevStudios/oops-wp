<?php
/**
 * The ServiceRegistrar class can be extended to define an object that provides some kind of "service" to WordPress.
 *
 * Example: a developer wants to initialize a service within the plugin that is responsible for registering custom post
 * types and taxonomies, and maybe another to register some custom WP REST API endpoints. They create a class that
 * extends this ServiceRegistrar class
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure
 * @since   1.0.0
 */

namespace WebDevStudios\OopsWP\Structure;

use WebDevStudios\OopsWP\Utility\FilePathDependent;
use WebDevStudios\OopsWP\Utility\Runnable;

/**
 * Class ServiceRegistrar
 *
 * @since 1.0.0
 */
abstract class ServiceRegistrar implements Runnable {
	use FilePathDependent;

	/**
	 * Array of fully-qualified namespaces of services to instantiate.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected $services = [];

	/**
	 * Run the initialization process.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->register_services();
	}

	/**
	 * Register this object's services.
	 *
	 * @TODO  Update this method to make registration fail if a service class doesn't extend our Service abstract.
	 * @since 1.0.0
	 */
	protected function register_services() {
		foreach ( $this->services as $service_class ) {
			/* @var $service \WebDevStudios\OopsWP\Structure\Service Class instance of a Service. */
			$service = new $service_class();
			$this->set_file_path_on_service( $service );
			$service->run();
		}
	}

	/**
	 * Pass the relative root path to services that are dependent upon it.
	 *
	 * @param Service $service
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 * @return void
	 */
	private function set_file_path_on_service( Service $service ) {
		if ( ! in_array( FilePathDependent::class, class_uses( $service ) ) ) {
			return;
		}

		/** @var $service FilePathDependent */
		$service->set_file_path( $this->file_path );
	}
}
