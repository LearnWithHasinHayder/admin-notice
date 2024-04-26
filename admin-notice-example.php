<?php
/*
Plugin Name: Admin Notice Example
Description: Add an admin notice
Version: 1.0
*/

class Admin_Notice {

    public function __construct() {
        add_action('init', [$this, 'init']);
    }

    function init() {
        add_action('admin_notices', [$this, 'admin_notice']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('wp_ajax_admin_notice_dismiss', [$this, 'admin_notice_dismiss']);
    }

    function admin_notice() {
        global $pagenow;
        $current_screen = get_current_screen();
        $is_dismissed = get_option('admin_notice_dismiss', false);

        // echo '<div class="notice">
        //     <p>Admin Notice</p>
        // </div>';
        // if ($pagenow == 'index.php' || $pagenow == 'edit-comments.php') {
        // if ($current_screen->id == 'dashboard' || $current_screen->id == 'edit-comments') {
        if (!$is_dismissed) {
            ?>
            <div class="admin-notice-exclusive notice notice-success is-dismissible">
                <p>Admin Notice On - <?php echo $pagenow ?> | <?php echo $current_screen->id ?></p>
                <!-- <p>
                    <img src="https://media.istockphoto.com/id/1433204569/photo/work-office-interior-with-screen-for-teleconference-and-teleworking-teamwork-and-remote-work.webp?b=1&s=170667a&w=0&k=20&c=AIZnyQo00NxRRGQuyAK7hjUxsVSXwz02OyuW3nqROe4=" alt="">
                </p> -->
            </div>
            <?php
        }
    }

    function admin_enqueue_scripts() {
        $ajax_url = admin_url('admin-ajax.php');
        $nonce = wp_create_nonce('admin-notice-nonce');
        wp_enqueue_style('admin-notice-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script('admin-notice-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], '1.0', true);
        wp_localize_script('admin-notice-script', 'admin_notice', [
            'ajax_url' => $ajax_url,
            'nonce' => $nonce
        ]);
    }

    function admin_notice_dismiss() {
        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'admin-notice-nonce')) {
            update_option('admin_notice_dismiss', true);
        }
        wp_die();
    }


}
new Admin_Notice();
