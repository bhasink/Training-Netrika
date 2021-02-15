<?php

namespace StmLmsElementor;


use StmLmsElementor\Widgets\StmCoursesSearchbox;
use StmLmsElementor\Widgets\StmLmsSingleCourseCarousel;
use StmLmsElementor\Widgets\StmLmsCoursesCarousel;
use StmLmsElementor\Widgets\StmLmsCoursesCategories;
use StmLmsElementor\Widgets\StmLmsCoursesGrid;
use StmLmsElementor\Widgets\StmLmsFeaturedTeacher;
use StmLmsElementor\Widgets\StmLmsInstructorsCarousel;
use StmLmsElementor\Widgets\StmLmsRecentCourses;
use StmLmsElementor\Widgets\StmLmsCertificateChecker;
use StmLmsElementor\Widgets\StmLmsCourseBundles;
use StmLmsElementor\Widgets\StmLmsGoogleClassroom;


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin
{

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct()
    {
        $this->add_actions();
        add_action('elementor/preview/enqueue_styles', [$this, 'preview_styles']);
        add_action('elementor/preview/enqueue_scripts', [$this, 'preview_scripts']);
    }

    /**
     * Add Actions
     *
     * @since 1.0.0
     *
     * @access private
     */
    private function add_actions()
    {
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
    }

    static function preview_scripts()
    {
        wp_enqueue_script('imagesloaded');
        wp_enqueue_script('owl.carousel');
        wp_enqueue_script('vue-resource.js');
        wp_enqueue_script('vue.js');
        stm_lms_module_scripts('vue-autocomplete', 'vue2-autocomplete', array());
        stm_lms_module_scripts('courses_search', 'courses_search');

        stm_lms_module_scripts('single_course_carousel', 'style_1');
        stm_lms_module_scripts('recent_courses', 'style_1');
        stm_lms_module_scripts( 'instructors_carousel', 'style_1' );
        stm_lms_register_script('certificate_checker');
        stm_lms_register_script('bundles/card');
        stm_lms_register_script('google_classroom_module', array('vue.js', 'vue-resource.js', 'jquery.cookie'));
        wp_localize_script('stm-lms-google_classroom_module', 'google_classroom_data', array(
            'auditory' => \STM_LMS_Helpers::get_posts('stm-auditory'),
            'chosen_auditory' => '',
            'per_page' => 4
        ));
    }

    static function preview_styles()
    {
        wp_enqueue_style('owl.carousel');
        stm_lms_module_styles('vue-autocomplete', 'vue2-autocomplete');
        stm_lms_register_style('courses');
        stm_lms_register_style("courses/style_1");
        stm_lms_register_style("courses/style_2");
        stm_lms_module_styles('searchbox', 'style_1');
        stm_lms_module_styles('searchbox', 'style_2');
        stm_lms_register_style('course');
        stm_lms_module_styles('single_course_carousel');
        stm_lms_module_styles('recent_courses', 'style_1', array());
        stm_lms_module_styles('recent_courses', 'style_2', array());
        stm_lms_module_styles('featured_teacher', 'style_1');
        stm_lms_module_styles( 'instructors_carousel', 'style_1', array() );
        stm_lms_module_styles( 'instructors_carousel', 'style_2', array() );
        stm_lms_register_style( 'user' );
        stm_lms_register_style( 'instructors_grid' );
        stm_lms_module_styles( 'course_category', 'style_1', array());
        stm_lms_module_styles( 'course_category', 'style_2', array());
        stm_lms_module_styles( 'course_category', 'style_3', array());
        stm_lms_module_styles( 'course_category', 'style_4', array());
        stm_lms_register_style('certificate_checker');
        stm_lms_register_style('bundles/card');
        stm_lms_register_style('google_classroom/module');

        stm_lms_register_style('admin/elementor_preview');
    }
    /**
     * On Widgets Registered
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function on_widgets_registered()
    {
        $this->includes();
        $this->register_widget();
    }

    /**
     * Includes
     *
     * @since 1.0.0
     *
     * @access private
     */
    private function includes()
    {
        require STM_LMS_PATH . '/elementor/widgets/stm_courses_searchbox.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_courses_carousel.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_courses_categories.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_courses_grid.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_featured_teacher.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_instructors_carousel.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_recent_courses.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_single_course_carousel.php';

        // Pro widgets
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_certificate_checker.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_course_bundles.php';
        require STM_LMS_PATH . '/elementor/widgets/stm_lms_google_classroom.php';

    }

    /**
     * Register Widget
     *
     * @since 1.0.0
     *
     * @access private
     */
    private function register_widget()
    {
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmCoursesSearchbox() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsSingleCourseCarousel() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsCoursesCarousel() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsCoursesCategories() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsCoursesGrid() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsFeaturedTeacher() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsInstructorsCarousel() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsRecentCourses() );
        if(defined('STM_LMS_PRO_PATH')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsCertificateChecker() );
        }
        if(class_exists('STM_LMS_Course_Bundle')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsCourseBundles() );
        }
        if(class_exists('STM_LMS_Google_Classroom')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new StmLmsGoogleClassroom() );
        }
    }
}

new Plugin();
