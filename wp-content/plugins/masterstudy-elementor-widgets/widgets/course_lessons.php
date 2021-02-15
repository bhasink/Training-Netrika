<?php

use Elementor\Controls_Manager;

class Elementor_STM_Course_Lessons extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'stm_course_lessons';
    }

    public function get_title()
    {
        return esc_html__('STM Course Lessons', 'masterstudy-elementor-widgets');
    }

    public function get_icon()
    {
        return 'fa fa-leanpub';
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
                'label' => __('Content', 'elementor-stm-widgets'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Section Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Section Title here', 'plugin-domain'),
            ]
        );


        /*Lessons*/
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Lesson Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Lesson Title here', 'plugin-domain'),
            ]
        );

        $repeater->add_control(
            'private_lesson',
            [
                'label' => __('Private', 'plugin-domain'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => __('Icon', 'text-domain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                ],
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __( 'Tab Text', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
            ]
        );

        $repeater->add_control(
            'badge',
            [
                'label' => __('Lesson badge', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'no_badge',
                'options' => array_flip(array(
                    'Choose Badge'	=> 'no_badge',
					'Test'		=> 'test',
					'Video'		=> 'video',
					'Exam'		=> 'exam',
					'Quiz'		=> 'quiz',
					'Lecture'   => 'lecture',
					'Seminar'	=> 'seminar',
					'Free'		=> 'free',
					'Practice'  => 'practice',
					'Exercise'  => 'exercise',
					'Activity'  => 'activity',
                ))
            ]
        );

        $repeater->add_control(
            'preview_video',
            [
                'label' => __('Preview video', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Preview video here', 'plugin-domain'),
            ]
        );

        $repeater->add_control(
            'private_placeholder',
            [
                'label' => __('Content placeholder', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Type Private lesson content placeholder here', 'plugin-domain'),
            ]
        );

        $repeater->add_control(
            'meta',
            [
                'label' => __('Lesson meta', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Type Lesson meta here', 'plugin-domain'),
            ]
        );

        $repeater->add_control(
            'meta_icon',
            [
                'label' => __('Icon', 'text-domain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                ],
            ]
        );

        $this->add_control(
            'lessons',
            [
                'label' => __('Repeater List', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );


        $this->end_controls_section();

        $this->add_dimensions('.masterstudy_elementor_course_lessons_');

    }

    protected function render()
    {
        if (function_exists('masterstudy_show_template')) {

            $settings = $this->get_settings_for_display();

            $settings['css_class'] = ' masterstudy_elementor_course_lessons ';

            masterstudy_show_template('course_lessons', $settings);

        }
    }

    protected function _content_template()
    {

    }

}
