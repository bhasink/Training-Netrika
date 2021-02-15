<?php

use Elementor\Controls_Manager;

class Elementor_STM_Certificate extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_certificate';
    }

    public function get_title()
    {
        return esc_html__('STM Certificate', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-certificate';
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
                'label' => __('Certificate name', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Certificate name here', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Certificate Print', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_certificate_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_certificate_';

            if(!empty($settings['image'])){
            	$settings['certificate_url'] = wp_get_attachment_image_src($settings['image']['id'], 'img-480-380', true);
            }

            masterstudy_show_template('certificate', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
