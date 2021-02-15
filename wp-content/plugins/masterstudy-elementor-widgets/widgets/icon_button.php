<?php

use Elementor\Controls_Manager;

class Elementor_STM_Icon_Button extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_icon_button';
    }

    public function get_title()
    {
        return esc_html__('STM Icon Button', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-button';
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
            'button_text',
            [
                'label' => __('Button Text', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
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
            'link_tooltip',
            [
                'label' => __('Link tooltip (title)', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'btn_align',
            [
                'label' => __('Button alignment', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'center' => esc_html__('Center', 'plugin-domain'),
                    'left' => esc_html__('Left', 'plugin-domain'),
                    'right' => esc_html__('Right', 'plugin-domain'),
                ],
                'default' => 'left',
            ]
        );

        $this->add_control(
            'btn_size',
            [
                'label' => __('Button Size', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'btn-sm' => esc_html__('Small', 'plugin-domain'),
                    'btn-normal-size' => esc_html__('Normal', 'plugin-domain'),
                ],
                'default' => 'btn-sm',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button Text Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __('Button Text Color Hover', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Button Background Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => __('Button Background Color Hover', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => __('Button Border Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label' => __('Button Border Color Hover', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
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
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '10' => esc_html__('10px', 'plugin-domain'),
                    '11' => esc_html__('11px', 'plugin-domain'),
                    '12' => esc_html__('12px', 'plugin-domain'),
                    '13' => esc_html__('13px', 'plugin-domain'),
                    '14' => esc_html__('14px', 'plugin-domain'),
                    '15' => esc_html__('15px', 'plugin-domain'),
                    '16' => esc_html__('16px', 'plugin-domain'),
                    '17' => esc_html__('17px', 'plugin-domain'),
                    '18' => esc_html__('18px', 'plugin-domain'),
                    '19' => esc_html__('19px', 'plugin-domain'),
                    '20' => esc_html__('20px', 'plugin-domain'),
                ],
                'default' => '16',
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_icon_button_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_icon_button_';

            $settings['icon'] = (isset($settings['icon']['value']) && !empty($settings['icon']['value'])) ? ' '.$settings['icon']['value'] : '';

            $settings['link']['title'] = (isset($settings['button_text'])) ? $settings['button_text'] : __('Button','plugin-domain');

            masterstudy_show_template('icon_button', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
