<?php

STM_LMS_Templates::load_templates();

class STM_LMS_Templates
{

	private static $instance;

	public static function load_templates()
	{
		add_filter('the_content', array(self::get_instance(), 'courses_archive_content'), 100);
		add_filter('the_content', array(self::get_instance(), 'instructors_archive_content'), 100);
		add_filter('single_template', array(self::get_instance(), 'lms_template'));
		add_action('stm-lms-content-stm-courses', array(self::get_instance(), 'single_course'), 100);
		add_action('stm-lms-content-stm-course-bundles', array(self::get_instance(), 'single_bundle'), 100);

		add_filter('taxonomy_template', array(self::get_instance(), 'taxonomy_archive_content'), 100, 1);

	}

	public static function taxonomy_archive_content($template)
	{
		if (is_admin()) return $template;
		$taxonomy = get_query_var('taxonomy');
		if ($taxonomy === 'stm_lms_course_taxonomy') {
			$template = STM_LMS_Templates::locate_template('stm-lms-taxonomy-archive');

		}
		return $template;
	}

	public static function courses_archive_content($content)
	{


		$courses_page = STM_LMS_Options::courses_page();

		//Do nothing if no courses page
		if (empty($courses_page) or !is_page($courses_page)) {
			return $content;
		}

		if (is_page($courses_page)) {

			remove_filter('the_content', array(self::get_instance(), 'courses_archive_content'), 100);

			$courses = self::load_lms_template('courses/archive');

			add_filter('the_content', array(self::get_instance(), 'courses_archive_content'), 100);

			return $content . $courses;
		}

		return $content;
	}

	public static function instructors_archive_content($content)
	{


		$instructors_page = STM_LMS_Options::instructors_page();

		//Do nothing if no courses page
		if (empty($instructors_page) or !is_page($instructors_page)) {
			return $content;
		}

		if (is_page($instructors_page)) {
			remove_filter('the_content', array(self::get_instance(), 'instructors_archive_content'), 100);

			$instructors = '<div class="stm_lms_instructors_grid_wrapper">';
			$instructors .= '<h1 class="text-center">' . esc_html__('Instructors', 'masterstudy-lms-learning-management-system') . '</h1>';
			$instructors .= '<div class="stm_lms_courses stm_lms_courses__archive">';
			$instructors .= self::load_lms_template(
				'instructors/grid'
			);
			$instructors .= '</div>';
			$instructors .= '</div>';

			add_filter('the_content', array(self::get_instance(), 'instructors_archive_content'), 100);
			return $content . $instructors;
		}
	}

	public static function single_course()
	{
		echo self::load_lms_template('course/single');
	}

    public static function single_bundle()
    {
        echo self::load_lms_template('bundle/single');
    }

	public static function lms_template($template)
	{

		global $post;
		$post_types = array(
			'stm-courses',
            'stm-course-bundles'
		);
		if (in_array($post->post_type, $post_types)) return self::locate_template('masterstudy-lms-learning-management-system');

		return $template;
	}

	public static function locate_template($template_name, $stm_lms_vars = array())
	{
		$template_name = '/stm-lms-templates/' . $template_name . '.php';
		$template_name = apply_filters('stm_lms_template_name', $template_name, $stm_lms_vars);
		$lms_template = apply_filters('stm_lms_template_file', STM_LMS_PATH, $template_name) . $template_name;


        if(!empty($_GET['dev_lms_template'])) {
            $tpl = (locate_template($template_name)) ? locate_template($template_name) : $lms_template;
            stm_pa($tpl);
        }
		return (locate_template($template_name)) ? locate_template($template_name) : $lms_template;

	}

    public static function vc_locate_template($template_name)
    {
        $plugin_path = STM_LMS_PATH . '/stm-lms-templates/' . $template_name . '.php';
        $theme_template_name = '/' . $template_name . '.php';
        return (locate_template($theme_template_name)) ? locate_template($theme_template_name) : $plugin_path;

    }


	public static function load_lms_template($template_name, $stm_lms_vars = array())
	{
		ob_start();
		extract($stm_lms_vars);
		include(self::locate_template($template_name, $stm_lms_vars));
		return apply_filters("stm_lms_{$template_name}", ob_get_clean(), $stm_lms_vars);
	}

	public static function show_lms_template($template_name, $stm_lms_vars = array())
	{
		echo self::load_lms_template($template_name, $stm_lms_vars);
	}


	public static function get_instance()
	{

		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    public static function stm_lms_locate_vc_element($templates, $template_name = '', $custom_path)
    {
        $located = false;


        foreach ((array)$templates as $template) {

            $folder = $template;

            if (!empty($template_name)) {
                $template = $template_name;
            }

            if (substr($template, -4) !== '.php') {
                $template .= '.php';
            }


            if (empty($custom_path)) {
                if (!($located = locate_template('partials/vc_parts/' . $folder . '/' . $template))) {
                    $located = STM_LMS_PATH . '/partials/vc_parts/' . $folder . '/' . $template;
                }
            } else {
                if (!($located = locate_template($custom_path))) {
                    $located = STM_LMS_PATH . '/' . $custom_path . '.php';
                }
            }

            if (file_exists($template_name)) {
                break;
            }
        }

        return apply_filters('stm_lms_locate_vc_element', $located, $templates);
    }

    public static function stm_lms_load_vc_element($__template, $__vars = array(), $__template_name = '', $custom_path = '')
    {
        extract($__vars);
        $element = self::stm_lms_locate_vc_element($__template, $__template_name, $custom_path);
        if (!file_exists($element) && strpos($__template_name, 'style_') !== false) {
            $element = str_replace($__template_name, 'style_1', $element);
        }
        if (file_exists($element)) {
            include $element;
        } else {
            echo esc_html__('Element not found in ' . $element, 'masterstudy-lms-learning-management-system');
        }
    }


}

;