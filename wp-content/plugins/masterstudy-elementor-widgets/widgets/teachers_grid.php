<?php

use Elementor\Controls_Manager;

class Elementor_STM_Teachers_Grid extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_teachers_grid';
    }

    public function get_title()
    {
        return esc_html__('STM Teachers Grid ', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-graduation-cap';
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
            'per_page',
            [
                'label' => __('Teacher per page', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '8',
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', 'plugin-domain' )
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => __('Show Pagination', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'show' => __( 'Show', 'elementor' ),
                    'hide' => __( 'Hide', 'elementor' ),
                ],
                'default' => 'show',
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_teachers_grid_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_teachers_grid_';

            masterstudy_show_template('teachers_grid', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
