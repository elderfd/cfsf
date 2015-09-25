<?php
    add_action("wp_enqueue_scripts", "theme_enqueue_styles");
    function theme_enqueue_styles() {
        wp_enqueue_style("parent-style", get_template_directory_uri()."/style.css");
        wp_enqueue_style("parent-style", get_template_directory_uri()."/rtl.css");
    }

    // Change the default footer
    add_action("wp_loaded", "changeFooter");
    function changeFooter() {
        remove_filter( 'omega_footer_insert', 'omega_default_footer_insert' );
        add_filter( 'omega_footer_insert', 'newFooter' );

        function newFooter( $settings ) {
            return '<p class="copyright">' . __( 'Copyright &#169; ', 'omega' ) . date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '.</p>';
        }
    }

    // Customise buddypress registration form
    add_action("bp_before_account_details_fields", "addExtraRegisterInfo");
    function addExtraRegisterInfo() {
        return "TEST";
    }
?>
