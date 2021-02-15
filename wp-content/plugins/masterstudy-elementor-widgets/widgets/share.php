<?php

use Elementor\Controls_Manager;

class Elementor_STM_Share extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_share';
    }

    public function get_title()
    {
        return esc_html__('STM Share', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-share-alt';
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
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Title here', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'code',
            [
                'label' => __('Code', 'plugin-domain'),
				'type' => Controls_Manager::TEXTAREA,
                'default' => "<span class='st_facebook_large' displayText=''></span>
<span class='st_twitter_large' displayText=''></span>
<span class='st_googleplus_large' displayText=''></span>"
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_share_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_share_';

            masterstudy_show_template('share', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
