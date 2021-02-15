<?php

use Elementor\Controls_Manager;

class Elementor_STM_Stats_Counter extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_stats_counter';
    }

    public function get_title()
    {
        return esc_html__('STM Stats Counter', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-area-chart';
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
            'title',
            [
                'label' => __( 'Title', 'plugin-domain' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'counter_value',
            [
                'label' => __( 'Counter Value', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '1000',
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => __( 'Duration', 'plugin-domain' ),
                'type' => Controls_Manager::TEXT,
                'default' => '2.5',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '65',
                'description' => __( 'Enter icon size in px', 'plugin-domain' ),
            ]
        );

        $this->add_control(
            'icon_height',
            [
                'label' => __( 'Icon Height', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '90',
                'description' => __( 'Enter icon height in px', 'plugin-domain' ),
            ]
        );

        $this->add_control(
            'icon_text_alignment',
            [
                'label' => __( 'Text alignment', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => __( 'Left', 'plugin-domain' ),
                    'right' => __( 'Right', 'plugin-domain' ),
                    'center' => __( 'Center', 'plugin-domain' ),
                ],
                'default' => 'left',
                'description' => __( 'Text alignment in block', 'plugin-domain' )
            ]
        );

        $this->add_control(
            'icon_text_color',
            [
                'label' => __('Text color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'description' => __( 'Text color(white - default)', 'plugin-domain' ),
                'default' => 'white',
            ]
        );

        $this->add_control(
            'text_font_size',
            [
                'label' => __( 'Text font size (px)', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
            ]
        );

        $this->add_control(
            'counter_text_color',
            [
                'label' => __('Counter text color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'description' => __( 'Counter Text color(yellow - default)', 'plugin-domain' )
            ]
        );

        $this->add_control(
            'counter_text_font_size',
            [
                'label' => __( 'Counter text font size (px)', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
            ]
        );

        $this->add_control(
            'border',
            [
                'label' => __( 'Include Border', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => __( 'None', 'plugin-domain' ),
                    'right' => __( 'Right', 'plugin-domain' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_stats_counter_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_stats_counter_';

            $settings['id'] = 'counter_' . stm_create_unique_id($settings);

            $settings['icon'] = (isset($settings['icon']['value'])) ? ' '.$settings['icon']['value'] : '';

            masterstudy_show_template('stats_counter', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
