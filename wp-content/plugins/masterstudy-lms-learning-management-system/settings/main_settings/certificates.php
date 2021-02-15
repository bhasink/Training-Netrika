<?php

function stm_lms_settings_certificates_section()
{
    return array(
        'name' => esc_html__('Certificates', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'certificate_threshold' => array(
                'type' => 'number',
                'pro' => true,
                'label' => esc_html__('Certificate threshold (%)', 'masterstudy-lms-learning-management-system'),
                'value' => 70
            ),
            'certificate_banner' => array(
                'type' => 'stm_lms_certificate_banner',
            ),
            'certificate_settings_title' => array(
                'group' => 'started',
                'type' => 'notice',
                'label' => esc_html__('Certificate Settings', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_image' => array(
                'pro' => true,
                'type' => 'image',
                'label' => esc_html__('Certificate Image', 'masterstudy-lms-learning-management-system'),
            ),
            /*TITLE*/
            'certificate_title_notice' => array(
                'type' => 'notice',
                'label' => esc_html__('Certificate Title Settings', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_title' => array(
                'pro' => true,
                'type' => 'text',
                'label' => esc_html__('Certificate Title', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_title_color' => array(
                'type' => 'color',
                'pro' => true,
                'label' => esc_html__('Certificate title color', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_title_fsz' => array(
                'type' => 'number',
                'pro' => true,
                'label' => esc_html__('Certificate title font size (px)', 'masterstudy-lms-learning-management-system'),
                'value' => 60
            ),
            /*SUBTITLE*/
            'certificate_subtitle_notice' => array(
                'type' => 'notice',
                'label' => esc_html__('Certificate Subtitle Settings', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_subtitle' => array(
                'pro' => true,
                'type' => 'text',
                'label' => esc_html__('Certificate subtitle', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_subtitle_color' => array(
                'type' => 'color',
                'pro' => true,
                'label' => esc_html__('Certificate subtitle color', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_subtitle_fsz' => array(
                'type' => 'number',
                'pro' => true,
                'label' => esc_html__('Certificate subtitle font size (px)', 'masterstudy-lms-learning-management-system'),
                'value' => 40
            ),
            /*TEXT*/
            'certificate_text_notice' => array(
                'type' => 'notice',
                'label' => esc_html__('Certificate Text Settings', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_text' => array(
                'pro' => true,
                'type' => 'textarea',
                'label' => esc_html__('Certificate Text', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__(
                    'Available shortcodes: Username - {username}; Course name - {course}; User First name - {user_first_name}; User Last name - {user_last_name}',
                    'masterstudy-lms-learning-management-system'),
            ),
            'certificate_text_color' => array(
                'type' => 'color',
                'pro' => true,
                'label' => esc_html__('Certificate text color', 'masterstudy-lms-learning-management-system'),
            ),
            'certificate_text_fsz' => array(
                'group' => 'ended',
                'type' => 'number',
                'pro' => true,
                'label' => esc_html__('Certificate text font size (px)', 'masterstudy-lms-learning-management-system'),
                'value' => 17
            ),
        )
    );
}