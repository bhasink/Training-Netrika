<?php

use Elementor\Controls_Manager;

class Elementor_STM_Experts extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_experts';
    }

    public function get_title()
    {
        return esc_html__('STM Experts', 'masterstudy-elementor-widgets');
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
            'experts_title',
            [
                'label' => __('Section title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Section Title here', 'plugin-domain'),
                'description' => __( "Title will be shown on the top of section", 'masterstudy' ),
            ]
        );

        $this->add_control(
            'experts_max_num',
            [
                'label' => __('Number of Teachers to output', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Type Number of Teachers here', 'plugin-domain'),
                'description' => __('Fill field with number only', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'experts_output_style',
            [
                'label' => __('Style', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'experts_carousel' => 'Carousel',
					'experts_list' => 'List'
                ],
                'default' => 'experts_carousel',
            ]
        );

        $this->add_control(
            'experts_all',
            [
                'label' => __('All teachers', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'yes' => 'Show link to all Teachers',
					'no' => 'Hide link to all Teachers'
                ],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'expert_slides_per_row',
            [
                'label' => __('Number of Teachers per row', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
					2 => '2',
                ],
                'default' => 1,
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_experts_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_experts_';

            masterstudy_show_template('experts', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
