<?php

function stm_lms_settings_payout_section()
{
    return array(
        'name' => esc_html__('Payout', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'payout' => array(
                'pro' => true,
                'type' => 'payout',
                'label' => esc_html__('Masterstudy LMS PRO Payout', 'masterstudy-lms-learning-management-system'),
            ),
        )
    );
}