<?php
/*
Plugin Name: WooCommerce Dropshippers
Plugin URI: http://articnet.jp/
Description: Integrates dropshippers in WooCommerce
Version: 1.9
Author: ArticNet LLC.
Author URI: http://articnet.jp/
*/


/*
 * This plugin is available for purchase at 
 * http://codecanyon.net/item/woocommerce-dropshippers/7615263
 * Because of copyright - full code is not shown 
 * i only shows what is added by me in this code 
 * **** shoaib uddin *****
 */












/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if(!class_exists('WooCommerce_Dropshippers'))
	{
		class WooCommerce_Dropshippers
		{ /** * ... some initialized code here */} // END class WooCommerce_Dropshippers
	} // END if(!class_exists('WooCommerce_Dropshippers'))

	if(class_exists('WooCommerce_Dropshippers'))
	{
		
		/** * ... some required code here */
		
		
	    // Check if plugin exists
	    if(isset($WooCommerce_Dropshippers))
	    {
			/* coding removed */
	        // Add the settings link to the plugins page
	       	/* USEFUL FUNCTIONS */
			/* WIDGET */
	        
			// Add the widget for dropshippers
	        function woocommerce_dropshipper_dashboard_right_now_function() {
	        	/* coding removed due to copyright */

			/* METABOX */
			// this meta box is used to add the dropshipper to each product 
			
			function print_dropshipper_list_metabox(){
				global $post;
				$woo_dropshipper = get_post_meta( $post->ID, 'woo_dropshipper', true );
				$dropshipperz = get_users('role=dropshipper');
				?>
				<label for="dropshippers-select"> <?php _e( "Select a Dropshipper",'woocommerce-dropshippers') ?></label>
				<select name="dropshippers-select" id="dropshippers-select" style="width:100%;">
					<?php if($woo_dropshipper == null || $woo_dropshipper == '' || $woo_dropshipper == '--'){ ?>
						<option value="--" selected="selected">-- <?php echo __('No Dropshipper','woocommerce-dropshippers'); ?> --</option>
					<?php } else{ ?>
						<option value="--">-- <?php echo __('No Dropshipper','woocommerce-dropshippers'); ?> --</option>
					<?php } ?>
				<?php
				if( is_array( $dropshipperz ) && count( $dropshipperz ) > 0 ) {
		    		foreach ($dropshipperz as $drop) {
		    			if($woo_dropshipper == $drop->user_login){
		    				echo '<option value="' . $drop->user_login . '" selected="selected">' . ucwords($drop->user_nicename) . '</option>';
		    			}
		        		else{
		        			echo '<option value="' . $drop->user_login . '">' . ucwords($drop->user_nicename) . '</option>';
		        		}
		    		}
		    	}
				?>
				</select>
                 
                <?php


				/* My coding attached here 
				 * closing the block below for finalization
				 * the only code added by me (shoaib) is to checkuot key values attached to each product
				 */
				
				// key-block started
				$metas = get_post_meta($post->ID, '_product_addons', 'description');
				
				echo '<table>';
				foreach( $metas as $key => $meta ) {
					printf('<tr><th>%s</th><td>%s</td></tr>',
					$key, $meta[0] );
				}
				echo '</table>';
				// key-block ends
				
			
			
			}

			add_action( 'add_meta_boxes', 'add_dropshipper_metaboxes' );
			function add_dropshipper_metaboxes() {
				add_meta_box('wc_dropshippers_location', __('Dropshipper','woocommerce-dropshippers'), 'print_dropshipper_list_metabox', 'product', 'side', 'default');
			}
			
			
			
			/* coding removed */
	        // saving settings to the product page
	       	/* USEFUL FUNCTIONS */
			/* WIDGET */

						
				/* My coding attached here 
				 * i created a similar block to attach a metabox to each order
				 * the main idea is to set a dropshipper for the order and sent mail to him
				 */				

			/* ADD METABOX WITH DROPSHIPPER STATUSES IN ADMIN ORDERS */
			// this meta box is used to add the dropshipper to each order
			
			
			add_action( 'add_meta_boxes', 'add_dropshipper_metaboxes1' );
			function add_dropshipper_metaboxes1() {
				add_meta_box('wc_dropshippers_location', __('Dropshipper','woocommerce-dropshippers'), 'print_dropshipper_list_metabox1', 'shop_order', 'side', 'default');
			}
			
			
			/* METABOX */
			function print_dropshipper_list_metabox1($post){
				
				global $user;
				$woo_dropshipper = get_post_meta( $post->ID, 'woo_dropshipper', true );
				$dropshipperz = get_users('role=dropshipper');
				?>
				<label for="dropshippers-select"> <?php _e( "Select a Dropshipper",'woocommerce-dropshippers') ?></label>
				<select name="dropshippers-select" id="dropshippers-select" style="width:100%;">
					<?php if($woo_dropshipper == null || $woo_dropshipper == '' || $woo_dropshipper == '--'){ ?>
						<option value="--" selected="selected">-- <?php echo __('No Dropshipper','woocommerce-dropshippers'); ?> --</option>
					<?php } else{ ?>
						<option value="--">-- <?php echo __('No Dropshipper','woocommerce-dropshippers'); ?> --</option>
					<?php } ?>
				<?php
				if( is_array( $dropshipperz ) && count( $dropshipperz ) > 0 ) {
		    		foreach ($dropshipperz as $drop) {
		    			if($woo_dropshipper == $drop->user_login){
		    				echo '<option value="' . $drop->user_login . '" selected="selected">' . ucwords($drop->user_login) . '</option>';				$user = get_userdata($drop->ID);
		    			}
		        		else{
		        			echo '<option value="' . $drop->user_login . '">' . ucwords($drop->user_login) . '</option>';
		        		}
		    		}
		    	}
				
				
				?>
				</select> 
                
				<?php
				// Variable describing the value of User
				// Function getting the value of all the users
				echo $email = $user->user_email;
				?>
                <br/><br/><input type="checkbox" name="checkbox" id="checkbox" />Send email to this recepient<br/> 
                <!--<input type="submit" name="check" value="Mail" />-->
                <?php
				
				// i finalize this block of data for getting order prices for dropshippers (shoaib)
				$order_id = $post->ID;
				$order = new WC_Order( $order_id );
				$items = $order->get_items();
				$sum = 0;
				
				
				echo '<table>';
				echo '<tr><th>Product</th><td>DropS Price</td><td>Qty</td></tr>';
				foreach ( $items as $item ) {
					$product_name = $item['name'];
					 $product_id = $item['product_id'];
				     $product_variation_id = $item['variation_id'];
					 $item_qty = $item['qty'];
					
					
					$variation_dropshipper_price = get_post_meta($product_variation_id,'_dropshipper_price',true);
					if(!empty($variation_dropshipper_price)){
						echo '<tr><th>' . $product_name . '</th><td style="text-align: right">' . $variation_dropshipper_price. '</td><td style="text-align: right">' . $item_qty . '</td></tr>';
						$sum = $sum + ($variation_dropshipper_price)*$item_qty;
						}
					
					
					$product_dropshipper_price = get_post_meta($product_id,'_dropshipper_price',true);
					if(!empty($product_dropshipper_price)){
						echo '<tr><th>' . $product_name . '</th><td style="text-align: right">' . $product_dropshipper_price. '</td><td style="text-align: right">' . $item_qty . '</td></tr>';
						$sum = $sum + ($product_dropshipper_price)*$item_qty;
						}
					
				}
				echo '<tr><th></th><td></td></tr>';
				echo '<tr><th style="text-align: right">Total</th><td style="text-align: right">'. $sum .'</td></tr>';
				echo '</table>';
				// end code block 
				
				$dropshipper_tax_total = $sum;
				if(!($dropshipper_tax_total <= 0)){
				update_post_meta($post->ID, 'dropshipper_tax_total', $dropshipper_tax_total); 
				}
				
				if($order->customer_message != NULL){
					$dropshipper_costumer_note = $order->customer_message;
					update_post_meta($post->ID, 'dropshipper_costumer_note', $dropshipper_costumer_note); 
					}
				
				
				
				/* Similar to find a key value pair for products 
				 * this piece of code dislays the key value pair for current order 
				 * as well as for the products attached to it
				 * the block should be commented and closed after debugging or finalization
				 */

				// key-value block started
				$metas = get_post_meta($post->ID);
				
				echo '<table>';
				foreach( $metas as $key => $meta ) {
					printf('<tr><th>%s</th><td>%s</td></tr>',
					$key, $meta[0] );
				}
				echo '</table>';
				
				 
				$items = $order->get_items();
				$product_keys = array();
				
				echo '<table>';
				foreach ($items as $keys => $line_item){
					printf('<tr><th>%s</th><td>%s</td></tr>', $keys, $line_item );
				
					$item_id = $line_item['product_id'];
				
					echo '<table>';
					$temp_array = array();
					foreach($line_item as $keyp => $line){
						
						printf('<tr><th>%s</th><td>%s</td></tr>', $keyp ,$line);
						
							if (stripos($keyp,'Different Options') !== false 
									|| stripos($keyp,'Different Option') !== false
										|| stripos($keyp,'Double Flower Quantity') !== false ) {
								array_push($temp_array, $line);
								echo 'true';
							}
						
					$product_keys[$item_id] = $temp_array;
					}
					
					echo '</table>';
					
				}
				
				echo '<br/>';
				var_dump($product_keys);
				echo '<br/>';
				echo '</table>';
				
				foreach($product_keys as $pk => $v){
					echo $pk;
					foreach($v as $k => $l){
						printf(' %s - %s<br/>', $k, $l );
						}
					
					
					}
				// key-value block end
				
				
				
				
				/* this block is used to get a meta value attached with a product 
				 * because the key-value is not attached to order itself 
				 * i fetch the value from product via loop above and set it to a meta value of order for easy access
				 * this is the final script to create a meta value */
				 
				// fetching starts 
				$items = $order->get_items();
				$product_keys = array();
				
				foreach ($items as $keys => $line_item){
					$item_id = $line_item['product_id'];
					$temp_array = array();
					foreach($line_item as $keyp => $line){
						
							if (stripos($keyp,'Different Options') !== false 
									|| stripos($keyp,'Different Option') !== false
										|| stripos($keyp,'Double Flower Quantity') !== false	) {
								array_push($temp_array, $line);
							}
			
					$product_keys[$item_id] = $temp_array;
					}
				}
				
				update_post_meta($post->ID, 'product_addon_details', $product_keys);
				
				foreach($product_keys as $pk => $v){
					echo $pk . '<br/>';
					foreach($v as $k => $l){
						printf(' %s - %s<br/>', $k, $l );
						}
					}
				// fetching ends
			}
			
		
			
			/* finally i created a similar block to add the dropshipper to order meta
			 * also written functions to check the order status and send email to him 
			 */			
			
			add_action( 'save_post', 'save_dropshipper1', 10, 2 );
			function save_dropshipper1($post_id, $post){
				/* Get the post type object. */
				$post_type = get_post_type_object( $post->post_type );
				
				global $user;
				/* Get the posted data and sanitize it for use as an HTML class. */
				if(isset( $_POST['dropshippers-select'])){
					$new_meta_value = $_POST['dropshippers-select'];//sanitize_html_class( $_POST['dropshippers-select'] );
					update_post_meta( $post_id, 'woo_dropshipper', $new_meta_value);
				}
				
				
				if(isset($_POST['checkbox'])){
									
					$woo_drop=$_POST['dropshippers-select'];
					global $post;
					$order_id = $post->ID;
					global $email;
					$order = new WC_Order($order_id);
					$woo_dropshipper = get_post_meta( $post->ID, 'woo_dropshipper' );
					$dropshipperz = get_users('role=dropshipper');
					if( is_array( $dropshipperz ) && count( $dropshipperz ) > 0 ) {
						foreach ($dropshipperz as $drop) {
							if($new_meta_value == $drop->user_login){
								$user = get_userdata($drop->ID);
					
								// actual calling the action hook ... step3
								if('cancelled' != $order->status && isset($_POST['checkbox']) ){
								
								// this action calls to email sending function to dropshipper
								// apologize for the bad naming 	
								do_action('the_action_hook2');
								}
							}
						}						
					}
					
					
				 	if('cancelled' == $order->status){
					 
						 // actual calling the action hook ... step3
						 // this is used to send cancelled order emails to dropshippr
						 do_action('the_action_hook3');
					 }
				}
			}
			
		
			// if order is cancelled ... this function will run 
			// create my own action hook ... step1
			add_action('the_action_hook2', 'the_action_callback');
			
			// call the action of the action hook .... still not executing yet .. step2
			function the_action_callback(){
				global $email;
				global $post;
				$order_id = $post->ID;
				$product_addon_details = get_post_meta($post->ID, 'product_addon_details' , true);
				
				// Dropshippers involved in the order and their shipping information
				$final_dropshippers = array();
				
				$real_products = array();
				// single email design model ... no need $emails = array();
				$order = new WC_Order($order_id);
				$items = $order->get_items();
				
				
				$dropshippers = get_users(array( 'role' => 'dropshipper'));
				$options = get_option('woocommerce_dropshippers_options');
				if( is_array( $dropshippers ) && count( $dropshippers ) > 0 ) {
			
			
			foreach ($dropshippers as $dropshipper) {
				$dropshipper_earning = get_user_meta($dropshipper->ID, 'dropshipper_earnings', true);
				if(!$dropshipper_earning){
					$dropshipper_earning = 0;
				}
				$user_login = $dropshipper->user_login;
				foreach ($items as $item) {
					
					if(get_post_meta( $post->ID, 'woo_dropshipper', true) == $user_login){
						if(! isset($real_products[$user_login])){
							$real_products[$user_login] = array();
						}
						
						
						array_push($real_products[$user_login], $item);
						
					}
				}
				
				// Prepare the email and update earnings if there are products for this dropshipper
				if(isset($real_products[$user_login])){
					$final_dropshippers[$user_login] = 'Not shipped yet';
					ob_start();
					?>
					<div style="background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none ; margin: 0; padding: 70px  0  70px  0;">
			        	<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
			        		<tbody><tr><td valign="top" align="center">
							<table width="600" cellspacing="0" cellpadding="0" border="0" style="-webkit-box-shadow: 0  0  0  3px  rgba; box-shadow: 0  0  0  3px  rgba; -webkit-border-radius: 6px ; border-radius: 6px ; background-color: #fdfdfd; border: 1px  solid  #dcdcdc; -webkit-border-radius: 6px ; border-radius: 6px ;" id="template_container"><tbody><tr><td valign="top" align="center">
								<table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#557da1" style="background-color: #557da1; color: #ffffff; -webkit-border-top-left-radius: 6px ; -webkit-border-top-right-radius: 6px ; border-top-left-radius: 6px ; border-top-right-radius: 6px ; border-bottom: 0px; font-family: Arial; font-weight: bold; line-height: 100%; vertical-align: middle;" id="template_header"><tbody><tr><td>
									<h1 style="color: #ffffff; margin: 0; padding: 28px  24px; text-shadow: 0  1px  0  #7797b4; display: block; font-family: Arial; font-size: 30px; font-weight: bold; text-align: left; line-height: 150%;"><img src="http://www.thedubaiflowers.com/wp-content/uploads/2015/01/logo1.png"><br/><?php echo __('New customer order','woocommerce-dropshippers'); ?></h1>
								</td></tr></tbody></table></td></tr><tr><td valign="top" align="center">
								<table width="600" cellspacing="0" cellpadding="0" border="0" id="template_body">
									<tbody><tr><td valign="top" style="background-color: #fdfdfd; -webkit-border-radius: 6px ; border-radius: 6px ;">
										<table width="100%" cellspacing="0" cellpadding="20" border="0"><tbody><tr><td valign="top">
										<div style="color: #737373; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;"><p><?php echo str_replace('%SURNAME%', $order->billing_last_name, str_replace('%NAME%', $order->billing_first_name, __('You have received an order from %NAME% %SURNAME%. Their order is as follows:','woocommerce-dropshippers'))); ?></p>
										<h2 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo str_replace('%NUMBER%', $order->get_order_number(), __('From order %NUMBER%','woocommerce-dropshippers')); ?> (<!-- time ignored --><?php /*echo $order->order_date;*/ ?>)</h2>
										<table cellspacing="0" cellpadding="6" border="1" style="width: 100%; border: 1px  solid  #eee;">
										<thead><tr><th style="text-align: left; border: 1px  solid  #eee;"><?php echo __('Product','woocommerce-dropshippers'); ?></th>
						<th style="text-align: left; border: 1px  solid  #eee;"><?php echo __('Quantity','woocommerce-dropshippers'); ?></th>
						<?php
							if($options['text_string'] == "Yes"){ // Can show prices
								echo '<th style="text-align: left; border: 1px  solid  #eee;">'. __('Price','woocommerce-dropshippers') .'</th>';
							}
						?>
					</tr></thead><tbody>
					<?php
						$drop_subtotal = 0;
						$drop_total_earnings = 0;
						$sudicio = '';
						foreach ($real_products[$user_login] as $item) {
							
							$my_item_post = get_post($item['product_id']);
							$drop_price = get_post_meta( $item['product_id'], '_dropshipper_price', true );
							
							
							
													
							if(!$drop_price){ $drop_price = 0;}
							$drop_subtotal += ( ((float) $item['line_total']) + ((float) $item['line_tax']) );
							echo '<tr><td style="text-align: left; vertical-align: middle; border: 1px  solid  #eee; word-wrap: break-word;">'. __($my_item_post->post_title);
							
							if($item['variation_id'] != 0){
								$drop_price = get_post_meta( $item['variation_id'], '_dropshipper_price', true );
								if(!$drop_price){ $drop_price = 0;}
								$item_meta = new WC_Order_Item_Meta( $item['item_meta'] );
								if ( $item_meta->meta )
									echo '<br/><small>' . nl2br( $item_meta->display( true, true ) ) .  '</small>';
									


							}
							
														
							echo '<br><small></small></td>';
							echo '<td style="text-align: left; vertical-align: middle; border: 1px  solid  #eee;">' . $item['qty'] .'</td>';
							$drop_total_earnings += ($drop_price*$item['qty']);
							if($options['text_string'] == "Yes"){ //show prices
								echo '<td style="text-align: left; vertical-align: middle; border: 1px  solid  #eee;"><span class="amount">'. woocommerce_price(( ((float) $item['line_total']) + ((float) $item['line_tax']) )).'</span></td></tr>';
							}
						}
						if($drop_total_earnings){
							$product_dropshipper_price = get_post_meta($order_id,'dropshipper_tax_total',true);
							update_user_meta($dropshipper->ID, 'dropshipper_earnings', ($dropshipper_earning + $product_dropshipper_price));
							//update_user_meta($dropshipper->ID, 'dropshipper_earnings', ($dropshipper_earning + $drop_total_earnings));
						}
					?>
					</tbody>
					<tfoot>
						<?php
							if($options['text_string'] == "Yes"){ // Can show prices
						?>
							<tr><th style="text-align: left; border: 1px  solid  #eee; border-top-width: 4px;" colspan="2"><?php echo __('Cart Subtotal:','woocommerce-dropshippers'); ?></th>
							<td style="text-align: left; border: 1px  solid  #eee; border-top-width: 4px;"><span class="amount"><?php echo woocommerce_price($drop_subtotal); ?></span></td>
							</tr>
							<?php
								if(! isset($options['can_see_email_shipping'])){ $options['can_see_email_shipping'] = 'Yes'; }
								if($options['can_see_email_shipping'] == 'Yes'){
							?>
							<tr><th style="text-align: left; border: 1px  solid  #eee;" colspan="2"><?php echo __('Shipping:','woocommerce-dropshippers'); ?></th>
								<td style="text-align: left; border: 1px  solid  #eee;"><?php echo $order->get_shipping_method(); ?></td>
							</tr>
							<?php } ?>
							<tr><th style="text-align: left; border: 1px  solid  #eee;" colspan="2"><?php echo __('Order Total:','woocommerce-dropshippers'); ?></th>
								<td style="text-align: left; border: 1px  solid  #eee;"><span class="amount"><?php
									if($options['can_see_email_shipping'] == 'Yes'){
										echo woocommerce_price(($drop_subtotal + $order->get_total_shipping()));
									}
									else{
										echo woocommerce_price($drop_subtotal);
									}
								?></span></td>
							</tr>
						<?php
							}
						?>
                        
					</tfoot></table>
                    
                    
                    <!-- this is a custom table inserted here for dropshipper for details -->
                    <table width="100%">
                    <?php                    
                     	foreach($product_addon_details as $pk => $v){
							
							?>
                            <tr>
                            	<td style="padding:2%">
                                <?php echo get_the_post_thumbnail( $pk, 'thumbnail' ); ?>
                                </td>
                                <td>
                            	<?php    
									echo $pk . '<br/>';
									foreach($v as $k => $l){
										printf(' %s - %s<br/>', $k+1, $l );
									}
								?>
                                </td>
                            </tr>
                            <?php
							
						}
					?>
                    </table>
                   
                    
                    <h2 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo __('Customer details','woocommerce-dropshippers'); ?></h2>
					<?php
					if($options['can_see_email'] == 'Yes'){ ?>
						<p><strong><?php echo __('Email:','woocommerce-dropshippers'); ?></strong>
						<a onclick="return rcmail.command('compose','<?php echo $order->billing_email; ?>',this)" href="mailto:<?php echo $order->billing_email; ?>"><?php echo $order->billing_email; ?></a></p>
					<?php
					}
					if($options['can_see_phone'] == 'Yes'){ ?>
						<p><strong><?php echo __('Tel:','woocommerce-dropshippers'); ?></strong> <?php echo $order->billing_phone; ?></p>
					<?php
					}
					?>
					<table cellspacing="0" cellpadding="0" border="0" style="width: 100%; vertical-align: top;"><tbody><tr><td width="50%" valign="top">
					<h3 style="color: #505050; display: block; font-family: Arial; font-size: 26px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo __('Billing address','woocommerce-dropshippers'); ?></h3><p><?php echo (isset($options['billing_address'])?nl2br($options['billing_address']):''); ?></p>
					</td>
					<td width="50%" valign="top">
						<h3 style="color: #505050; display: block; font-family: Arial; font-size: 26px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo __('Shipping address','woocommerce-dropshippers'); ?></h3><p><?php echo $order->get_formatted_shipping_address(); ?></p>
                      <p>Required Date to be shipped on <br/><?php echo get_post_meta($post->ID,'Delivery Date',true)?> </p>
                      <p>Your Dropshipping charges will be $<?php echo get_post_meta($post->ID,'dropshipper_tax_total',true)?> </p>
                      <p><strong>Dropshipper Costumer Notes:</strong> <br/> <?php echo get_post_meta($post->ID,'dropshipper_costumer_note',true)?></p>
    					

					</td>

					
				</tr></tbody></table></div>
																	</td>
			                                                    </tr></tbody></table></td>
			                                        </tr></tbody></table></td>
			                            </tr><tr><td valign="top" align="center">
			                                    
			                                	<table width="600" cellspacing="0" cellpadding="10" border="0" style="border-top: 0px; -webkit-border-radius: 6px;" id="template_footer"><tbody><tr><td valign="top">
			                                                <table width="100%" cellspacing="0" cellpadding="10" border="0"><tbody><tr><td valign="middle" style="border: 0; color: #99b1c7; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;" id="credit" colspan="2"><p><?php echo bloginfo('name'); ?></p>
			                                                        </td>
			                                                    </tr></tbody></table></td>
			                                        </tr></tbody></table></td>
			                            </tr></tbody></table></td>
			                </tr></tbody></table></div>
					<?php
					$lolvar = ob_get_clean();
					$headers = __('From:','woocommerce-dropshippers') .' '. get_option('blogname'). ' <'. get_option('admin_email') .'>' . "\r\n";
					add_filter( 'wp_mail_content_type', 'dropshippers_set_html_content_type' );
					wp_mail($dropshipper->user_email, __('New customer order','woocommerce-dropshippers'), $lolvar, $headers);
					// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
					remove_filter( 'wp_mail_content_type', 'dropshippers_set_html_content_type' );
				}
				update_post_meta($order_id, 'dropshippers', $final_dropshippers);
			}
		}
				
				
				
				
				
			}
			
			
			// create my own action hook ... step1
			add_action('the_action_hook3', 'the_action_callback3');
			
			function the_action_callback3(){
				global $email;
				global $post;
				$order_id = $post->ID;
				$product_addon_details = get_post_meta($post->ID, 'product_addon_details' , true);
				
				// Dropshippers involved in the order and their shipping information
				$final_dropshippers = array();
				
				$real_products = array();
				// single email design model ... no need $emails = array();
				$order = new WC_Order($order_id);
				$items = $order->get_items();
				
				$dropshippers = get_users(array( 'role' => 'dropshipper'));
				$options = get_option('woocommerce_dropshippers_options');
				if( is_array( $dropshippers ) && count( $dropshippers ) > 0 ) {
			
			
			foreach ($dropshippers as $dropshipper) {
				$dropshipper_earning = get_user_meta($dropshipper->ID, 'dropshipper_earnings', true);
				if(!$dropshipper_earning){
					$dropshipper_earning = 0;
				}
				$user_login = $dropshipper->user_login;
				foreach ($items as $item) {
					
					if(get_post_meta( $post->ID, 'woo_dropshipper', true) == $user_login){
						if(! isset($real_products[$user_login])){
							$real_products[$user_login] = array();
						}
						
						
						array_push($real_products[$user_login], $item);
						
					}
				}
				
				// Prepare the email and update earnings if there are products for this dropshipper
				if(isset($real_products[$user_login])){
					$final_dropshippers[$user_login] = 'Not shipped yet';
					ob_start();
					?>
					<div style="background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none ; margin: 0; padding: 70px  0  70px  0;">
			        	<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
			        		<tbody><tr><td valign="top" align="center">
							<table width="600" cellspacing="0" cellpadding="0" border="0" style="-webkit-box-shadow: 0  0  0  3px  rgba; box-shadow: 0  0  0  3px  rgba; -webkit-border-radius: 6px ; border-radius: 6px ; background-color: #fdfdfd; border: 1px  solid  #dcdcdc; -webkit-border-radius: 6px ; border-radius: 6px ;" id="template_container"><tbody><tr><td valign="top" align="center">
								<table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#557da1" style="background-color: #557da1; color: #ffffff; -webkit-border-top-left-radius: 6px ; -webkit-border-top-right-radius: 6px ; border-top-left-radius: 6px ; border-top-right-radius: 6px ; border-bottom: 0px; font-family: Arial; font-weight: bold; line-height: 100%; vertical-align: middle;" id="template_header"><tbody><tr><td>
									<h1 style="color: #ffffff; margin: 0; padding: 28px  24px; text-shadow: 0  1px  0  #7797b4; display: block; font-family: Arial; font-size: 30px; font-weight: bold; text-align: left; line-height: 150%;"><img src="http://www.thedubaiflowers.com/wp-content/uploads/2015/01/logo1.png"><br/><?php echo __('Pre customer order','woocommerce-dropshippers'); ?></h1>
								</td></tr></tbody></table></td></tr><tr><td valign="top" align="center">
								<table width="600" cellspacing="0" cellpadding="0" border="0" id="template_body">
									<tbody><tr><td valign="top" style="background-color: #fdfdfd; -webkit-border-radius: 6px ; border-radius: 6px ;">
										<table width="100%" cellspacing="0" cellpadding="20" border="0"><tbody><tr><td valign="top">
										<div style="color: #737373; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;"><p><?php echo str_replace('%SURNAME%', $order->billing_last_name, str_replace('%NAME%', $order->billing_first_name, __('You have received an order from %NAME% %SURNAME%. Their order is as follows:','woocommerce-dropshippers'))); ?></p>
										<h2 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo str_replace('%NUMBER%', $order->get_order_number(), __('From order %NUMBER%','woocommerce-dropshippers')); ?> (<!-- time ignored --><?php echo 'This order has been cancelled'; /*echo $order->order_date;*/ ?>)</h2>
										<table cellspacing="0" cellpadding="6" border="1" style="width: 100%; border: 1px  solid  #eee;">
										<thead><tr><th style="text-align: left; border: 1px  solid  #eee;"><?php echo __('Product','woocommerce-dropshippers'); ?></th>
						<th style="text-align: left; border: 1px  solid  #eee;"><?php echo __('Quantity','woocommerce-dropshippers'); ?></th>
						<?php
							if($options['text_string'] == "Yes"){ // Can show prices
								echo '<th style="text-align: left; border: 1px  solid  #eee;">'. __('Price','woocommerce-dropshippers') .'</th>';
							}
						?>
					</tr></thead><tbody>
					<?php
						$drop_subtotal = 0;
						$drop_total_earnings = 0;
						$sudicio = '';
						foreach ($real_products[$user_login] as $item) {
							
							
							
							$my_item_post = get_post($item['product_id']);
							$drop_price = get_post_meta( $item['product_id'], '_dropshipper_price', true );
							
														
							if(!$drop_price){ $drop_price = 0;}
							$drop_subtotal += ( ((float) $item['line_total']) + ((float) $item['line_tax']) );
							echo '<tr><td style="text-align: left; vertical-align: middle; border: 1px  solid  #eee; word-wrap: break-word;">'. __($my_item_post->post_title);
							if($item['variation_id'] != 0){
								$drop_price = get_post_meta( $item['variation_id'], '_dropshipper_price', true );
								if(!$drop_price){ $drop_price = 0;}
								$item_meta = new WC_Order_Item_Meta( $item['item_meta'] );
								if ( $item_meta->meta )
									echo '<br/><small>' . nl2br( $item_meta->display( true, true ) ) .  '</small>';
									


							}
							
							
							
							echo '<br><small></small></td>';
							echo '<td style="text-align: left; vertical-align: middle; border: 1px  solid  #eee;">' . $item['qty'] .'</td>';
							$drop_total_earnings += ($drop_price*$item['qty']);
							if($options['text_string'] == "Yes"){ //show prices
								echo '<td style="text-align: left; vertical-align: middle; border: 1px  solid  #eee;"><span class="amount">'. woocommerce_price(( ((float) $item['line_total']) + ((float) $item['line_tax']) )).'</span></td></tr>';
							}
						}
						if($drop_total_earnings){
							$product_dropshipper_price = get_post_meta($order_id,'dropshipper_tax_total',true);
							update_user_meta($dropshipper->ID, 'dropshipper_earnings', ($dropshipper_earning - $product_dropshipper_price));
							//update_user_meta($dropshipper->ID, 'dropshipper_earnings', ($dropshipper_earning + $drop_total_earnings));
						}
					?>
					</tbody>
					<tfoot>
						<?php
							if($options['text_string'] == "Yes"){ // Can show prices
						?>
							<tr><th style="text-align: left; border: 1px  solid  #eee; border-top-width: 4px;" colspan="2"><?php echo __('Cart Subtotal:','woocommerce-dropshippers'); ?></th>
							<td style="text-align: left; border: 1px  solid  #eee; border-top-width: 4px;"><span class="amount"><?php echo woocommerce_price($drop_subtotal); ?></span></td>
							</tr>
							<?php
								if(! isset($options['can_see_email_shipping'])){ $options['can_see_email_shipping'] = 'Yes'; }
								if($options['can_see_email_shipping'] == 'Yes'){
							?>
							<tr><th style="text-align: left; border: 1px  solid  #eee;" colspan="2"><?php echo __('Shipping:','woocommerce-dropshippers'); ?></th>
								<td style="text-align: left; border: 1px  solid  #eee;"><?php echo $order->get_shipping_method(); ?></td>
							</tr>
							<?php } ?>
							<tr><th style="text-align: left; border: 1px  solid  #eee;" colspan="2"><?php echo __('Order Total:','woocommerce-dropshippers'); ?></th>
								<td style="text-align: left; border: 1px  solid  #eee;"><span class="amount"><?php
									if($options['can_see_email_shipping'] == 'Yes'){
										echo woocommerce_price(($drop_subtotal + $order->get_total_shipping()));
									}
									else{
										echo woocommerce_price($drop_subtotal);
									}
								?></span></td>
							</tr>
						<?php
							}
						?>
                        
					</tfoot></table>
                    
                    <!-- this is a custom table inserted here for dropshipper for details -->
                    <table width="100%">
                    <?php                    
                     	foreach($product_addon_details as $pk => $v){
							
							?>
                            <tr>
                            	<td style="padding:2%">
                                <?php echo get_the_post_thumbnail( $pk, 'thumbnail' ); ?>
                                </td>
                                <td>
                            	<?php    
									echo $pk . '<br/>';
									foreach($v as $k => $l){
										printf(' %s - %s<br/>', $k+1, $l );
									}
								?>
                                </td>
                            </tr>
                            <?php
							
						}
					?>
                    </table>
                    
                    
                    <h2 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo __('Customer details','woocommerce-dropshippers'); ?></h2>
					<?php
					if($options['can_see_email'] == 'Yes'){ ?>
						<p><strong><?php echo __('Email:','woocommerce-dropshippers'); ?></strong>
						<a onclick="return rcmail.command('compose','<?php echo $order->billing_email; ?>',this)" href="mailto:<?php echo $order->billing_email; ?>"><?php echo $order->billing_email; ?></a></p>
					<?php
					}
					if($options['can_see_phone'] == 'Yes'){ ?>
						<p><strong><?php echo __('Tel:','woocommerce-dropshippers'); ?></strong> <?php echo $order->billing_phone; ?></p>
					<?php
					}
					?>
					<table cellspacing="0" cellpadding="0" border="0" style="width: 100%; vertical-align: top;"><tbody><tr><td width="50%" valign="top">
					<h3 style="color: #505050; display: block; font-family: Arial; font-size: 26px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo __('Billing address','woocommerce-dropshippers'); ?></h3><p><?php echo (isset($options['billing_address'])?nl2br($options['billing_address']):''); ?></p>
					</td>
					<td width="50%" valign="top">
						<h3 style="color: #505050; display: block; font-family: Arial; font-size: 26px; font-weight: bold; margin-top: 10px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; text-align: left; line-height: 150%;"><?php echo __('Shipping address','woocommerce-dropshippers'); ?></h3><p><?php echo $order->get_formatted_shipping_address(); ?></p>
                      <p>Required Date to be shipped on <br/><?php echo get_post_meta($post->ID,'Delivery Date',true)?> </p>
                      <p>Your and my Dropshipping charges will be $<?php echo get_post_meta($post->ID,'dropshipper_tax_total',true)?></p>
                      <p>Dropshipper Costumer Notes: <br/> <?php echo get_post_meta($post->ID,'dropshipper_costumer_note',true)?></p>
                      
    					

					</td>

					
				</tr></tbody></table></div>
																	</td>
			                                                    </tr></tbody></table></td>
			                                        </tr></tbody></table></td>
			                            </tr><tr><td valign="top" align="center">
			                                    
			                                	<table width="600" cellspacing="0" cellpadding="10" border="0" style="border-top: 0px; -webkit-border-radius: 6px;" id="template_footer"><tbody><tr><td valign="top">
			                                                <table width="100%" cellspacing="0" cellpadding="10" border="0"><tbody><tr><td valign="middle" style="border: 0; color: #99b1c7; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;" id="credit" colspan="2"><p><?php echo bloginfo('name'); ?></p>
			                                                        </td>
			                                                    </tr></tbody></table></td>
			                                        </tr></tbody></table></td>
			                            </tr></tbody></table></td>
			                </tr></tbody></table></div>
					<?php
					$lolvar = ob_get_clean();
					$headers = __('From:','woocommerce-dropshippers') .' '. get_option('blogname'). ' <'. get_option('admin_email') .'>' . "\r\n";
					add_filter( 'wp_mail_content_type', 'dropshippers_set_html_content_type' );
					wp_mail($dropshipper->user_email, __('Pre customer order','woocommerce-dropshippers'), $lolvar, $headers);
					// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
					remove_filter( 'wp_mail_content_type', 'dropshippers_set_html_content_type' );
				}
				update_post_meta($order_id, 'dropshippers', $final_dropshippers);
			}
		}
				
				
				
				
				
			}
		
			
			
				
				
				
				
				
				
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
	    }
	}
}
?>