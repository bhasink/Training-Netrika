<?php

use Elementor\Controls_Manager;

class Elementor_STM_Post_Author extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_post_author';
    }

    public function get_title()
    {
        return esc_html__('STM Post Author', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-user';
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


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_post_author_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_post_author_';

            masterstudy_show_template('post_author', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
