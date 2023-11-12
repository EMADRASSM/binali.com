<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RightPress_Condition_Method')) {
    require_once('rightpress-condition-method.class.php');
}

/**
 * Condition Method: Field
 *
 * @class RightPress_Condition_Method_Field
 * @package RightPress
 * @author RightPress
 */
if (!class_exists('RightPress_Condition_Method_Field')) {

abstract class RightPress_Condition_Method_Field extends RightPress_Condition_Method
{

    protected $key = 'field';

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        parent::__construct();

        $this->hook();
    }

    /**
     * Get method options
     *
     * @access public
     * @return array
     */
    public function get_options()
    {

        return array(
            'is_empty'          => __('is empty', 'rightpress'),
            'is_not_empty'      => __('is not empty', 'rightpress'),
            'contains'          => __('contains', 'rightpress'),
            'does_not_contain'  => __('does not contain', 'rightpress'),
            'begins_with'       => __('begins with', 'rightpress'),
            'ends_with'         => __('ends with', 'rightpress'),
            'equals'            => __('equals', 'rightpress'),
            'does_not_equal'    => __('does not equal', 'rightpress'),
            'less_than'         => __('less than', 'rightpress'),
            'less_or_equal_to'  => __('less or equal to', 'rightpress'),
            'more_than'         => __('more than', 'rightpress'),
            'more_or_equal'     => __('more or equal to', 'rightpress'),
            'is_checked'        => __('is checked', 'rightpress'),
            'is_not_checked'    => __('is not checked', 'rightpress'),
        );
    }

    /**
     * Check against condition method
     *
     * Accepts null value which indicates that field/value does not exist (as opposed to being empty)
     *
     * Note: If "contains" option is selected and a list of values is found,
     * it will check each individual item to check if it "contains" specific text,
     * as oposed to checking if the whole list "contains" an equal entry
     *
     * @access public
     * @param string $option_key
     * @param mixed $value
     * @param mixed $condition_value
     * @return bool
     */
    public function check($option_key, $value, $condition_value)
    {

        // Check if value is set
        if ($value !== null) {

            // Proceed depending on condition method option
            switch ($option_key) {

                // Is empty
                case 'is_empty':
                    return RightPress_Help::is_empty($value);

                // Is not empty
                case 'is_not_empty':
                    return !RightPress_Help::is_empty($value);

                // Contains
                case 'contains':
                    return RightPress_Help::contains($value, $condition_value);

                // Does not contain
                case 'does_not_contain':
                    return !RightPress_Help::contains($value, $condition_value);

                // Begins with
                case 'begins_with':
                    return RightPress_Help::begins_with($value, $condition_value);

                // Ends with
                case 'ends_with':
                    return RightPress_Help::ends_with($value, $condition_value);

                // Equals
                case 'equals':
                    return RightPress_Help::equals($value, $condition_value);

                // Does note equal
                case 'does_not_equal':
                    return !RightPress_Help::equals($value, $condition_value);

                // Less than
                case 'less_than':
                    return RightPress_Help::less_than($value, $condition_value);

                // Less or equal to
                case 'less_or_equal_to':
                    return !RightPress_Help::more_than($value, $condition_value);

                // More than
                case 'more_than':
                    return RightPress_Help::more_than($value, $condition_value);

                // More or equal
                case 'more_or_equal':
                    return !RightPress_Help::less_than($value, $condition_value);

                // Is checked
                case 'is_checked':
                    return RightPress_Help::is_checked($value);

                // Is not checked
                case 'is_not_checked':
                    return !RightPress_Help::is_checked($value);

                default:
                    return false;
            }
        }

        // Value is not set - return value depends on whether condition method is positive or negative
        return in_array($option_key, array('is_empty', 'does_not_contain', 'does_not_equal', 'is_not_checked'), true);
    }





}
}
