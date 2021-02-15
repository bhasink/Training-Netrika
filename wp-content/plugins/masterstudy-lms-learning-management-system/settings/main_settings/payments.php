<?php

function stm_lms_settings_payments_section()
{
    return array(
        'name' => esc_html__('Payment Methods', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'payment_methods' => array(
                'type' => 'payments',
                'label' => esc_html__('Payment Methods', 'masterstudy-lms-learning-management-system'),
            ),
        )
    );
}