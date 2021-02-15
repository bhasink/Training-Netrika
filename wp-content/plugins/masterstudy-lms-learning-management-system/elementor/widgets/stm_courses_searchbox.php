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
class StmCoursesSearchbox extends Widget_Base
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
        return 'stm_courses_searchbox';
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
        return __( 'STM Courses Search box', 'masterstudy-lms-learning-management-system' );
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
        return 'fas fa-search';
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

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'masterstudy-lms-learning-management-system' ),
            ]
        );
        $this->add_control(
            'style',
            [
                'name' => 'style',
                'label' => __( 'Style', 'masterstudy-lms-learning-management-system' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'options' => array(
                    'style_1' => __( 'Style 1', 'masterstudy-lms-learning-management-system' ),
                    'style_2' => __( 'Style 2', 'masterstudy-lms-learning-management-system' ),
                ),
                'default' => 'style_1'
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
            'style' => !empty($settings['style']) ? $settings['style'] : 'style_1'
        );
        \STM_LMS_Templates::show_lms_template('vc_templates/templates/stm_courses_searchbox', $atts);
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



