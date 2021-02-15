<?php

use Elementor\Controls_Manager;

class Elementor_STM_Post_List extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_post_list';
    }

    public function get_title()
    {
        return esc_html__('STM Post List', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-list';
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

        // Get post types to offer
    	$post_list_data = array(
            'post' => 'Post',
            'teachers' => 'Experts',
            'testimonial' => 'Testimonials',
    	);

        $this->add_control(
            'post_list_data_source',
            [
                'label' => __( 'Post Data', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => $post_list_data,
                'default' => 'post',
            ]
        );

        $this->add_control(
            'post_list_per_page',
            [
                'label' => __( 'Number of items to output', 'plugin-domain' ),
                'type' => Controls_Manager::TEXT,
                'description' => __( "Fill field with number only", 'plugin-domain' ),
            ]
        );

        $this->add_control(
            'post_list_per_row',
            [
                'label' => __( 'Number of items to output per row', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    6 => '6',
                ],
                'default' => 3,
            ]
        );

        $this->add_control(
            'post_list_show_date',
            [
                'label' => __( 'Show post date', 'plugin-domain' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'post_list_show_cats',
            [
                'label' => __( 'Show post categories', 'plugin-domain' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'post_list_show_tags',
            [
                'label' => __( 'Show post tags', 'plugin-domain' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'post_list_show_comments',
            [
                'label' => __( 'Show comments tags', 'plugin-domain' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'custom_color',
            [
                'label' => __('Custom color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_post_list_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_post_list_';

            masterstudy_show_template('post_list', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
