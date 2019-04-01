<?php
/**
 * Defines a contract for a WordPress editor block object.
 *
 * @author  Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Structure\Editor
 * @since 2019-04-01
 */

namespace WebDevStudios\OopsWP\Structure\Editor;

use WebDevStudios\OopsWP\Utility\AssetsLocator;
use WebDevStudios\OopsWP\Utility\Registerable;

interface EditorBlockInterface extends Registerable, AssetsLocator {

}
