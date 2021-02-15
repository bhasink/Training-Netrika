<?php
function stm_lms_settings_addons_section()
{
    return array(
        'name' => esc_html__('Addons', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'addons' => array(
                'pro' => true,
                'type' => 'addons',
                'label' => esc_html__('Masterstudy LMS PRO Addons', 'masterstudy-lms-learning-management-system'),
            ),
        )
    );
}