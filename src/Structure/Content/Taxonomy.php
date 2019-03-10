<?php
/**
 * Abstract class for taxonomy registration.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-03-01
 */

namespace WebDevStudios\OopsWP\Structure\Content;

/**
 * Class Taxonomy
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-03-01
 */
abstract class Taxonomy extends ContentType {
	/**
	 * The object types this taxonomy supports.
	 *
	 * @var array
	 * @since 2019-03-01
	 */
	protected $object_types;

	/**
	 * Register the taxonomy with WordPress.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws \Exception If taxonomy registration requirements are missing.
	 * @return void
	 * @since  2019-03-01
	 */
	public function register() {
		if ( ! $this->meets_requirements() ) {
			return;
		}

		register_taxonomy( $this->slug, (array) $this->object_types, array_merge( $this->get_default_args(), $this->get_args() ) );
	}

	/**
	 * Check whether the taxonomy meets the requirements for registration.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws \Exception If taxonomy registration requirements are missing.
	 * @since  2019-03-01
	 * @return bool
	 */
	private function meets_requirements() {
		if ( ! $this->slug ) {
			throw new \Exception( __( 'You must give your taxonomy a slug in order to register it.', 'oops-wp' ) );
		}

		if ( ! $this->object_types ) {
			throw new \Exception( __( 'You must declare which object types your taxonomy supports.', 'oops-wp' ) );
		}

		return true;
	}

	/**
	 * Taxonomy registration arguments.
	 *
	 * Extending classes can override this method to set their own arguments, overriding any defaults.
	 *
	 * @see    Taxonomy::get_default_args()
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 * @return array
	 */
	protected function get_args() : array {
		return [];
	}

	/**
	 * Default Taxonomy registration arguments.
	 *
	 * Note: This class is protected to allow for third-party developers to extend this Taxonomy class into their
	 * own Taxonomy class and set their own defaults. It's not intended for defaults to be set at the concrete
	 * Taxonomy level.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-03-01
	 * @return array
	 */
	protected function get_default_args() : array {
		return [
			'labels' => $this->get_labels(),
		];
	}
}
