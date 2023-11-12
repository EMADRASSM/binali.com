<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RightPress_Condition_Cart_Item_Quantities')) {
    require_once('rightpress-condition-cart-item-quantities.class.php');
}

/**
 * Condition: Cart Item Quantities - Products
 *
 * @class RightPress_Condition_Cart_Item_Quantities_Products
 * @package RightPress
 * @author RightPress
 */
if (!class_exists('RightPress_Condition_Cart_Item_Quantities_Products')) {

abstract class RightPress_Condition_Cart_Item_Quantities_Products extends RightPress_Condition_Cart_Item_Quantities
{

    protected $key          = 'products';
    protected $method       = 'numeric';
    protected $fields       = array(
        'before'    => array('products'),
        'after'     => array('number'),
    );
    protected $main_field   = 'number';
    protected $position     = 10;

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
     * Get label
     *
     * @access public
     * @return string
     */
    public function get_label()
    {

        return __('Cart item quantity - Products', 'rightpress');
    }





}
}
