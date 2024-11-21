<?php 
defined("ABSPATH") or die("You can not access directly");
?>
<!-- Form cho Archive Settings -->

<div id="Archive" class="wrapper-setting city" style="display:none">
    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="save_project_settings">
        <?php wp_nonce_field('save_project_settings', 'project_settings_nonce'); ?>
        <div class="w3-container" >
            <h3>Archive Setting</h3><br>
                <div class="box-check-item">
                    <input type="checkbox" value="1" id="checked-show-pagination" name="checked-show-pagination" 
                        <?php if (get_option('checked-show-pagination') == '1') echo 'checked'; ?>>
                    <label for="checked-show-pagination">Show Pagination</label><br><br>

                    <input type="checkbox" value="1" id="checked-show-title-archive" name="checked-show-title-archive" 
                        <?php if (get_option('checked-show-title-archive') == '1') echo 'checked'; ?>>
                    <label for="checked-show-title-archive">Show Title</label><br><br>

                    <input type="checkbox" value="1" id="checked-show-category-archive" name="checked-show-category-archive" 
                        <?php if (get_option('checked-show-category-archive') == '1') echo 'checked'; ?>>
                    <label for="checked-show-category-archive">Show Category</label><br><br>

                    <input type="checkbox" value="1" id="checked-show-tag-archive" name="checked-show-tag-archive" 
                        <?php if (get_option('checked-show-tag-archive') == '1') echo 'checked'; ?>>
                    <label for="checked-show-tag-archive">Show Tag</label><br><br>

                    <label for="page-number">Posts per Archive Page</label>
    				<input type="number" 
    			       value="<?php echo get_option('page-number', 3); ?>" 
    			       id="page-number" 
    			       name="page-number"
    			       max="<?php $total_posts = wp_count_posts('project')->publish; echo $total_posts; ?>"
    			       min=1><br><br>
                </div>
            <input type="submit" name="submit_archive_settings" value="Save">
        </div>
    </form>
</div>
