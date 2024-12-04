<?php defined( 'ABSPATH' ) || exit; ?>
<html>
    <head>
        <style>
            body {
                font-family: 'Times New Roman', Georgia, serif !important;
            }
        </style>
    </head>
    <body>
        <div class='email-content'>
            Hello <?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?>,<br><br>
            Thank you for submitting your project details. We have received your information and will get back to you shortly.<br><br>
            <strong>Details:</strong><br>
            <strong>Phone:</strong> <?php echo esc_html($phone); ?><br>
            <strong>Email:</strong> <?php echo esc_html($email); ?><br>
            <strong>Address:</strong> <?php echo esc_html($address); ?><br>
            <strong>Project:</strong> <a href='<?php echo esc_url(get_permalink($project_id)); ?>'><?php echo esc_html(get_the_title($project_id)); ?></a><br>
            <strong>Additional Information:</strong> <?php echo esc_html($information); ?>
        </div>
    </body>
</html>
