<?php

add_action('vc_after_init', 'stm_lms_courses_featured_teacher_vc');

function stm_lms_courses_featured_teacher_vc()
{

    $users = array();
    if(is_admin()) {
        $blog_users = get_users( "blog_id={$GLOBALS['blog_id']}" );
        foreach ($blog_users as $user) {
            $name = (!empty($user->data->display_name)) ? $user->data->display_name : $user->data->user_login;
            $users[$name] = $user->ID;
        }
    }

    vc_map(array(
        'name'   => esc_html__('STM LMS Featured Teacher', 'masterstudy-lms-learning-management-system'),
        'base'   => 'stm_lms_featured_teacher',
        'icon'   => 'stm_lms_featured_teacher',
        'description' => esc_html__('Place Single Teacher', 'masterstudy-lms-learning-management-system'),
        'html_template' => STM_LMS_Templates::vc_locate_template('vc_templates/stm_lms_featured_teacher'),
        'php_class_name' => 'WPBakeryShortCode_Stm_Lms_Ms_Featured_Teacher',
        'category' =>array(
            esc_html__('Content', 'masterstudy-lms-learning-management-system'),
        ),
        'params' => array(
            array(
                'type'       => 'dropdown',
                'heading'    => __('Instructor', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'instructor',
                'value'      => $users
            ),
            array(
                'type'       => 'textfield',
                'heading'    => __( 'Instructor Position', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'position',
            ),
            array(
                'type'       => 'textarea',
                'heading'    => __( 'Instructor Bio', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'bio',
            ),
            array(
                'type' => 'attach_image',
                'heading' => __( 'Image', 'masterstudy-lms-learning-management-system' ),
                'param_name' => 'image'
            ),
            array(
                'type'       => 'css_editor',
                'heading'    => esc_html__('Css', 'masterstudy-lms-learning-management-system'),
                'param_name' => 'css',
                'group'      => esc_html__('Design options', 'masterstudy-lms-learning-management-system')
            )
        )
    ));
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Stm_Lms_Ms_Featured_Teacher extends WPBakeryShortCode
    {
    }
}