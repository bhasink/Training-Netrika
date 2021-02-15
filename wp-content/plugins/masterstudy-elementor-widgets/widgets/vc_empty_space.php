<?php

use Elementor\Controls_Manager;

class Elementor_STM_Empty_Space extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_empty_space';
    }

    public function get_title()
    {
        return esc_html__('STM Empty Space', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-arrows-v';
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
                'label' => __('Content', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => __('Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '32',
                'description' => 'Height in px'
            ]
        );

        $this->add_control(
            'el_id',
            [
                'label' => __('Element ID', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
            ]
        );

        $this->add_control(
            'el_class',
            [
                'label' => __('Extra class name', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'laptop_height',
            [
                'label' => __('Laptop Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
            ]
        );

        $this->add_control(
            'tablet_height',
            [
                'label' => __('Tablet Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
            ]
        );

        $this->add_control(
            'mobile_height',
            [
                'label' => __('Mobile Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_testimonials_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $wrapper_attributes = array();
            if ( ! empty( $settings['el_id'] ) ) {
            	$wrapper_attributes[] = 'id="' . esc_attr( $settings['el_id'] ) . '"';
            }

            $height = floatval($settings['height']);

            $settings['inline_css'] = ( (float) $height >= 0.0 ) ? ' style="height: ' . esc_attr( $height ) . 'px"' : '';

            $settings['wrapper_attributes'] = $wrapper_attributes;

            $settings['uniq'] = stm_create_unique_id($settings);

            $settings['css_class'] = ' masterstudy_elementor_empty_space '.$settings['uniq'];

            $settings['atts'] = $settings;

            masterstudy_show_template('vc_empty_space', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
