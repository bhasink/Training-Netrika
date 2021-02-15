<?php

use Elementor\Controls_Manager;

class Elementor_STM_Testimonials extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_testimonials';
    }

    public function get_title()
    {
        return esc_html__('STM Testimonials', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-comments-o';
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

        $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
    	$available_cf7 = array();
    	if( $cf7Forms = get_posts( $args ) and is_admin()){
    		foreach($cf7Forms as $cf7Form){
                $available_cf7[$cf7Form->ID] = $cf7Form->post_title;
    		};
    	} else {
    		$available_cf7['none'] = 'No CF7 forms found';
    	};

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'testimonials_title',
            [
                'label' => __('Section title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( "Title will be shown on the top of section", 'plugin-domain' )
            ]
        );

        $this->add_control(
            'testimonials_max_num',
            [
                'label' => __('Number of testimonials to output', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( "Fill field with number only", 'plugin-domain' )
            ]
        );

        $this->add_control(
            'testimonials_text_color',
            [
                'label' => __('Text Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Style', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style_1' => __( 'Style 1', 'plugin-domain' ),
                    'style_2' => __( 'Style 2', 'plugin-domain' ),
                    'style_3' => __( 'Style 3', 'plugin-domain' ),
                    'style_4' => __( 'Style 4', 'plugin-domain' ),
                    'style_5' => __( 'Style 5', 'plugin-domain' ),
                ],
                'default' => 'style_1',
            ]
        );

        $this->add_control(
            'testimonials_slides_per_row',
            [
                'label' => __('Number of testimonials per row', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                ],
                'default' => 2,
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_testimonials_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_testimonials_';

            $settings['icon'] = (isset($settings['icon']['value'])) ? ' '.$settings['icon']['value'] : '';

            $settings['atts'] = $settings;

            masterstudy_show_template('testimonials', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
