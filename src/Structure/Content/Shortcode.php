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
	 * The shortcode attributes when it is processed.
	 *
	 * @var array
	 * @since 2020-01-31
	 */
	protected $attributes;

	/**
	 * The shortcode content when it is processed.
	 *
	 * @var array
	 * @since 2020-01-31
	 */
	protected $content;

	/**
	 * Register the shortcode with WordPress.
	 *
	 * @since  2019-04-01
	 * @throws \Exception If $tag is not set by the concrete class.
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	public function register() {
		$this->validate_tag();

		add_shortcode( $this->tag, [ $this, 'process_output' ] );
	}

	/**
	 * Process the shortcode output.
	 *
	 * This method is an intermediary between the shortcode callback and the render method that engineers
	 * are required to implement as part of the shortcode contract. The main purpose of this process is to apply
	 * attributes and content to the Shortcode class and make them available at the time `render` is called.
	 *
	 * @param array  $attributes The shortcode attributes.
	 * @param string $content    The shortcode content.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2020-01-31
	 */
	public function process_output( array $attributes = [], string $content = '' ) {
		$this->attributes = $attributes;
		$this->content    = $content;

		$this->render();
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

		if ( ! is_string( $this->tag ) ) {
			throw new \Exception( 'The $tag property defined in your shortcode class ' . __CLASS__ . ' must be a string' );
		}
	}
}
