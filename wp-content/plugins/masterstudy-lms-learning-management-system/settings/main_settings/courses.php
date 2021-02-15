<?php

function stm_lms_settings_courses_section()
{

    $pages = STM_LMS_Settings::stm_get_post_type_array('page');

    return array(
        'name' => esc_html__('Courses', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'demo_import' => array(
                'type' => 'demo_import',
            ),
            'courses_page' => array(
                'type' => 'select',
                'label' => esc_html__('Courses Page', 'masterstudy-lms-learning-management-system'),
                'options' => $pages,
            ),
            'courses_view' => array(
                'type' => 'select',
                'label' => esc_html__('Courses Page Layout', 'masterstudy-lms-learning-management-system'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'masterstudy-lms-learning-management-system'),
                    'list' => esc_html__('List', 'masterstudy-lms-learning-management-system'),
                ),
                'value' => 'grid',
                'columns' => '50'
            ),
            'courses_per_page' => array(
                'type' => 'number',
                'label' => esc_html__('Courses per page', 'masterstudy-lms-learning-management-system'),
                'value' => '9',
                'columns' => '50'
            ),
            'courses_per_row' => array(
                'type' => 'select',
                'label' => esc_html__('Courses per row', 'masterstudy-lms-learning-management-system'),
                'options' => array(
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '6' => 6,
                ),
                'value' => '4',
                'columns' => '50'
            ),
            'course_card_view' => array(
                'type' => 'select',
                'label' => esc_html__('Course Card Info', 'masterstudy-lms-learning-management-system'),
                'options' => array(
                    'center' => esc_html__('Center', 'masterstudy-lms-learning-management-system'),
                    'right' => esc_html__('Right', 'masterstudy-lms-learning-management-system'),
                ),
                'value' => 'center',
                'columns' => '50'
            ),
            'course_card_style' => array(
                'type' => 'select',
                'label' => esc_html__('Course Card Style', 'masterstudy-lms-learning-management-system'),
                'options' => array(
                    'style_1' => esc_html__('Style 1', 'masterstudy-lms-learning-management-system'),
                    'style_2' => esc_html__('Style 2', 'masterstudy-lms-learning-management-system'),
                ),
                'value' => 'style_1',
                'columns' => '50'
            ),
            'courses_categories_slug' => array(
                'type' => 'text',
                'label' => esc_html__('Category parent slug', 'masterstudy-lms-learning-management-system'),
                'value' => 'stm_lms_course_category',
                'hint' => esc_html__('Slug in url before category', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'courses_image_size' => array(
                'type' => 'text',
                'label' => esc_html__('Courses Image Size', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Ex.: 200x100', 'masterstudy-lms-learning-management-system'),
                'value' => '',
                'columns' => '50'
            ),
            'load_more_type' => array(
                'type' => 'select',
                'label' => esc_html__('Load More Type', 'masterstudy-lms-learning-management-system'),
                'options' => array(
                    'button' => esc_html__('Button', 'masterstudy-lms-learning-management-system'),
                    'infinite' => esc_html__('Infinite Scrolling', 'masterstudy-lms-learning-management-system'),
                ),
                'value' => 'button',
                'columns' => '50'
            ),
            'disable_lazyload' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Disable Lazyload', 'masterstudy-lms-learning-management-system'),
            ),
            'enable_courses_filter' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable Archive Filter', 'masterstudy-lms-learning-management-system'),
            ),
            'enable_courses_filter_notice' => array(
                'type' => 'notice',
                'label' => esc_html__('With enabled filters, default courses per row will be 3 with adaptive settings for best look.', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
            ),
            'enable_courses_filter_category' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Category', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
            'enable_courses_filter_subcategory' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Subcategory', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
            'enable_courses_filter_levels' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Levels', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
            'enable_courses_filter_rating' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Rating', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
            'enable_courses_filter_status' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Status', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
            'enable_courses_filter_instructor' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Instructor', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
            'enable_courses_filter_price' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable filter - Price', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    'key' => 'enable_courses_filter',
                    'value' => 'not_empty'
                ),
                'columns' => '50',
            ),
        )
    );
}