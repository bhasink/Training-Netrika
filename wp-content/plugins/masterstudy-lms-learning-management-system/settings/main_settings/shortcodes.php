<?php

function stm_lms_settings_shortcodes_section()
{
    return array(
        'name' => esc_html__('Shortcodes', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'stm_lms_shortcodes' => array(
                'type' => 'stm_lms_shortcodes',
            ),
        )
    );
}