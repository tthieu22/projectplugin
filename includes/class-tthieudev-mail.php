<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Mail')) {
	class TthieuDev_Mail {
	    public function __construct() {
	        add_action('init', [$this, 'handle_form_submission']);
	    }

	    public function handle_form_submission() {
	        if (isset($_POST['submit_project_form'])) {
	            if (!isset($_POST['project_form_nonce']) || !wp_verify_nonce($_POST['project_form_nonce'], 'submit_project_form')) {
	                wp_die(__('Invalid nonce verification.', 'tthieudev'));
	            }

	            $data = [
	                'first_name'  => sanitize_text_field($_POST['first-name']),
	                'last_name'   => sanitize_text_field($_POST['last-name']),
	                'phone'       => sanitize_text_field($_POST['phone']),
	                'email'       => sanitize_email($_POST['email']),
	                'address'     => sanitize_text_field($_POST['address']),
	                'project_id'  => intval($_POST['project']),
	                'information' => sanitize_textarea_field($_POST['information']),
	            ];
	            $this->handle_email_sending($data);
	        }
	    }
	    

		public function handle_email_sending($data) {
		    $mail_option = get_option('mail_option');
		    $thank_you_page = get_option('thank_you_page', '');
		    $error_page = get_option('error_page', '');
		    $redirect_url = '';
		    $sent = false; 

		    switch ($mail_option) {
		        case 'admin':
		            $sent = $this->send_email_to_admin($data);
		            break;

		        case 'customer':
		            $sent = $this->send_email_to_customer($data);
		            break;

		        case 'both':
		            $sent_admin = $this->send_email_to_admin($data);
		            $sent_customer = $this->send_email_to_customer($data);
		            $sent = $sent_admin && $sent_customer;
			        $sent = true;
		            break;

		        default:
		            error_log('Invalid mail_option value: ' . $mail_option);
		            wp_die(__('An error occurred with the email settings. Please try again later.', 'tthieudev'));
		            return;
		    }

		    if ($sent) {
		        $redirect_url = !empty($thank_you_page) ? get_permalink($thank_you_page) : '';
		        $this->create_order_post($data); 
		    } else {
		        $redirect_url = !empty($error_page) ? get_permalink($error_page) : '';
		    }

		    if ($redirect_url) {
		        wp_safe_redirect($redirect_url);
		        exit;
		    }
		}

		public function create_order_post($data) {
		    $order_number = get_option('project_order_number', 0) + 1;
			$current_time_int = current_time('timestamp');
		    $order_id = wp_insert_post([
		        'post_title'  => '#' . $order_number . ' - ' . $data['first_name'] . ' ' . $data['last_name'],
		        'post_type'   => 'project_order',
		        'post_status' => 'publish',
		        'meta_input'  => [
		            'first_name'   => $data['first_name'],
		            'last_name'    => $data['last_name'],
		            'phone'        => $data['phone'],
		            'email'        => $data['email'],
		            'address'      => $data['address'],
		            'project_id'   => $data['project_id'],
		            'information'  => $data['information'],
		            'status'	   => 'processing',
		            'created_date' => $current_time_int,
		        ],
		    ]);
		    if ($order_id) {
		        update_option('project_order_number', $order_number);
		    } 
		}

		public function send_email_to_admin($data) {
		    $to = get_option('admin_email');
		    
		    $headers = [
		        'Content-Type: text/html; charset=UTF-8'
		    ];
		    add_filter('wp_mail_from', [$this, 'mailer_get_mail_from']);
		    add_filter('wp_mail_from_name', [$this, 'mailer_get_from_name_admin']);
		    
		    $subject = $this->mailer_get_subject_admin($data);
		    
		    $message = $this->generate_email_content_admin($data);
		    $message = nl2br($message);
		    $recipients = $this->mailer_get_recipient();
		    foreach ($recipients as $cc) {
		        $headers[] = 'Cc: ' . $cc;
		    }
		    $sent = wp_mail($to, $subject, $message, $headers);
		    remove_filter('wp_mail_from', [$this, 'mailer_get_mail_from']);
		    remove_filter('wp_mail_from_name', [$this, 'mailer_get_from_name_admin']);
		    return $sent;
		}

		public function send_email_to_customer($data) {
		    $headers = [
		        'Content-Type: text/html; charset=UTF-8'
		    ];

		    add_filter('wp_mail_from', [$this, 'mailer_get_mail_from']);
		    add_filter('wp_mail_from_name', [$this,'mailer_get_from_name_customer'],);

		    $email = is_array($data) ? $data['email'] : $data->email;
		    $subject = $this->mailer_get_subject_customer($data);
		    $message = nl2br($this->generate_email_content_customer($data));

		    $recipients = $this->mailer_get_recipient();
		    foreach ($recipients as $cc) {
		        $headers[] = 'Cc: ' . $cc;
		    }

		    $sent = wp_mail($email, $subject, $message, $headers);
		    remove_filter('wp_mail_from', [$this, 'mailer_get_mail_from']);
		    remove_filter('wp_mail_from_name', [$this,'mailer_get_from_name_customer']);
		    return $sent;
		}	

		public function replace_from_name_placeholders() {
		    $data = [
		        'first_name'  => sanitize_text_field($_POST['first-name']),
		        'last_name'   => sanitize_text_field($_POST['last-name']),
		        'phone'       => sanitize_text_field($_POST['phone']),
		        'email'       => sanitize_email($_POST['email']),
		        'address'     => sanitize_text_field($_POST['address']),
		        'project_id'  => intval($_POST['project']),
		        'information' => sanitize_textarea_field($_POST['information']),
		    ];

		    $placeholders = [
		        '[first_name]' => isset($data['first_name']) ? $data['first_name'] : 'N/A',
		        '[last_name]'  => isset($data['last_name']) ? $data['last_name'] : 'N/A',
		        '[email]'      => isset($data['email']) ? $data['email'] : 'noemail@example.com',
		        '[phone]'      => isset($data['phone']) ? $data['phone'] : '0000000000',
		        '[address]'    => isset($data['address']) ? $data['address'] : 'Unknown',
		        '[project_id]' => isset($data['project_id']) ? $this->generate_project_title($data['project_id']) : 'N/A',
		        '[information]' => isset($data['information']) ? nl2br($data['information']) : 'No additional information provided',
		    ];

		    return $placeholders;
		}

		public function mailer_get_from_name_admin() {
		    $from_name_template = get_option('from_name_admin', __('Order', 'tthieudev'));
		    $placeholders = $this->replace_from_name_placeholders();
		    return strtr($from_name_template, $placeholders);
		}

		public function mailer_get_from_name_customer() {
		    $from_name_template = get_option('from_name_customer', __('Customer Support', 'tthieudev'));
		    $placeholders = $this->replace_from_name_placeholders();
		    return strtr($from_name_template, $placeholders);
		}

		public function generate_project_title($project_id) {
		    $post = get_post($project_id);
		    if ($post) {
		        return esc_html($post->post_title);
		    }
		    return esc_html__('N/A', 'tthieudev');
		}

	    public function get_redirect_url($option_name) {
	        $page_id = get_option($option_name);
	        return $page_id ? get_permalink($page_id) : home_url('/');
	    }

	    public function mailer_get_recipient() {
	        $recipient = get_option('recipient', '');
	        return is_array($recipient) ? array_filter($recipient) : array_map('trim', explode(',', str_replace('|', ',', $recipient)));
	    }

	    public function mailer_get_mail_from() {
	        $send_from = get_option('send_from_email', get_option('admin_email'));
	        if (!$send_from) return get_option('admin_email');
	        return apply_filters('tthieudev_mailer_get_mail_from', $send_from);
	    }
	   	
		public function mailer_get_subject_admin($data) {
		    $subject_admin = get_option('subject_admin', esc_html__('Reminder Pick-up date', 'tthieudev'));

		    $placeholders = [
		        '[first_name]'  => esc_html($data['first_name']),
		        '[last_name]'   => esc_html($data['last_name']),
		        '[phone]'       => esc_html($data['phone']),
		        '[email]'       => esc_html($data['email']),
		        '[address]'     => esc_html($data['address']),
		        '[project_id]'  => $this->generate_project_title($data['project_id']),
		        '[information]' => nl2br(esc_html($data['information'])),
		    ];

		    $subject_admin = str_replace(array_keys($placeholders), array_values($placeholders), $subject_admin);

		    return apply_filters('tthieudev_mailer_get_subject_admin_from', $subject_admin);
		}

		public function mailer_get_subject_customer($data) {
		    $subject_customer = get_option('subject_customer', esc_html__('Reminder Pick-up date', 'tthieudev'));

		    $placeholders = [
		        '[first_name]'  => esc_html($data['first_name']),
		        '[last_name]'   => esc_html($data['last_name']),
		        '[phone]'       => esc_html($data['phone']),
		        '[email]'       => esc_html($data['email']),
		        '[address]'     => esc_html($data['address']),
		        '[project_id]'  => $this->generate_project_title($data['project_id']),
		        '[information]' => nl2br(esc_html($data['information'])),
		    ];

		    $subject_customer = str_replace(array_keys($placeholders), array_values($placeholders), $subject_customer);

		    return apply_filters('tthieudev_mailer_get_subject_customer_from', $subject_customer);
		}

	    public function generate_email_content_admin($data) {
		    $admin_message_template = get_option('message_admin', '');
		    $placeholders = [
		        '[first_name]'  => esc_html($data['first_name']),
		        '[last_name]'   => esc_html($data['last_name']),
		        '[phone]'       => esc_html($data['phone']),
		        '[email]'       => esc_html($data['email']),
		        '[address]'     => esc_html($data['address']),
		        '[project_id]'  => $this->generate_project_link($data['project_id']),
		        '[information]' => nl2br(esc_html($data['information'])),
		    ];

		    return str_replace(array_keys($placeholders), array_values($placeholders), $admin_message_template);
		}

	    public function generate_email_content_customer($data) {
		    $cutomer_message_template = get_option('message_customer', '');
		    $placeholders = [
		        '[first_name]'  => esc_html($data['first_name']),
		        '[last_name]'   => esc_html($data['last_name']),
		        '[phone]'       => esc_html($data['phone']),
		        '[email]'       => esc_html($data['email']),
		        '[address]'     => esc_html($data['address']),
		        '[project_id]'  => $this->generate_project_link($data['project_id']),
		        '[information]' => nl2br(esc_html($data['information'])),
		    ];

		    return str_replace(array_keys($placeholders), array_values($placeholders), $cutomer_message_template);
		}

		public static function send_email_update_order($data) {
		    $mailer = new self();
		    $headers = [
		        'Content-Type: text/html; charset=UTF-8',
		    ];

		    add_filter('wp_mail_from', [$mailer, 'mailer_get_mail_from']); // Gọi qua đối tượng
		    add_filter('wp_mail_from_name', [$mailer, 'mailer_get_from_name_cron']);

		    $email = is_array($data) ? $data['email'] : $data->email;
		    $subject = get_option('subject_mail_cron', 'Remind pick up date');
		    $message = nl2br($mailer->generate_email_content_customer_cron($data));

		    if (is_email($email)) {
		        $mail_sent = wp_mail($email, $subject, $message, $headers);

		        if (!$mail_sent) {
		            error_log("Failed to send email to $email for order ID: " . $data['project_id']);
		        }
		    } else {
		        error_log("Invalid email address: $email for order ID: " . $data['project_id']);
		    }

		    remove_filter('wp_mail_from', [$mailer, 'mailer_get_mail_from']);
		    remove_filter('wp_mail_from_name', [$mailer, 'mailer_get_from_name_cron']);
		}

	    public function mailer_get_from_name_cron() {
	        $from_name = get_option('from_name_cron', esc_html__('Customer Support', 'tthieudev'));
	        return apply_filters('tthieudev_mailer_get_from_name_cron',$from_name);
	    }

	    public static function generate_email_content_customer_cron($data) {
		    $message_template = get_option('message_mail_cron', '');
		    $placeholders = [
		        '[time]'          => is_array($data) ? $data['time'] : $data->time,
		        '[title]'         => is_array($data) ? $data['title'] : $data->title,
		        '[status]'        => is_array($data) ? $data['status'] : $data->status,
		        '[first_name]'    => is_array($data) ? $data['first_name'] : $data->first_name,
		        '[last_name]'     => is_array($data) ? $data['last_name'] : $data->last_name,
		        '[phone]'         => is_array($data) ? $data['phone'] : $data->phone,
		        '[email]'         => is_array($data) ? $data['email'] : $data->email,
		        '[address]'       => is_array($data) ? $data['address'] : $data->address,
		        '[project_id]'    => is_array($data) ? $data['project_id'] : $data->project_id,
		        '[information]'   => is_array($data) ? $data['information'] : $data->information,
		        '[project_link]'  => self::generate_project_link(is_array($data) ? $data['project_id'] : $data->project_id),
		    ];

		    return str_replace(array_keys($placeholders), array_values($placeholders), $message_template);
		}
		
	    public static function generate_project_link($project_id) {
	        $post = get_post($project_id);
	        if ($post) {
	            return '<a href="' . esc_url(get_permalink($post)) . '">' . esc_html($post->post_title) . '</a>';
	        }
	        return esc_html__('N/A', 'tthieudev');
	    }

	    
	}
	return new TthieuDev_Mail();
}