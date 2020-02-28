<?php
/**
 * Exception to indicate requirements for an object have not
 * been met.
 *
 * @author  Evan Hildreth <evan.hildreth@webdevstudios.com>
 * @package WebDevStudios\OopsWP\Exception
 */

namespace WebDevStudios\OopsWP\Exception;

/**
 * Class RequirementNotMetException
 * 
 * For use when a subclass is missing a required piece of
 * information and cannot perform its function. For example,
 * failing to provide a slug for a custom post type.
 *
 * @package WebDevStudios\OopsWP\Exception
 * @since   2020-02-28
 */
class RequirementNotMetException extends \Exception
{
    /**
		 * Construct a RequirementNotMetException.
		 *
		 * @param string     $message Required message describing the requirement
		 * @param int        $code Defaults to 0
		 * @param \Exception $previous Defaults to null
		 */
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}