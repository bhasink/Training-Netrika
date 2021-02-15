<?php

use Elementor\Controls_Manager;

class Elementor_STM_Icon_Box extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_icon_box';
    }

    public function get_title()
    {
        return esc_html__('STM Icon Box', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-social-icons';
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
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
				'default' => [
					'url' => '#',
				],
			]
		);

        $this->add_control(
            'title_holder',
            [
                'label' => __('Title Holder', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'hover_pos',
            [
                'label' => __('Hover position', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'plugin-domain'),
                    'top' => esc_html__('Top', 'plugin-domain'),
                    'right' => esc_html__('Right', 'plugin-domain'),
                    'left' => esc_html__('Left', 'plugin-domain'),
                    'bottom' => esc_html__('Bottom', 'plugin-domain'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => __('Box background color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => __('Box text color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'box_icon_bg_color',
            [
                'label' => __('Box icon color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'link_color_style',
            [
                'label' => __('Link color style', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'standart' => esc_html__('Standart', 'plugin-domain'),
                    'dark' => esc_html__('Dark', 'plugin-domain'),
                ],
                'default' => 'standart',
                'description'       => __( 'Enter icon size in px', 'masterstudy' )
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'text-domain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Enter icon size in px', 'masterstudy' ),
                'default' => '60',
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => __('Icon Align', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'left' => esc_html__('Left', 'plugin-domain'),
                    'right' => esc_html__('Right', 'plugin-domain'),
                    'top_left' => esc_html__('Top Left', 'plugin-domain'),
                    'top_center' => esc_html__('Top Center', 'plugin-domain'),
                    'top_right' => esc_html__('Top Right', 'plugin-domain'),
                ],
                'default' => 'left',
            ]
        );

        $this->add_control(
            'icon_height',
            [
                'label' => __('Icon Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Enter icon height in px', 'plugin-domain' ),
                'default' => '65',
            ]
        );

        $this->add_control(
            'icon_width',
            [
                'label' => __('Icon Width', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Enter icon width in px', 'plugin-domain' ),
                'default' => '65',
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'description' => 'Default - White'
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => __( 'Text', 'elementor' ),
                'type' => Controls_Manager::WYSIWYG,
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_icon_css',
            [
                'label' => __('Icon Css', 'elementor-stm-widgets'),
            ]
        );

        $selector = 'icon_box';

        $this->add_responsive_control(
            'margin_'.$selector,
            [
                'label' => __('Margin', 'plugin-domain'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    "{{WRAPPER}} .{$selector}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    "{{WRAPPER}} .{$selector}" => 'margin: 0px 0px 0px 0px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_'.$selector,
            [
                'label' => __('Padding', 'plugin-domain'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    "{{WRAPPER}} .{$selector}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    "{{WRAPPER}} .{$selector}" => 'padding: 0px 0px 0px 0px;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_icon_box ');

    }


    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_icon_box ';

            $settings['unique'] = stm_create_unique_id($settings);

            $settings['css_icon'] = ' masterstudy_elementor_icon ';
            $settings['css_icon_class'] = ' '.$settings['unique'];

            $settings['icon'] = (isset($settings['icon']['value'])) ? ' '.$settings['icon']['value'] : '';

            $settings['atts'] = $settings;

            masterstudy_show_template('icon_box', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
