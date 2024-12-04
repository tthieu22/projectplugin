<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'TthieuDev_User_Custom_Fields' ) ) {
    class TthieuDev_User_Custom_Fields {

        public function __construct() {
            add_action( 'show_user_profile', array( $this, 'add_custom_user_profile_fields' ) );
            add_action( 'edit_user_profile', array( $this, 'add_custom_user_profile_fields' ) );

            add_action( 'personal_options_update', array( $this, 'save_custom_user_profile_fields' ) );
            add_action( 'edit_user_profile_update', array( $this, 'save_custom_user_profile_fields' ) );
        }

        public function add_custom_user_profile_fields( $user ) {
            ?>
            <h3><?php _e( 'Additional Information', 'textdomain' ); ?></h3>
            <table class="form-table">
                <tr>
                    <th><label for="phone"><?php _e( 'Phone', 'textdomain' ); ?></label></th>
                    <td>
                        <input type="tel" name="phone" id="phone" value="<?php echo esc_attr( get_user_meta( $user->ID, 'phone', true ) ); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="address"><?php _e( 'Address', 'textdomain' ); ?></label></th>
                    <td>
                        <input type="text" name="address" id="address" value="<?php echo esc_attr( get_user_meta( $user->ID, 'address', true ) ); ?>" class="regular-text" />
                    </td>
                </tr>
            </table>
            <?php
        }

        public function save_custom_user_profile_fields( $user_id ) {
            if ( ! current_user_can( 'edit_user', $user_id ) ) {
                return false;
            }
            update_user_meta( $user_id, 'phone', sanitize_text_field( $_POST['phone'] ) );
            update_user_meta( $user_id, 'address', sanitize_text_field( $_POST['address'] ) );
        }
    }
    return new TthieuDev_User_Custom_Fields();
}

