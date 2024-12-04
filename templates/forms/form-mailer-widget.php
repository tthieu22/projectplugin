<?php defined( 'ABSPATH' ) || exit; 

$admin_email = get_option('admin_email'); 
$args = array(
    'post_type'      => 'project', 
    'posts_per_page' => -1,   
    'orderby'        => 'title',
    'order'          => 'ASC',
);
$posts = get_posts($args);
?>
<div class="wrapper-mailer-project">
    <form method="POST">
        <?php wp_nonce_field( 'submit_project_form', 'project_form_nonce' ); ?>
        <div class="box-input">
            <div class="input-content">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" placeholder="First name" required>
            </div>
            <div class="input-content">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" placeholder="Last name" required>
            </div>
        </div>

        <div class="box-input">
            <div class="input-content">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" placeholder="(000) 000-0000" required>
            </div>
            <div class="input-content">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your email" required>
            </div>
        </div>

        <div class="box-input">
            <div class="input-content">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Your address" required>
            </div>
            <div class="input-content">
                <label for="project">Project</label>
                <select name="project" id="project" required>
                    <option value="" disabled selected>Select</option>
                    <?php
                    foreach ( $posts as $post ) {
                        echo '<option value="' . esc_attr( $post->ID ) . '">' . esc_html( $post->post_title ) . '</option>';
                    }
                    ?>  
                </select>
            </div>
        </div>

        <div class="box-input">
            <div class="input-content">
                <label for="information">Additional information</label>
                <textarea name="information" id="information" rows="7" placeholder="Write additional information here"></textarea>
            </div>
        </div>

        <div class="box-input">
            <input type="submit" name="submit_project_form" value="Submit">
        </div>
    </form>
</div>