<?php

namespace StmLmsElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class StmLmsFeaturedTeacher extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'stm_lms_featured_teacher';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __( 'STM LMS Featured Teacher', 'masterstudy-lms-learning-management-system' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-graduation-cap';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return [ 'theme-elements' ];
    }

    protected function _register_controls()
    {
        $users = array();
        if(is_admin()) {
            $blog_users = get_users( "blog_id={$GLOBALS['blog_id']}" );
            foreach ($blog_users as $user) {
                $name = (!empty($user->data->display_name)) ? $user->data->display_name : $user->data->user_login;
                $users[$user->ID] = $name;
            }
        }

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'masterstudy-lms-learning-management-system' ),
            ]
        );
        $this->add_control(
            'instructor',
            [
                'name' => 'instructor',
                'label' => __( 'Instructor', 'masterstudy-lms-learning-management-system' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'options' => $users,
            ]
        );

        $this->add_control(
            'position',
            [
                'name' => 'position',
                'label' => __( 'Instructor Position', 'masterstudy-lms-learning-management-system' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'bio',
            [
                'name' => 'bio',
                'label' => __( 'Instructor Bio', 'masterstudy-lms-learning-management-system' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'image',
            [
                'name' => 'image',
                'label' => __( 'Image', 'masterstudy-lms-learning-management-system' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $atts = array(
            'css' => '',
            'instructor' => !empty($settings['instructor']) ? $settings['instructor'] : '',
            'position' => !empty($settings['position']) ? $settings['position'] : '',
            'bio' => !empty($settings['bio']) ? $settings['bio'] : '',
            'image' => !empty($settings['image']['id']) ? $settings['image']['id'] : '',
        );
        \STM_LMS_Templates::show_lms_template('vc_templates/templates/stm_lms_featured_teacher', $atts);
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template()
    {

    }
}



