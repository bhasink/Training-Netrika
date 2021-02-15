<?php

use Elementor\Controls_Manager;

class Elementor_STM_Video extends \Elementor\Widget_Base {

    public function get_name() {
        return 'stm_video';
    }

    public function get_title() {
        return esc_html__('STM Video', 'masterstudy-elementor-widgets');
    }

    public function get_icon() {
        return 'fa fa-video';
    }

    public function get_categories() {
        return [ 'theme-elements' ];
    }

    public function add_dimensions($selector = '') {
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'URL (Link)', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'show_external' => true,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'el_class',
            [
                'label' => __( 'Extra class name', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.stm_video');

    }

    protected function render() {
        if(function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_stm_video ';

            masterstudy_show_template('stm_video', $settings);

        }
    }

    protected function _content_template() {

    }

}
