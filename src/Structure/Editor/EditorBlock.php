<?php
/**
 * Defines a contract for registering new editor blocks.
 *
 * The purpose of this class is to provide a standardized model for declaring the location of editor block assets.
 * The extending class should set a value for the $name property of the block, adhering to WordPress's namespacing
 * convention for blocks (e.g., <vendor>/<block_name>). Additionally, the author of the block should create assets
 * for the JavaScript entrypoint, the editor CSS and the front-end CSS with the following names:
 * - index.js
 * - editor.css
 * - style.css
 *
 * By default, this class will look for these assets relative to the root directory of the plugin or theme, at
 * /src/blocks/${name}/, where $name is the lowercase, hyphenated variant of the block name (excluding the vendor
 * prefix). For example, if the $name property on your class is webdevstudios/my_awesome_block, your assets for this
 * block should be in /src/blocks/my-awesome-block/.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since   2019-01-04
 */

namespace WebDevStudios\OopsWP\Structure\Editor;

use UnexpectedValueException;
use WebDevStudios\OopsWP\Utility\FilePathDependent;
use \Exception;
use \ReflectionException;

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
	 * The full vendor/package namespaced name of the block.
	 *
	 * Examples: webdevstudios/custom-wysiwyg, webdevstudios-dynamic-block
	 *
	 * @var string
	 * @since 2019-08-02
	 */
	protected $name;

	/**
	 * Flag as to whether the block has front-end styles.
	 *
	 * Defaults to true. We will assume that most blocks will ship with a corresponding front-end stylesheet.
	 *
	 * @var bool
	 * @since 2019-08-02
	 */
	protected $has_frontend_styles = true;

	/**
	 * The default relative path for locating block assets.
	 *
	 * @var string
	 */
	protected $relative_path = 'src/blocks';

	/**
	 * The directory within wp-content where the block is located.
	 *
	 * @var string
	 */
	private $wpcontent_dirname;

	/**
	 * The directory name of the plugin or theme.
	 *
	 * @var string
	 */
	private $package_dirname;

	/**
	 * Register the block with WordPress.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @throws Exception If missing requirements.
	 * @since  2019-01-04
	 */
	public function register() {
		$this->check_requirements();

		$this->setup_assets_file_path();
		$this->register_script();
		$this->register_styles();
		$this->register_block();
	}

	/**
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-12-27
	 * @throws Exception If requirements are not met.
	 * @return void
	 */
	private function check_requirements() {
		$this->validate_name();
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
			throw new UnexpectedValueException( '$name property must be of type string in class ' . get_called_class() );
		}

		$name_parts = explode( '/', $this->name );

		if ( 2 !== count( $name_parts ) ) {
			throw new Exception( '$name property is not correctly namespaced in class ' . get_called_class() );
		}
	}

	/**
	 * Register the block with WordPress.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-12-27
	 * @return void
	 */
	private function register_block() {
		register_block_type( "{$this->name}", array_merge( $this->get_default_args(), $this->get_args() ) );
	}

	/**
	 * This method sets up an assets file path for an EditorBlock if one is not provided by the implementation.
	 *
	 * This path will be located from the root of a plugin or theme directory, and will be based on the
	 * name provided by the child class.
	 *
	 * e.g., /wp-content/plugins/my-plugin/src/blocks/webdevstudios-block
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-12-27
	 * @throws ReflectionException
	 * @return void
	 */
	protected function setup_assets_file_path() {
		$this->derive_path_values();

		if ( ! ( $this->wpcontent_dirname && $this->package_dirname ) ) {
			return;
		}

		$this->file_path = trailingslashit(
			implode(
				DIRECTORY_SEPARATOR,
				array_filter(
					[
						'themes' === $this->wpcontent_dirname ? '' : untrailingslashit( $this->package_dirname ),
						untrailingslashit( $this->relative_path ),
						untrailingslashit( $this->get_block_dirname() ),
					]
				)
			)
		);
	}

	/**
	 * Setter for the $wpcontent_dirname property.
	 *
	 * @param string $dirname
	 *
	 * @throws Exception If unexpected directory value.
	 */
	private function set_wpcontent_dirname( string $dirname ) {
		$wpcontent_dirs = [ 'plugins', 'themes', 'mu-plugins' ];

		if ( ! in_array( $dirname, $wpcontent_dirs, true ) ) {
			throw new Exception(
				'Expected package in one of ' . implode( ', ', $wpcontent_dirs ) . ", found {$dirname}."
			);
		}

		$this->wpcontent_dirname = $dirname;
	}

	/**
	 * Get the name of the block directory, derived from the concrete class's block name.
	 *
	 * Returns a lowercase, hyphenated string of the name of the block, excluding the vendor.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-12-27
	 * @return string
	 */
	private function get_block_dirname() {
		$name_parts = explode( DIRECTORY_SEPARATOR, $this->name );

		return strtolower( str_replace( DIRECTORY_SEPARATOR, '-', $name_parts[1] ) );
	}

	/**
	 * Get the path values of the calling class as an indexed array.
	 *
	 * Returns an indexed array which contains the path type (e.g., plugins or themes) and
	 * the path name, which is the directory name for the plugin or theme.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-12-27
	 * @throws ReflectionException Within ReflectionClass.
	 * @throws Exception If unexpected directory name in wp-content.
	 */
	private function derive_path_values() {
		$relative_path = str_replace( WP_CONTENT_DIR, '', $this->get_file_path() );
		$parts         = explode( DIRECTORY_SEPARATOR, ltrim( $relative_path, DIRECTORY_SEPARATOR ) );

		$this->set_wpcontent_dirname( $parts[0] ?? '' );
		$this->package_dirname = $parts[1] ?? '';
	}

	/**
	 * Get the file path if one is provided, or derive one if not.
	 *
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-12-27
	 * @throws ReflectionException Within ReflectionClass.
	 * @return false|string
	 */
	public function get_file_path() {
		return $this->file_path ?: ( new \ReflectionClass( get_called_class() ) )->getFileName();
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
	 * @throws Exception If the class does not exist or the asset is not readable.
	 */
	public function get_asset_url( string $asset ) {
		$asset_path = $this->get_assets_path( $asset );

		if ( ! is_readable( $asset_path ) ) {
			throw new Exception( "Could not find requested asset at {$asset_path}." );
		}

		return 'plugins' === $this->wpcontent_dirname
			? plugin_dir_url( $this->file_path . $asset ) . $asset
			: trailingslashit( get_stylesheet_directory_uri() ) . $this->file_path . $asset;
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
	protected function get_assets_path( string $asset ) : string {
		if ( 'plugins' === $this->wpcontent_dirname ) {
			return trailingslashit( \WP_PLUGIN_DIR ) . $this->file_path . $asset;
		}

		if ( 'mu-plugins' === $this->wpcontent_dirname ) {
			return trailingslashit( WPMU_PLUGIN_DIR ) . $this->file_path . $asset;
		}

		return trailingslashit( get_stylesheet_directory_uri() ) . $this->file_path;
	}

	/**
	 * Get the default arguments for block type registration.
	 *
	 * @return array
	 * @since  2019-08-02
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 */
	protected function get_default_args() : array {
		$args = [
			'editor_script' => "{$this->name}-js",
			'editor_style'  => "{$this->name}-editor",
			'style'         => "{$this->name}-style",
		];

		if ( ! $this->has_frontend_styles ) {
			unset( $args['style'] );
		}

		return $args;
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
			'wp-i18n',
		];
	}

	/**
	 * Get additional script dependencies for the registered block.
	 *
	 * Anything that's not included in the defaults above can be added by the extending classes. This
	 * might include scripts like wp-components, wp-data, and wp-editor, among others.
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
			$this->get_asset_url( 'index.js' ),
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
	 **
	 * @throws Exception If the style asset(s) cannot be found.
	 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
	 * @since  2019-01-05
	 */
	protected function register_styles() {
		$default_css = [
			'editor' => [ 'wp-edit-blocks' ],
			'style'  => [],
		];

		if ( ! $this->has_frontend_styles ) {
			unset( $default_css['style'] );
		}

		foreach ( $default_css as $handle => $dependencies ) {
			wp_register_style(
				"{$this->name}-{$handle}",
				$this->get_asset_url( "{$handle}.css" ),
				array_merge( $dependencies, $this->get_additional_block_styles() )
			);
		}
	}
}
