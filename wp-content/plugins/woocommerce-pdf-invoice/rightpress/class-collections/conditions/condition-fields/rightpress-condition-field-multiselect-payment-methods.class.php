<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RightPress_Condition_Field_Multiselect')) {
    require_once('rightpress-condition-field-multiselect.class.php');
}

/**
 * Condition Field: Multiselect - Payment Methods
 *
 * @class RightPress_Condition_Field_Multiselect_Payment_Methods
 * @package RightPress
 * @author RightPress
 */
if (!class_exists('RightPress_Condition_Field_Multiselect_Payment_Methods')) {

abstract class RightPress_Condition_Field_Multiselect_Payment_Methods extends RightPress_Condition_Field_Multiselect
{

    protected $key = 'payment_methods';

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
     * Load multiselect options
     *
     * @access public
     * @param array $ids
     * @param string $query
     * @return array
     */
    public function load_multiselect_options($ids = array(), $query = '')
    {

        return RightPress_Conditions::get_all_payment_methods($ids, $query);
    }

    /**
     * Get placeholder
     *
     * @access public
     * @return string
     */
    public function get_placeholder()
    {

        return __('Select payment methods', 'rightpress');
    }





}
}
