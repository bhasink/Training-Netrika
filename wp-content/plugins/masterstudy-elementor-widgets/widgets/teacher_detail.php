<?php

use Elementor\Controls_Manager;

class Elementor_STM_Teacher_Detail extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_teacher_detail';
    }

    public function get_title()
    {
        return esc_html__('STM Teacher Detail', 'masterstudy-elementor-widgets');
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


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_teacher_detail_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_teacher_detail_';

            masterstudy_show_template('teacher_detail', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
