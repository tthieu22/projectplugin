<?php defined( 'ABSPATH' ) || exit; 

$mail_option = get_option('mail_option', 'both');
?>

<div id="Mailer" class="wrapper-setting city">
    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="mailer-settings-form">
        <input type="hidden" name="action" value="save_project_settings">
        <?php wp_nonce_field('save_project_settings', 'project_settings_nonce'); ?>
        <div class="wrapper-mail-setting" >
            <h3>Email Setting</h3>
            <div class="box-hearder-content">
            	<strong>Send email to </strong>
            	<div class="box-radio">
	                <input type="radio" id="admin" name="mail_option" value="admin" <?php checked($mail_option, 'admin'); ?> />
	                <label for="admin">Admin</label>
            	</div>
            	<div class="box-radio">
	                <input type="radio" id="customer" name="mail_option" value="customer" <?php checked($mail_option, 'customer'); ?> />
	                <label for="customer">Customer</label>
            	</div>
            	<div class="box-radio">
	                <input type="radio" id="both" name="mail_option" value="both" <?php checked($mail_option, 'both'); ?> />
	                <label for="both">Both</label>
            	</div>
            </div>
            <hr>
            <div class="content-wrapper-all">
                <?php tthieudev_get_template('forms/form-mailer-setting-both.php'); ?>
                <input type="submit" name="submit_email_settings" value="Save">
            </div>
        </div>
    </form>
</div>
