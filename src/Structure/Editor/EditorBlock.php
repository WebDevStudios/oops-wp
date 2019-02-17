<?php
/**
 * Defines a contract for registering new editor blocks.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */

namespace WebDevStudios\OopsWP\Structure\Editor;

use WebDevStudios\OopsWP\Utility\AssetsLocator;
use WebDevStudios\OopsWP\Utility\Registerable;
use WebDevStudios\OopsWP\Utility\FilePathDependent;

/**
 * Class EditorBlock
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */
abstract class EditorBlock implements Registerable, AssetsLocator {
	use FilePathDependent;

	/**
	 * Register the block with WordPress.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 */
	public function register() {
		$this->register_script();
		$this->register_style();
		$this->register_type();
	}

	/**
	 * Get the URL to an editor block asset.
	 *
	 * @param string $asset The asset for which to retrieve the URL.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-02-17
	 * @return string
	 * @throws \Exception If the class does not exist or the asset is not readable.
	 */
	public function get_asset_url( string $asset ) {
		if ( ! $this->file_path ) {
			$this->file_path = str_replace( ABSPATH, '', dirname( ( new \ReflectionClass( static::class ) )->getFileName(), 2 ) );
		}

		$asset_path = ABSPATH . $this->file_path . '/assets/' . $asset;

		if ( ! is_readable( $asset_path ) ) {
			throw new \Exception( "Could not find requested asset at {$asset_path}." );
		}

		return trailingslashit( get_site_url() . "/{$this->file_path}/assets" ) . $asset;
	}

	/**
	 * Register the JavaScript assets that power the block.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-04
	 */
	abstract public function register_script();

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
