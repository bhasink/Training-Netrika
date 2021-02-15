<?php

use Elementor\Controls_Manager;

class Elementor_STM_Featured_Products extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_featured_products';
    }

    public function get_title()
    {
        return esc_html__('Products List (All, featured, teacher courses)', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-star-o';
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

        $experts = array(
		    'no_expert' => 'Choose expert for course',
	    );

		$experts_args = array(
			'post_type'		=> 'teachers',
			'post_status' => 'publish',
			'posts_per_page'=> -1,
		);

		$experts_query = new WP_Query($experts_args);

        if(intval($experts_query->found_posts) > 0) {
            foreach($experts_query->posts as $expert){
                $experts[$expert->ID] = $expert->post_title;
            };
        }

        wp_reset_query();

        $stm_product_categories = array();

		$all_product_categories = get_terms('product_cat', array('hide_empty'=>true));

		if($all_product_categories && !is_wp_error($all_product_categories)){
			foreach($all_product_categories as $category) {
                $stm_product_categories[$category->slug] = $category->name;
			}
		}

        $stm_product_tags = array();

		$all_product_tags = get_terms('product_tag', array('hide_empty'=>true));

		if($all_product_tags && !is_wp_error($all_product_tags)){
			foreach($all_product_tags as $tag) {
                $stm_product_tags[$tag->slug] = $tag->name;
			}
		}

        $order_by_values = array(
    		'date' => __( 'Date', 'masterstudy'),
    		'ID' => __( 'ID', 'masterstudy' ),
    		'author' => __( 'Author', 'masterstudy' ),
    		'title' => __( 'Title', 'masterstudy' ),
    		'modified' => __( 'Modified', 'masterstudy' ),
    		'rand' => __( 'Random', 'masterstudy' ),
    		'comment_count' => __( 'Comment count', 'masterstudy' ),
    		'menu_order' => __( 'Menu order', 'masterstudy' ),
    	);

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'elementor-stm-widgets'),
            ]
        );

        $this->add_control(
            'meta_key',
            [
                'label' => __('Meta sorting key', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => 'All',
                    '_featured' => 'Featured',
                    'expert' => 'Expert',
                    'category' => 'Category',
					'tag' => 'Tag',
                ],
                'default' => 'all',
            ]
        );

        $this->add_control(
            'expert_id',
            [
                'label' => __('Choose expert', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $experts,
                'default' => 'no_expert',
            ]
        );

        $this->add_control(
            'product_tag_id',
            [
                'label' => __('Choose tag', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $stm_product_tags,
                'default' => 'no_tag',
            ]
        );

        $this->add_control(
            'category_id',
            [
                'label' => __('Choose category', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $stm_product_categories,
                'default' => 'no_category',
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label' => __('View type', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'featured_products_list' => 'List',
                    'featured_products_carousel' => 'Carousel',
                ],
                'default' => 'featured_products_carousel',
            ]
        );

        $this->add_control(
            'auto',
            [
                'label' => __('Carousel Auto Scroll', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => __('Number of items to output', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Type Number of items here', 'plugin-domain'),
                'description' => __('Leave empty to display all', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'per_row',
            [
                'label' => __('Number of items per row', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    4 => '4',
                    3 => '3',
                    2 => '2',
                    1 => '1',
                ],
                'default' => 4,
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'DESC' => 'Descending',
                    'ASC' => 'Ascending',
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order by', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $order_by_values,
                'default' => 'date',
            ]
        );

        $this->add_control(
            'hide_price',
            [
                'label' => __('Don\'t Show price', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_rating',
            [
                'label' => __('Don\'t Show rating', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_comments',
            [
                'label' => __('Don\'t Show comments number', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'price_bg',
            [
                'label' => __('Price Badge background color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'free_price_bg',
            [
                'label' => __('Price Badge (Free) background color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_featured_products_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_featured_products_';

            $settings['featured_product_num'] = stm_create_unique_id($settings);

            masterstudy_show_template('featured_products', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
