<?php

use Elementor\Controls_Manager;

class Elementor_STM_Sidebar extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_sidebar';
    }

    public function get_title()
    {
        return esc_html__('STM Sidebar', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-sidebar';
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

        $stm_sidebars_array = get_posts( array( 'post_type' => 'sidebar', 'posts_per_page' => -1 ) );
    	$stm_sidebars = array( 0 => __( 'Select', 'masterstudy' ) );
    	if( $stm_sidebars_array ){
    		foreach( $stm_sidebars_array as $val ){
    			$stm_sidebars[ $val->ID ] = get_the_title( $val );
    		}
    	}

        $this->add_control(
            'sidebar',
            [
                'label' => __( 'Code', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => $stm_sidebars,
                'default' => 0,
            ]
        );

        $this->add_control(
            'sidebar_position',
            [
                'label' => __( 'Sidebar position', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => __( 'Left', 'plugin-domain' ),
                    'right' => __( 'Right', 'plugin-domain' ),
                ],
                'default' => 'right',
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_sidebar_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_sidebar_';

            masterstudy_show_template('sidebar', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
