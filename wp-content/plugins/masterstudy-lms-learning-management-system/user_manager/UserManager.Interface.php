<?php

new STM_LMS_User_Manager_Interface();

class STM_LMS_User_Manager_Interface
{

    public function __construct()
    {

        add_action('admin_menu', array($this, 'dashboard_menu'));

        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('admin_enqueue_scripts', array($this, 'scripts'));

        add_action('admin_footer', array($this, 'components'));
        add_action('wp_footer', array($this, 'components'));


    }

    function dashboard_menu()
    {
        add_menu_page(
            esc_html__('LMS Dashboard', 'textdomain'),
            esc_html__('LMS Dashboard', 'textdomain'),
            'manage_options',
            'stm-lms-dashboard',
            array($this, 'dashboard_view'),
            'dashicons-clipboard',
            7
        );
    }

    function dashboard_view()
    {
        STM_LMS_Templates::show_lms_template('dashboard/dashboard');
    }

    function scripts($hook)
    {
        if ($hook === 'toplevel_page_stm-lms-dashboard') {

            stm_lms_register_style('dashboard/dashboard');

            wp_register_script('vue-router.js', 'https://unpkg.com/vue-router@2.0.0/dist/vue-router.js');

            $components = self::components_list();

            foreach ($components as $component) {
                stm_lms_register_script("dashboard/components/{$component}");
            }

            stm_lms_register_script(
                'dashboard/dashboard',
                array(
                    'vue.js',
                    'vue-resource.js',
                    'vue-router.js'
                ),
                true
            );

        }
    }

    function components()
    {
        $components = self::components_list();

        foreach ($components as $component) {
            self::wrap_component($component);
        }

    }

    function components_list()
    {
        return array(
            'home',
            'navigation',
            'add_user',
            'student_assignments',
            'student_quiz',
            'back',
            'courses',
            'course',
            'course_user',
        );
    }

    static function wrap_component($component)
    { ?>
        <script type="text/html" id="<?php echo esc_attr("stm-lms-dashboard-{$component}") ?>">
            <?php STM_LMS_Templates::show_lms_template("dashboard/components/{$component}"); ?>
        </script>
    <?php }

    static function isInstructor()
    {
        return current_user_can('manage_options');
    }

}