<?php
class Student_Shortcode {
    public function __construct() {
        add_shortcode('danh_sach_sinh_vien', [$this, 'display_student_list']);
    }

    public function display_student_list() {
        $args = [
            'post_type' => 'student',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ];
        $query = new WP_Query($args);

        if (!$query->have_posts()) return 'Chưa có sinh viên nào.';

        $output = '<table border="1" style="width:100%; border-collapse: collapse; text-align: left;">';
        $output .= '<thead><tr style="background: #f2f2f2;"><th>STT</th><th>MSSV</th><th>Họ tên</th><th>Lớp</th><th>Ngày sinh</th></tr></thead><tbody>';

        $stt = 1;
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            $output .= '<tr>';
            $output .= '<td>' . $stt++ . '</td>';
            $output .= '<td>' . get_post_meta($id, '_student_mssv', true) . '</td>';
            $output .= '<td>' . get_the_title() . '</td>';
            $output .= '<td>' . get_post_meta($id, '_student_class', true) . '</td>';
            $output .= '<td>' . get_post_meta($id, '_student_dob', true) . '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody></table>';

        wp_reset_postdata();
        return $output;
    }
}