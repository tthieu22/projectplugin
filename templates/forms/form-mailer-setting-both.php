<?php defined( 'ABSPATH' ) || exit; 

$subject_admin = !empty(get_option('subject_admin')) ? get_option('subject_admin') : 'Require for Booking';
$subject_customer = !empty(get_option('subject_customer')) ? get_option('subject_customer') : 'Require for Booking';

$from_name_admin = !empty(get_option('from_name_admin')) ? get_option('from_name_admin') : 'Require for Booking';
$from_name_customer = !empty(get_option('from_name_customer')) ? get_option('from_name_customer') : 'Require for Booking';

$send_from_email = !empty(get_option('send_from_email')) ? get_option('send_from_email') : get_option('admin_email');
$recipient  = get_option('recipient',['']);

$message_admin = get_option('message_admin', '');
$message_customer = get_option('message_customer', '');

$thank_you_page = get_option('thank_you_page', '');
$error_page = get_option('error_page', '');

$args = array(
    'post_type'      => 'page', 
    'posts_per_page' => -1,   
    'orderby'        => 'title',
    'order'          => 'ASC',
);
$posts = get_posts($args);
?>
<div class="content-wrapper-both">
	<div class="box-content-input">
        <label for="send_from_email">Send from email</label>
        <input type="email" class="input-custom" id="send_from_email" name="send_from_email" value="<?php echo esc_attr($send_from_email); ?>">
    </div>
    <div class="box-content-input">
	    <label for="recipient">Recipient (s)</label>
	    <input type="text"  class="input-custom" id="recipient" name="recipient" value="<?php echo esc_attr(is_array($recipient) ? implode('|', $recipient) : $recipient); ?>">
	</div>
	<div class="accordion-custom">
	    <div class="accordion-item-custom active">
	        <div class="accordion-header-custom">
	            <h6>Admin</h6>
	        </div>
	        <div class="accordion-body-custom">
	        	<div class="box-content-input">
			         <label for="subject">Subject<span><br>You can use some short code  [first_name] : First name, [last_name]: Last name, [phone]: Phone, [email]: Email, [address]: Address, [project_id]: Post, [information]: Information</span></label>
			        <input type="input" class="input-custom" id="subject_admin" name="subject_admin" value="<?php echo esc_attr($subject_admin); ?>">
			    </div>

			    <div class="box-content-input">
			         <label for="subject">From Name<span><br>You can use some short code  [first_name] : First name, [last_name]: Last name, [phone]: Phone, [email]: Email, [address]: Address, [project_id]: Post, [information]: Information</span></label>

			        <input type="input" class="input-custom" id="from_name_admin" name="from_name_admin" value="<?php echo esc_attr($from_name_admin); ?>">
			    </div>
			     <div class="box-content-input">
			        <label for="subject">Message<span><br>You can use some short code  [first_name] : First name, [last_name]: Last name, [phone]: Phone, [email]: Email, [address]: Address, [project_id]: Post, [information]: Information</span></label>
					<?php 
			            wp_editor( 
			                 $message_admin, 
			                 'message_admin', 
			                 array(
			                     'wpautop'       => true,
			                     'media_buttons' => true,
			                     'textarea_name' => 'message_admin',
			                     'editor_class'  => 'project-description-textarea-admin',
			                     'textarea_rows' => 15,
			                     'placeholder' => 'Project Description WP Editor Default 2 Admin'
			                 ) 
			            );
			        ?>
			    </div>
	        </div>
	    </div>
	    <div class="accordion-item-custom">
	        <div class="accordion-header-custom">
	            <h6>Customer</h6>
	        </div>
	        <div class="accordion-body-custom">
	        	<div class="box-content-input">
			         <label for="subject">Subject<span><br>You can use some short code  [first_name] : First name, [last_name]: Last name, [phone]: Phone, [email]: Email, [address]: Address, [project_id]: Post, [information]: Information</span></label>
			        <input type="input" class="input-custom" id="subject_customer" name="subject_customer" value="<?php echo esc_attr($subject_customer); ?>">
			    </div>

			    <div class="box-content-input">
			         <label for="subject">From Name<span><br>You can use some short code  [first_name] : First name, [last_name]: Last name, [phone]: Phone, [email]: Email, [address]: Address, [project_id]: Post, [information]: Information</span></label>
			        <input type="input" class="input-custom" id="from_name_customer" name="from_name_customer" value="<?php echo esc_attr($from_name_customer); ?>">
			    </div>
			    <div class="box-content-input">
			         <label for="subject">Message<span><br>You can use some short code  [first_name] : First name, [last_name]: Last name, [phone]: Phone, [email]: Email, [address]: Address, [project_id]: Post, [information]: Information</span></label>
			        <?php 
			            wp_editor( 
			                 $message_customer, 
			                 'message_customer', 
			                 array(
			                     'wpautop'       => true,
			                     'media_buttons' => true,
			                     'textarea_name' => 'message_customer',
			                     'editor_class'  => 'project-description-customer',
			                     'textarea_rows' => 15,
			                     'placeholder' => 'Description WP Editor Default 2 Customer'
			                 ) 
			            );
			        ?>
			    </div>
	        </div>
	    </div>
	</div>
    <hr>
    <h3>Other Setting</h3>
    <div class="box-content-input">
        <label for="thank_you_page">Thank you page</label>
        <select name="thank_you_page" id="thank_you_page">
            <option value="" disabled selected>Select</option>
            <?php
            foreach ( $posts as $post ) {
                echo '<option value="' . esc_attr( $post->ID ) . '" ' . selected( $thank_you_page, $post->ID, false ) . '>' . esc_html( $post->post_title ) . '</option>';
            }
            ?>  
        </select>
    </div>
    <div class="box-content-input">
        <label for="error_page">Error page</label>
        <select name="error_page" id="error_page">
            <option value="" disabled selected>Select</option>
            <?php
            foreach ( $posts as $post ) {
                echo '<option value="' . esc_attr( $post->ID ) . '" ' . selected( $error_page, $post->ID, false ) . '>' . esc_html( $post->post_title ) . '</option>';
            }
            ?>  
        </select>
    </div>

    

</div>