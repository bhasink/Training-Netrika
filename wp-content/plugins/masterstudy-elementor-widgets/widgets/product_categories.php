<?php

use Elementor\Controls_Manager;

class Elementor_STM_Product_Categories extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_product_categories';
    }

    public function get_title()
    {
        return esc_html__('STM Product Categories', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-product-categories';
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
            'view_type',
            [
                'label' => __( 'View type', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'stm_vc_product_cat_carousel' => __( 'Carousel', 'plugin-domain' ),
                    'stm_vc_product_cat_list' => __( 'List', 'plugin-domain' ),
                    'stm_vc_product_cat_card' => __( 'Card', 'plugin-domain' ),
                ],
                'default' => 'stm_vc_product_cat_carousel',
            ]
        );

        $this->add_control(
            'auto',
            [
                'label' => __( 'Carousel Auto Scroll', 'plugin-domain' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => __( 'Number of items to output', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'description' => 'Leave field empty to display all categories',
            ]
        );

        $this->add_control(
            'per_row',
            [
                'label' => __( 'Number of items per row', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    6 => '6',
                    4 => '4',
                    3 => '3',
                    2 => '2',
                    1 => '1',
                ],
                'default' => 6,
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => __('Box text Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => __( 'Text box Align', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center' => __( 'Center', 'plugin-domain' ),
                    'left' => __( 'Left', 'plugin-domain' ),
                    'right' => __( 'Right', 'plugin-domain' ),
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon size', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'description' => 'If category has font icon chosen - size will be applied',
                'default' => '60'
            ]
        );

        $this->add_control(
            'icon_height',
            [
                'label' => __( 'Icon height', 'plugin-domain' ),
                'type' => Controls_Manager::NUMBER,
                'description' => 'If category has font icon chosen - height will be applied',
                'default' => '69'
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_product_categories_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_product_categories ';
            $settings['atts'] = $settings;

            masterstudy_show_template('product_categories', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
