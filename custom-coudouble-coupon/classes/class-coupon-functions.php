<?php
class WCCustomCouponAddon {
    private $couponCode = 'coudouble';
    
    public function __construct() {
        add_action('init', array($this, 'custom_addon_init'));
    }
    
    public function custom_addon_init() {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            deactivate_plugins(plugin_basename(__FILE__));
            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }
            add_action('admin_notices', array($this, 'custom_addon_woocommerce_notice'));
        }
        
        add_filter('woocommerce_coupon_get_discount_amount', array($this, 'wc_coupon_discount_added'), 10, 5);
        add_action('woocommerce_before_calculate_totals', array($this, 'change_cart_item_quantities'), 20, 1 );
    }
    
    public function custom_addon_woocommerce_notice() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php esc_html_e('The IT Particular Coupon Addon requires WooCommerce to be active.', 'custom-coudouble-coupon'); ?></p>
        </div>
        <?php
    } 
    
    // Change cart item quantity
    public function change_cart_item_quantities ( $cart ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) )
            return;
    
        $coupon_code = 'COUDOUBLE';
        if ($cart->has_discount($coupon_code)) {
            // Checking cart items
            foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {
                $product_id = $cart_item['data']->get_id();
                if(isset($cart_item['coupon_flag']) && $cart_item['coupon_flag'] == false){
                    $new_quantity = $cart_item['quantity'] + 1;
                    $cart_item['coupon_flag'] = true;
                    $cart->cart_contents[$cart_item_key] = $cart_item;
                    $cart->set_quantity( $cart_item_key, $new_quantity );
                    
                }
            }
        }else{
            foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {
                $cart_item['coupon_flag'] = false;
                $cart->cart_contents[$cart_item_key] = $cart_item;
            }
        }
    }
    
    // Coipon discount added
    public function wc_coupon_discount_added($discount, $discounting_amount, $cart_item, $single, $coupon) {
        
        if ($coupon->code === $this->couponCode) {
            $product_price = $cart_item['data']->get_price();
            $discounted_price = $product_price * 0.5;
        }

        return $discounted_price;
    }
}