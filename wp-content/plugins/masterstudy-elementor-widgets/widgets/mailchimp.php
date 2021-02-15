<?php

use Elementor\Controls_Manager;

class Elementor_STM_Mailchimp extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_mailchimp';
    }

    public function get_title()
    {
        return esc_html__('STM Mailchimp', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-user-plus';
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
                'label' => __('Titile', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );



        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_mailchimp_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_mailchimp_';

            $settings['uniq_class'] = stm_create_unique_id($settings);

            masterstudy_show_template('mailchimp', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
