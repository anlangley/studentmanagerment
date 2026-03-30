<?php
/**
 * Plugin Name: Student Manager
 * Description: Quản lý thông tin sinh viên với CPT và Shortcode.
 * Version: 1.0
 * Author: [Tên của bạn]
 */

// Ngăn chặn truy cập trực tiếp vào file
if (!defined('ABSPATH')) exit;

// Định nghĩa hằng số đường dẫn
define('SM_PATH', plugin_dir_path(__FILE__));

// Import các file xử lý logic
require_once SM_PATH . 'includes/class-student-cpt.php';
require_once SM_PATH . 'includes/class-student-shortcode.php';

// Khởi tạo các class
new Student_CPT();
new Student_Shortcode();