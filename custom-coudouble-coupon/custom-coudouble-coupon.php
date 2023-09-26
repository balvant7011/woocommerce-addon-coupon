<?php
/**
 * Plugin Name: Woocommerce Addon: Custom COUDOUBLE Coupon
 * Description: 50% off on the extra products (COUDOUBLE) coupon apply to WooCommerce.
 * Plugin URI: https://wordpress.org/
 * Version: 1.0
 * Author: Balvant Katariya
 * Author URI: https://wordpress.org/
 * Domain Path: /languages
**/
if (!defined('ABSPATH')) {
    die('You are not allowed to call this page directly.');
}

// Include the files 
include_once("classes/class-coupon-functions.php");

// Instantiation of the class
new WCCustomCouponAddon();

