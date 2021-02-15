<?php
function stm_lms_settings_general_section()
{
    return array(
        'name' => esc_html__('General', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'main_color' => array(
                'type' => 'color',
                'label' => esc_html__('Main color', 'masterstudy-lms-learning-management-system'),
            ),
            'secondary_color' => array(
                'type' => 'color',
                'label' => esc_html__('Secondary color', 'masterstudy-lms-learning-management-system'),
            ),
            'currency_symbol' => array(
                'type' => 'text',
                'label' => esc_html__('Currency symbol', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'currency_position' => array(
                'type' => 'select',
                'label' => esc_html__('Currency Position', 'masterstudy-lms-learning-management-system'),
                'value' => 'left',
                'options' => array(
                    'left' => esc_html__('Left', 'masterstudy-lms-learning-management-system'),
                    'right' => esc_html__('Right', 'masterstudy-lms-learning-management-system'),
                ),
                'columns' => '50'
            ),
            'currency_thousands' => array(
                'type' => 'text',
                'label' => esc_html__('Thousands Separator', 'masterstudy-lms-learning-management-system'),
                'value' => ','
            ),
            'wocommerce_checkout' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable WooCommerce Checkout', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Note, you need to install WooCommerce, and set Cart and Checkout Pages', 'masterstudy-lms-learning-management-system'),
                'pro' => true
            ),
            'guest_checkout' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable Guest Checkout', 'masterstudy-lms-learning-management-system'),
            ),
            'guest_checkout_notice' => array(
                'type' => 'notice_banner',
                'label' => esc_html__('Required to enable guest checkout in WooCommerce', 'masterstudy-lms-learning-management-system'),
                'dependency' => array(
                    array(
                        'key' => 'wocommerce_checkout',
                        'value' => 'not_empty'
                    ),
                    array(
                        'key' => 'guest_checkout',
                        'value' => 'not_empty'
                    ),
                ),
                'dependencies' => '&&'
            ),
            'author_fee' => array(
                'type' => 'number',
                'label' => esc_html__('Admin Commission (%)', 'masterstudy-lms-learning-management-system'),
                'columns' => '50',
                'value' => '10',
                'pro' => true,
                'hint' => esc_html__('% you got from instructors sales', 'masterstudy-lms-learning-management-system'),
            ),
            'courses_featured_num' => array(
                'type' => 'number',
                'label' => esc_html__('Number of free featured', 'masterstudy-lms-learning-management-system'),
                'columns' => '50',
                'value' => 1,
                'pro' => true
            ),
        )
    );
}