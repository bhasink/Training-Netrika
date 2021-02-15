<?php

function stm_lms_settings_route_section()
{
    return array(
        'name' => esc_html__('Routes', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'user_url' => array(
                'type' => 'text',
                'label' => esc_html__('User Private Base Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-user', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'user_url_profile' => array(
                'type' => 'text',
                'label' => esc_html__('User Public Base Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-user_profile', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'certificate_url' => array(
                'type' => 'text',
                'label' => esc_html__('Certificates Base Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-certificates', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'login_url' => array(
                'type' => 'text',
                'label' => esc_html__('Login Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-login', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'chat_url' => array(
                'type' => 'text',
                'label' => esc_html__('Chat Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-chats', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'wishlist_url' => array(
                'type' => 'text',
                'label' => esc_html__('Wishlist Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-wishlist', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
            'checkout_url' => array(
                'type' => 'text',
                'label' => esc_html__('Checkout Url', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Default is /lms-checkout', 'masterstudy-lms-learning-management-system'),
                'columns' => '50'
            ),
        )
    );
}