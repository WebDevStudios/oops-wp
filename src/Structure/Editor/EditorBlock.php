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

		register_block_type( "{$this->name}", array_merge( $this->get_default_args(), $this->get_args() ) );
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
		$full_assets_dir = $this->get_assets_path( $asset );
		$asset_path      = $full_assets_dir . $asset;

		if ( ! is_readable( $asset_path ) ) {
			throw new \Exception( "Could not find requested asset at {$asset_path}." );
		}

		return trailingslashit( get_site_url() ) . str_replace( ABSPATH, '', $full_assets_dir ) . $asset;
	}

	/**
	 * Get the root file path to this block's assets.
	 *
	 * @param string $asset The asset to look up.
	 * @throws Exception If the file path value is not set or if the asset cannot be found.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-08-02
	 * @return string
	 */
	protected function get_assets_path( string $asset ): string {
		if ( ! $this->file_path ) {
			throw new Exception( 'File path not set on ' . get_called_class() );
		}

		$paths = $this->locate_valid_file_paths( $asset );

		if ( empty( $paths ) ) {
			throw new \Exception( "Could not find {$asset} at any expected file path." );
		}

		return $paths[0];
	}

	/**
	 * Get the directory paths where block assets are stored for this given block.
	 *
	 * Note: this is completely customizable by an extending class.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-08-02
	 * @return array
	 */
	protected function get_valid_block_asset_directory_paths() : array {
		return [
			trailingslashit( $this->file_path . 'assets/blocks/' . $this->get_short_class_name() ),
			trailingslashit( $this->file_path . 'blocks/' . $this->get_short_class_name() . '/assets' ),
		];
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
	 * Get the default arguments for block type registration.
	 *
	 * @return array
	 * @since  2019-08-02
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	protected function get_default_args() : array {
		return [
			'editor_script' => "{$this->name}-js",
			'editor_style'  => "{$this->name}-editor-css",
		];
	}

	/**
	 * Get additional arguments for block type registration.
	 *
	 * @since  2019-08-02
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @return array
	 */
	protected function get_args() : array {
		return [];
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
			'wp-element',
		];
	}

	/**
	 * Get additional script dependencies for the registered block.
	 *
	 * Anything that's not included in the defaults above can be added by the extending classes. This
	 * might include scripts like wp-components, wp-i18n, and wp-editor, among others.
	 *
	 * @return array
	 * @since  2019-08-02
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	protected function get_additional_block_scripts() : array {
		return [];
	}

	/**
	 * Register the JavaScript file that controls this EditorBlock.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws Exception If the JavaScript file cannot be found.
	 * @since  2019-08-02
	 */
	protected function register_script() {
		wp_register_script(
			"{$this->name}-js",
			$this->get_asset_url( 'block.js' ),
			array_merge( $this->get_default_block_scripts(), $this->get_additional_block_scripts() )
		);
	}

	/**
	 * Get additional style dependencies for the registered block.
	 *
	 * Anything that's not included in the defaults can be added by the extending classes.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-08-02
	 */
	protected function get_additional_block_styles() {
		return [];
	}

	/**
	 * Register the editor and front-end styles for rendering the block.
	 *
	 * @throws Exception If the style asset(s) cannot be found.
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-05
	 */
	protected function register_style() {
		wp_register_style(
			"{$this->name}-editor-css",
			$this->get_asset_url( 'editor.css' ),
			array_merge( [ 'wp-edit-block' ], $this->get_additional_block_styles() )
		);
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
	 * Locates the file paths that are valid for this block.
	 *
	 * @param string $asset The asset to locate.
	 *
	 * @return array
	 * @since  2019-08-02
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	private function locate_valid_file_paths( string $asset ) {
		return array_values(
			array_filter(
				$this->get_valid_block_asset_directory_paths(),
				function ( $path ) use ( $asset ) {
					return is_readable( $path . $asset );
				}
			)
		);
	}
}
