<?php defined( 'ABSPATH' ) || exit; ?>

<div class="setting-project-wrapper">
    <h1 class="m-0">Project Settings</h1><br><br>
    <div class="tab-setting-control">
        <button class="w3-button" data-city="Single">Single</button>
        <button class="w3-button" data-city="Archive">Archive</button>
        <button class="w3-button" data-city="Mailer">Mail</button>
        <button class="w3-button" data-city="Cron">Cron</button>
    </div>
    <?php tthieudev_get_template('forms/form-setting-single.php' ); ?> 
    <?php tthieudev_get_template('forms/form-setting-archive.php' ); ?> 
    <?php tthieudev_get_template('forms/form-mailer-setting.php' ); ?> 
    <?php tthieudev_get_template('forms/form-cron-setting.php' ); ?> 

</div>
