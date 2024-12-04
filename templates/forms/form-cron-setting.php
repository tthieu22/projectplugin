<?php defined( 'ABSPATH' ) || exit; 
$cron_enable = get_option('cron_enable', '');
$message_mail_cron = get_option('message_mail_cron', '');
?>
<div id="Cron" class="wrapper-setting city">
    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="save_project_settings">
        <?php wp_nonce_field('save_project_settings', 'project_settings_nonce'); ?>
        <div class="w3-container">
            <h3>Reminder of pick-up date</h3><br>
            <div class="wrapper-cron-setting">
                <div class="box-cron-item">
                    <label for="cron_enable">Enable</label>
                    <div class="imput-description">
                        <input type="checkbox" value="1" id="cron_enable" name="cron_enable" <?php checked($cron_enable, '1'); ?>>
                        <label for="cron_enable" class="cursor-pointer-span">Allow to send mail to customer</label>
                    </div>
                </div>

                <div class="box-cron-item">
                    <label for="x_day_pick_up">X day before pick up date</label>
                    <div class="imput-description">
                        <input type="number" class="input-cron" id="x_day_pick_up" name="x_day_pick_up" value="<?php echo esc_attr(get_option('x_day_pick_up', '')); ?>">
                    </div>
                </div>

                <div class="box-cron-item">
                    <label for="recurring_email_every_x_seconds">Send a recurring email every X seconds after the initial one.</label>
                    <div class="imput-description">
                        <input type="number" class="input-cron" id="recurring_email_every_x_seconds" name="recurring_email_every_x_seconds" value="<?php echo esc_attr(get_option('recurring_email_every_x_seconds', '')); ?>">
                    </div>
                </div>

                <div class="box-cron-item">
                    <label for="subject_mail_cron">Subject</label>
                    <div class="imput-description">
                        <input type="text" class="input-cron" id="subject_mail_cron" name="subject_mail_cron" value="<?php echo esc_attr(get_option('subject_mail_cron', '')); ?>">
                        <span>The subject displayed in the email list</span>
                    </div>
                </div>

                <div class="box-cron-item">
                    <label for="from_name_cron">From name</label>
                    <div class="imput-description">
                        <input type="text" class="input-cron" id="from_name_cron" name="from_name_cron" value="<?php echo esc_attr(get_option('from_name_cron', '')); ?>">
                        <span>The name displayed in the email detail</span>
                    </div>
                </div>

                <div class="box-cron-item">
                    <label for="send_from_email">Send from email</label>
                    <div class="imput-description">
                        <input type="email" class="input-cron" id="send_from_email" name="send_from_email" value="<?php echo esc_attr(get_option('send_from_email', get_option('admin_email'))); ?>">
                        <span>The customer will know from which email address the mail is sent</span>
                    </div>
                </div>

                <div class="box-cron-item">
                    <label for="email_content_cron">Email content<br><span>Use tags to generate email template.<br>[title]: Title post,<br> [time]: Time create post,<br> [status]: Status,<br> [first_name]: First name,<br>[last_name]: Last name,<br>[phone]: Phone,<br>[email]: Email,<br>[address]: Address,<br>[project_id]: ID Project,<br>[information]: Information<br> [project_link]: Project 
                    </span></label>

                    <div class="imput-description">
                        <?php 
                            wp_editor( 
                                 $message_mail_cron, 
                                 'message_mail_cron', 
                                 array(
                                     'wpautop'       => true,
                                     'media_buttons' => true,
                                     'textarea_name' => 'message_mail_cron',
                                     'editor_class'  => 'project-description-textarea-admin',
                                     'textarea_rows' => 15,
                                     'placeholder' => 'Project Description WP Editor Default 2 Admin'
                                 ) 
                            );
                        ?><br>
                        <input type="submit" name="submit_cron_project_settings" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
