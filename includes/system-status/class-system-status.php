<?php
/**
 * @author AazzTech
 */
class ATBDP_Status
{

    /**
     * @var \ATBDP_Custom_Url
     */
    public $custom_url;

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'status_menu' ], 60 );

        $this->include();
        $this->custom_url = new ATBDP_Custom_Url();
    }

    public function include(): void {
        include ATBDP_INC_DIR . '/system-status/system-information/system-information.php';
        include ATBDP_INC_DIR . '/system-status/custom-url.php';
    }

     /**
     * Add system status menu page
     */
    public function status_menu(): void {
        add_submenu_page( 'edit.php?post_type=at_biz_dir', __( 'Help & Support', 'directorist' ), __( 'Help & Support', 'directorist' ) , 'manage_options', 'directorist-status', [ $this, 'tools_page' ] );
    }

    public function tools_page(): void {
        include ATBDP_INC_DIR . '/system-status/template.php';
    }

    public function status_page(): void { ?>

        <div class='postbox'>
        <?php
        esc_html_e( 'Help & Support', 'directorist' );
        new ATBDP_System_Info();
       ?>
        </div>

        <div class='postbox'>
        <?php
            $this->custom_url->custom_link();
        ?>
        </div>

        <div class='postbox'>
            <?php
            include ATBDP_INC_DIR . '/system-status/warning.php';
            ?>
        </div>
        <?php
    }

}

new ATBDP_Status();
