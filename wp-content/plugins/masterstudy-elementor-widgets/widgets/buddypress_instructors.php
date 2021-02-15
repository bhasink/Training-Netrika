<?php

use Elementor\Controls_Manager;

class Elementor_STM_Buddypress_Instructors extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_buddypress_instructors';
    }

    public function get_title()
    {
        return esc_html__('STM Buddypress Instructors', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-users';
    }

    public function get_categories()
    {
        return ['theme-elements'];
    }

    public function add_dimensions($selector = '')
    {
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'elementor-stm-widgets'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Title here', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Subtitle here', 'plugin-domain'),
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_buddypress_instructors_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_buddypress_instructors_';

            masterstudy_show_template('buddypress_instructors', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
