<?php
/**
 * Defines the contract for registering a shortcode with WordPress.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since 2019-04-01
 */

namespace WebDevStudios\OopsWP\Structure\Content;

use WebDevStudios\OopsWP\Utility\Registerable;
use WebDevStudios\OopsWP\Utility\Renderable;

/**
 * Interface ShortcodeInterface
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Content
 * @since   2019-04-01
 */
interface ShortcodeInterface extends Registerable, Renderable {

}
