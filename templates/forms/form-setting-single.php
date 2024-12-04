<?php defined( 'ABSPATH' ) || exit; ?>

<div id="Single" class="wrapper-setting city ">
    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="save_project_settings">
        <?php wp_nonce_field('save_project_settings', 'project_settings_nonce'); ?>
        <div  class="w3-container ">
            <h3>Single Setting</h3><br>
            <div class="box-check-item">
                <input type="checkbox" value="1" id="checked-show-category-single" name="checked-show-category-single" 
                    <?php if (get_option('checked-show-category-single') == '1') echo 'checked'; ?>>
                <label for="checked-show-category-single">Show Categories</label><br><br>

                <input type="checkbox" value="1" id="checked-show-tag-single" name="checked-show-tag-single" 
                    <?php if (get_option('checked-show-tag-single') == '1') echo 'checked'; ?>>
                <label for="checked-show-tag-single">Show Tags</label><br><br>

                <input type="checkbox" value="1" id="checked-show-sub-title" name="checked-show-sub-title" 
                    <?php if (get_option('checked-show-sub-title') == '1') echo 'checked'; ?>>
                <label for="checked-show-sub-title">Show Sub Title</label><br><br>

                <input type="checkbox" value="1" id="checked-show-client" name="checked-show-client" 
                    <?php if (get_option('checked-show-client') == '1') echo 'checked'; ?>>
                <label for="checked-show-client">Show Client</label><br><br>

                <input type="checkbox" value="1" id="checked-show-date" name="checked-show-date" 
                    <?php if (get_option('checked-show-date') == '1') echo 'checked'; ?>>
                <label for="checked-show-date">Show Date</label><br><br>

                <input type="checkbox" value="1" id="checked-show-value" name="checked-show-value" 
                    <?php if (get_option('checked-show-value') == '1') echo 'checked'; ?>>
                <label for="checked-show-value">Show Value</label><br><br>

                <input type="checkbox" value="1" id="checked-show-image" name="checked-show-image" 
                    <?php if (get_option('checked-show-image') == '1') echo 'checked'; ?>>
                <label for="checked-show-image">Show Image</label><br><br>
            </div>
            <input type="submit" name="submit_single_settings" value="Save">
        </div>
    </form>
</div>
