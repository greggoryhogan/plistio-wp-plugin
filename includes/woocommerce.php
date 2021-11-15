<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Generate purchase key after buying product
 */ 
add_action( 'woocommerce_payment_complete', 'frgmnt_generate_api_key' );
function frgmnt_generate_api_key( $order_id ){
    $order = wc_get_order( $order_id );
    $billing_email = $order->billing_email;
    $products = $order->get_items();
    foreach($products as $product){
        $product_id = $product->get_product_id();
        $needs_license = get_field('needs_license',$product_id);
        if($needs_license == 'yes') {
            for($i = 0; $i < $product['qty']; $i++) {
                $license_key = md5($product['name'].$billing_email.$order_id.$i);
                add_post_meta($order_id,'license-key',$license_key);
                add_post_meta($order_id,'license-key-'.$license_key.'-name',$product['name']);
            }  
        }
    }
}

/*
 * Add auth keys to customer email
 */
add_action( 'woocommerce_email_order_meta', 'frgmnt_add_auth_key_order_meta', 10, 3 );
function frgmnt_add_auth_key_order_meta( $order, $sent_to_admin, $plain_text ){
    //get keys
    $order_id = $order->get_id();
    $license_keys = get_post_meta( $order_id, 'license-key' );
	// we won't display anything if we dont have any keys to add, which is wack because there should be
	if( empty( $license_keys ) )
		return;
	// html or plain text output
	if ( $plain_text === false ) {
		// you shouldn't have to worry about inline styles, WooCommerce adds them itself depending on the theme you use
		echo '<h2>License Key(s)</h2>';
        foreach($license_keys as $key) {
            $name = get_post_meta($order_id,'license-key-'.$key.'-name',true);
            echo $name.': '.$key.'<br>';
        }
        echo '<br>';
	} else {
		echo "License Key(s)\n";
        foreach($license_keys as $key) {
            $name = get_post_meta($order_id,'license-key-'.$key.'-name',true);
            echo $name.': '.$key."\n";
        }
        echo "\n";
	}
} 

/*
 * Add license keys to thank you page
 */
add_action( 'woocommerce_thankyou', 'frgmnt_thank_you_keys', 10 );
add_action( 'woocommerce_view_order', 'frgmnt_thank_you_keys', 10 );
function frgmnt_thank_you_keys($order_id) { 
    $order = wc_get_order( $order_id );
    if($order->has_status('completed')) {
        $license_keys = get_post_meta( $order_id, 'license-key' ); 
        if( empty( $license_keys ) )
            return; 
        ?>
        <section class="woocommerce-order-details">
            <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'License Keys', 'woocommerce' ); ?></h2>
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                        <th class="woocommerce-table__product-table product-key"><?php esc_html_e( 'License Key', 'woocommerce' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($license_keys as $key) {
                        $name = get_post_meta($order_id,'license-key-'.$key.'-name',true);
                        echo '<tr><td>'.$name.'</td><td>'.$key.'</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section><?php 
    }
}
?>