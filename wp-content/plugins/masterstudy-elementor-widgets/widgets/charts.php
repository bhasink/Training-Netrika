<?php

use Elementor\Controls_Manager;

class Elementor_STM_Charts extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_charts';
    }

    public function get_title()
    {
        return esc_html__('Charts', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-chart-pie';
    }

    public function get_categories()
    {
        return ['theme-elements'];
    }

    protected function _register_controls()
    {


        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'elementor-stm-widgets'),
            ]
        );

        $this->add_control(
            'design',
            [
                'label' => __('Design', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'line',
                'options' => array_flip(array(
                    esc_html__('Line', 'masterstudy') => 'line',
                    esc_html__('Bar', 'masterstudy') => 'bar',
                    esc_html__('Doughnut', 'masterstudy') => 'doughnut',
                    esc_html__('Pie', 'masterstudy') => 'pie',
                    esc_html__('Radar', 'masterstudy') => 'radar',
                    esc_html__('Polar area', 'masterstudy') => 'polarArea',
                )),
            ]
        );

        $this->add_control(
            'legend',
            [
                'label' => __('Show legend?', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'legend_position',
            [
                'label' => __('Legend Position', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => array_flip(array(
                    esc_html__('Top', 'masterstudy') => 'top',
                    esc_html__('Right', 'masterstudy') => 'right',
                    esc_html__('Bottom', 'masterstudy') => 'bottom',
                    esc_html__('Left', 'masterstudy') => 'left',
                )),
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => __('Width (px)', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => __('Height (px)', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'x_values',
            [
                'label' => __('X-axis values', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => 'JAN; FEB; MAR; APR; MAY; JUN; JUL; AUG',
                'condition' => [
                    'design' => array('line', 'bar', 'radar')
                ]
            ]
        );

        /*Repeater VALUES*/
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'y_values', [
                'label' => __('Y-axis values', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'color',
            [
                'label' => __('Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'values',
            [
                'label' => __('Values', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    array(
                        'title' => esc_html__('One', 'masterstudy'),
                        'y_values' => '10; 15; 20; 25; 27; 25; 23; 25',
                        'color' => '#fe6c61',
                    ),
                    array(
                        'title' => esc_html__('Two', 'masterstudy'),
                        'y_values' => '25; 18; 16; 17; 20; 25; 30; 35',
                        'color' => '#5472d2'
                    ),
                ],
                'title_field' => '{{{ title }}}',
                'condition' => [
                    'design' => array('line', 'bar', 'radar')
                ]
            ]
        );

        /*Repeater CIRCLE VALUES*/
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => __('Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'value', [
                'label' => __('Value', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'color',
            [
                'label' => __('Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'values_circle',
            [
                'label' => __('Values', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    array(
                        'title' => esc_html__('One', 'masterstudy'),
                        'value' => '40',
                        'color' => '#fe6c61',
                    ),
                    array(
                        'title' => esc_html__('Two', 'masterstudy'),
                        'value' => '30',
                        'color' => '#5472d2'
                    ),
                    array(
                        'title' => esc_html__('Three', 'masterstudy'),
                        'value' => '40',
                        'color' => '#8d6dc4'
                    )
                ],
                'title_field' => '{{{ title }}}',
                'condition' => [
                    'design' => array('doughnut', 'pie', 'polarArea')
                ]
            ]
        );


        $this->end_controls_section();

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {
            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' stm_charts';

            if(!empty($_GET['action']) && ($_GET['action'] === 'elementor' || $_GET['action'] === 'elementor_ajax')) {
                echo "<div class='masterstudy-elementor-notice'>" . esc_html__('Check module in preview mode.', 'plugin-domain') . "</div>";
            } else {
                masterstudy_show_template('charts', $settings);
            }
        }
    }

    protected function _content_template()
    {
        echo "<div class='masterstudy-elementor-notice'>" . esc_html__('Check module in preview mode.', 'plugin-domain') . "</div>";
    }

}
