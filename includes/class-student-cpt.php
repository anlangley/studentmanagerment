<?php
class Student_CPT {
    public function __construct() {
        add_action('init', [$this, 'register_student_cpt']);
        add_action('add_meta_boxes', [$this, 'add_student_meta_boxes']);
        add_action('save_post', [$this, 'save_student_meta_data']);
    }

    // A. Đăng ký Custom Post Type
    public function register_student_cpt() {
        $labels = [
            'name' => 'Sinh viên',
            'singular_name' => 'Sinh viên',
            'add_new' => 'Thêm sinh viên mới',
            'all_items' => 'Tất cả sinh viên'
        ];
        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-id', // Icon thẻ sinh viên
            'supports' => ['title', 'editor'], // Họ tên và Tiểu sử
        ];
        register_post_type('student', $args);
    }

    // B. Tạo Meta Box
    public function add_student_meta_boxes() {
        add_meta_box('student_details', 'Thông tin chi tiết', [$this, 'render_meta_box_html'], 'student', 'normal', 'high');
    }

    public function render_meta_box_html($post) {
        // Sử dụng Nonce để bảo mật
        wp_nonce_field('save_student_data', 'student_nonce');

        // Lấy dữ liệu cũ (nếu có)
        $mssv = get_post_meta($post->ID, '_student_mssv', true);
        $class = get_post_meta($post->ID, '_student_class', true);
        $dob = get_post_meta($post->ID, '_student_dob', true);
        
        echo '<p><label>MSSV:</label> <input type="text" name="student_mssv" value="'.esc_attr($mssv).'" class="widefat"></p>';
        echo '<p><label>Lớp/Chuyên ngành:</label> 
                <select name="student_class" class="widefat">
                    <option value="CNTT" '.selected($class, 'CNTT', false).'>CNTT</option>
                    <option value="Kinh tế" '.selected($class, 'Kinh tế', false).'>Kinh tế</option>
                    <option value="Marketing" '.selected($class, 'Marketing', false).'>Marketing</option>
                </select></p>';
        echo '<p><label>Ngày sinh:</label> <input type="date" name="student_dob" value="'.esc_attr($dob).'" class="widefat"></p>';
    }

    // C. Xử lý lưu dữ liệu (Sanitize & Security)
    public function save_student_meta_data($post_id) {
        if (!isset($_POST['student_nonce']) || !wp_verify_nonce($_POST['student_nonce'], 'save_student_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['student_mssv'])) update_post_meta($post_id, '_student_mssv', sanitize_text_field($_POST['student_mssv']));
        if (isset($_POST['student_class'])) update_post_meta($post_id, '_student_class', sanitize_text_field($_POST['student_class']));
        if (isset($_POST['student_dob'])) update_post_meta($post_id, '_student_dob', sanitize_text_field($_POST['student_dob']));
    }
}