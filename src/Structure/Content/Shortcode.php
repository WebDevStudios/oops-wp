<?php
/**
 * Defines a contract for shortcode registration.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-04-01
 */

namespace WebDevStudios\OopsWP\Structure\Content;

/**
 * Class Shortcode
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-04-01
 */
abstract class Shortcode implements ShortcodeInterface {
	/**
	 * The shortcode tag.
	 *
	 * @var string
	 * @since 2019-04-01
	 */
	protected $tag = '';

	/**
	 * Register the shortcode with WordPress.
	 *
	 * @since  2019-04-01
	 * @throws \Exception If $tag is not set by the concrete class.
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	public function register() {
		$this->validate_tag();

		add_shortcode( $this->tag, [ $this, 'render' ] );
	}

	/**
	 * Validate the provided shortcode tag.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws \Exception If the shortcode tag is not valid.
	 * @since  2019-04-01
	 */
	private function validate_tag() {
		if ( empty( $this->tag ) ) {
			throw new \Exception( 'You must define the $tag property for your shortcode in ' . __CLASS__ );
		}
	}
}
