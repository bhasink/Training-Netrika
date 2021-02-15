<?php

function stm_lms_settings_gdpr_section()
{

    $pages = STM_LMS_Settings::stm_get_post_type_array('page');

    return array(
        'name' => esc_html__('GDPR', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'gdpr_warning' => array(
                'type' => 'text',
                'label' => esc_html__('GDPR Label', 'masterstudy-lms-learning-management-system'),
                'value' => 'I agree with storage and handling of my data by this website.',
            ),
            'gdpr_page' => array(
                'type' => 'select',
                'label' => esc_html__('GDPR Privacy Policy Page', 'masterstudy-lms-learning-management-system'),
                'options' => $pages,
            ),
        )
    );
}