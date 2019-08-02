<?php
/**
 * Defines a contract for registering new editor blocks.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */

namespace WebDevStudios\OopsWP\Structure\Editor;

use WebDevStudios\OopsWP\Utility\FilePathDependent;
use \Exception;

/**
 * Class EditorBlock
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */
abstract class EditorBlock implements EditorBlockInterface {
	use FilePathDependent;

	/**
	 * The full package name of the block.
	 *
	 * Examples: webdevstudios/custom-wysiwyg, webdevstudios-dynamic-block
	 *
	 * @var string
	 * @since 2019-08-02
	 */
	protected $name;

	/**
	 * Register the block with WordPress.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws Exception If the block $name property is invalid.
	 * @since  2019-01-04
	 */
	public function register() {
		$this->validate_name();

		$this->register_script();
		$this->register_style();
		$this->register_type();
	}

	/**
	 * Validate the name property of the block.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws Exception If the block name is invalid.
	 * @since  2019-08-02
	 */
	private function validate_name() {
		if ( ! is_string( $this->name ) ) {
			throw new Exception( get_called_class() . ' must define a string value for $name.' );
		}

		$name_parts = explode( '/', $this->name );

		if ( 2 !== count( $name_parts ) ) {
			throw new Exception( get_called_class() . ' $name property is not properly namespaced.' );
		}
	}

	/**
	 * Register the JavaScript file that controls this EditorBlock.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws Exception If the JavaScript file cannot be found.
	 * @since  2019-08-02
	 * @return void
	 */
	protected function register_script() {
		wp_register_script(
			"{$this->name}-js",
			$this->get_asset_url( 'block.js' ),
			array_merge( $this->get_default_block_scripts(), $this->get_additional_block_scripts() )
		);
	}

	/**
	 *
	 * @return array
	 * @since  2019-08-02
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	protected function get_additional_block_scripts() : array {
		return [];
	}

	/**
	 * Get the URL to an editor block asset.
	 *
	 * This method checks for the full path to the block assets and checks whether the provided asset
	 * can be read at the given path. If it is,
	 *
	 * @param string $asset The asset for which to retrieve the URL.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-02-17
	 * @return string
	 * @throws \Exception If the class does not exist or the asset is not readable.
	 */
	public function get_asset_url( string $asset ) {
		$full_assets_dir = $this->get_assets_path();
		$asset_path      = $full_assets_dir . $asset;

		if ( ! is_readable( $asset_path ) ) {
			throw new \Exception( "Could not find requested asset at {$asset_path}." );
		}

		return trailingslashit( get_site_url() ) . str_replace( ABSPATH, '', $full_assets_dir ) . $asset;
	}

	/**
	 * Get the short class name of this file.
	 *
	 * This class name is used to construct file paths to block assets.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-08-02
	 * @return string
	 */
	private function get_short_class_name() {
		$block_class = explode( '\\', get_called_class() );

		return array_pop( $block_class );
	}

	/**
	 * Get the root file path to this block's assets.
	 *
	 * @throws Exception If the file path value is not set.
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-08-02
	 * @return string
	 */
	protected function get_assets_path(): string {
		if ( ! $this->file_path ) {
			throw new Exception( 'File path not set on ' . get_called_class() );
		}

		return trailingslashit( $this->file_path . 'assets/blocks/' . $this->get_short_class_name() );
	}

	/**
	 * Get the default script dependencies for a registered block.
	 *
	 * By default, these script dependencies will be loaded with every concrete EditorBlock.
	 * This method is set to protected to allow for override of the defaults by extending classes. For
	 * those use cases, it is recommended to create an abstract class for your own implementation, then
	 * have your concrete classes extend that new abstract.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-08-02
	 * @return array
	 */
	protected function get_default_block_scripts() {
		return [
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		];
	}

	/**
	 * Register the editor and front-end styles for rendering the block.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-05
	 */
	abstract public function register_style();

	/**
	 * Register the type information for the block.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 */
	abstract public function register_type();
}
