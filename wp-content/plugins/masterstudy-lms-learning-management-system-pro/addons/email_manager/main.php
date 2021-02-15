<?php
require_once STM_LMS_PRO_PATH . '/addons/scorm/db.php';

new STM_LMS_Email_Manager;

class STM_LMS_Email_Manager
{

    function __construct()
    {

        add_filter('stm_lms_filter_email_data', array($this, 'rewrite_email'), 10, 1);

        add_filter('wpcfto_options_page_setup', array($this, 'stm_lms_settings_page'));

    }

    function rewrite_email($data)
    {

        if (!isset($data['vars']) or empty($data['filter_name'])) return $data;
        $vars = $data['vars'];
        $filter_name = $data['filter_name'];

        $settings = self::stm_lms_get_settings();

        if (isset($settings["{$filter_name}_subject"])) $data['subject'] = $settings["{$filter_name}_subject"];

        if (empty($settings[$filter_name])) return $data;

        $data['enabled'] = (!empty($settings["{$filter_name}_enable"]) && $settings["{$filter_name}_enable"]);

        $message = $settings[$filter_name];

        $occurences = self::findReplace($message);
        if (empty($occurences[0]) or empty($occurences[1])) {

            $data['message'] = $message;

            return $data;
        }

        $data['message'] = $message;

        foreach ($occurences[1] as $occurence_index => $occurence) {
            if (empty($vars[$occurence])) continue;

            $data['message'] = str_replace($occurences[0][$occurence_index], $vars[$occurence], $data['message']);
        }

        return $data;
    }

    /*Settings*/
    function stm_lms_settings_page($setups)
    {

        $setups[] = array(
            'page' => array(
                'parent_slug' => 'stm-lms-settings',
                'page_title' => 'Email manager Settings',
                'menu_title' => 'Email manager Settings',
                'menu_slug' => 'email_manager_settings',
            ),
            'fields' => $this->stm_lms_settings(),
            'option_name' => 'stm_lms_email_manager_settings'
        );

        return $setups;

    }

    function stm_lms_settings()
    {

        $sections = array(
            'instructors' => esc_html__('Instructors', 'masterstudy-lms-learning-management-system'),
            'lessons' => esc_html__('Lessons', 'masterstudy-lms-learning-management-system'),
            'account' => esc_html__('Account', 'masterstudy-lms-learning-management-system'),
            'enterprise' => esc_html__('Enterprise', 'masterstudy-lms-learning-management-system'),
            'order' => esc_html__('Orders', 'masterstudy-lms-learning-management-system'),
            'course' => esc_html__('Course', 'masterstudy-lms-learning-management-system'),
            'assignment' => esc_html__('Assignment', 'masterstudy-lms-learning-management-system'),
        );

        $emails = array(
            'stm_lms_course_published' => array(
                'section' => 'instructors',
                'notice' => esc_html__('Send email to instructor when course published', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Course published', 'masterstudy-lms-learning-management-system-pro'),
                'message' => esc_html__('Your course - {{course_title}} was approved, and now its live on site', 'masterstudy-lms-learning-management-system-pro'),
                'vars' => array(
                    'course_title' => esc_html__('Course Title', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_become_instructor_email' => array(
                'section' => 'instructors',
                'notice' => esc_html__('Become instructor', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New Instructor Application', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'User {{user_login}} with id - {{user_id}}, wants to become an Instructor. Degree - {{degree}}. Expertize - {{expretize}}',
                'vars' => array(
                    'user_login' => esc_html__('User login', 'masterstudy-lms-learning-management-system-pro'),
                    'user_id' => esc_html__('User ID', 'masterstudy-lms-learning-management-system-pro'),
                    'degree' => esc_html__('Degree', 'masterstudy-lms-learning-management-system-pro'),
                    'expertize' => esc_html__('Expertize', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_lesson_comment' => array(
                'section' => 'lessons',
                'notice' => esc_html__('New lesson comment', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New lesson comment', 'masterstudy-lms-learning-management-system-pro'),
                'message' => '{{user_login}} commented - "{{comment_content}}" on lesson {{lesson_title}}',
                'vars' => array(
                    'user_login' => esc_html__('User login', 'masterstudy-lms-learning-management-system-pro'),
                    'comment_content' => esc_html__('Comment content', 'masterstudy-lms-learning-management-system-pro'),
                    'lesson_title' => esc_html__('Lesson title', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_account_premoderation' => array(
                'section' => 'account',
                'notice' => esc_html__('Account Premoderation', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Activate your account', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Please activate your account via this link - {{reset_url}}',
                'vars' => array(
                    'reset_url' => esc_html__('Reset URL', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_user_registered_on_site' => array(
                'section' => 'account',
                'notice' => esc_html__('Register on site', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('You successfully register on site.', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Now you active user on site - {{blog_name}}. Add information and start chatting with other users - free and fast.',
                'vars' => array(
                    'blog_name' => esc_html__('Blog name', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_password_change' => array(
                'section' => 'account',
                'notice' => esc_html__('Password changed', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Password change', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Password changed successfully.',
                'vars' => array()
            ),
            'stm_lms_enterprise' => array(
                'section' => 'enterprise',
                'notice' => esc_html__('Enterprise Request', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Enterprise Request', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Name - {{name}}; Email - {{email}}; Message - {{text}}',
                'vars' => array(
                    'name' => esc_html__('Name', 'masterstudy-lms-learning-management-system-pro'),
                    'email' => esc_html__('Email', 'masterstudy-lms-learning-management-system-pro'),
                    'text' => esc_html__('Text', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_new_order' => array(
                'section' => 'order',
                'notice' => esc_html__('New order (for admin)', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New order', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'New Order from user {{user_login}}.',
                'vars' => array(
                    'user_login' => esc_html__('User login', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_new_order_accepted' => array(
                'section' => 'order',
                'notice' => esc_html__('New Order (for user)', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New Order', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Your Order Accepted.',
                'vars' => array()
            ),
            'stm_lms_course_added_to_user' => array(
                'section' => 'course',
                'notice' => esc_html__('Course added to User (for admin)', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Course added to User', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Course {{course_title}} was added to {{login}}.',
                'vars' => array(
                    'course_title' => esc_html__('Course title', 'masterstudy-lms-learning-management-system-pro'),
                    'login' => esc_html__('Login', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_course_available_for_user' => array(
                'section' => 'course',
                'notice' => esc_html__('Course added to User (for user)', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Course added.', 'masterstudy-lms-learning-management-system-pro'),
                'message' => 'Course {{course_title}} is now available to learn.',
                'vars' => array(
                    'course_title' => esc_html__('Course title', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_announcement_from_instructor' => array(
                'section' => 'instructors',
                'notice' => esc_html__('Announcement from Instructor', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Announcement from Instructor', 'masterstudy-lms-learning-management-system-pro'),
                'message' => '{{mail}}',
                'vars' => array(
                    'mail' => esc_html__('Instructor message', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_assignment_checked' => array(
                'section' => 'assignment',
                'notice' => esc_html__('Assignment status change (for student)', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('Assignment status change.', 'masterstudy-lms-learning-management-system-pro'),
                'message' => esc_html__('Your assignment was checked', 'masterstudy-lms-learning-management-system-pro'),
                'vars' => array()
            ),
            'stm_lms_new_assignment' => array(
                'section' => 'assignment',
                'notice' => esc_html__('New assignment (for instructor)', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New assignment', 'masterstudy-lms-learning-management-system-pro'),
                'message' => esc_html__('Check new assignment, send by student.', 'masterstudy-lms-learning-management-system-pro'),
                'vars' => array()
            ),
            'stm_lms_new_group_invite' => array(
                'section' => 'enterprise',
                'notice' => esc_html__('New group invite', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New group invite', 'masterstudy-lms-learning-management-system-pro'),
                'message' => esc_html__('You were added to group: {{site_name}}. Now you can check new courses, bought by group.', 'masterstudy-lms-learning-management-system-pro'),
                'vars' => array(
                    'site_name' => esc_html__('Site name', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_new_user_creds' => array(
                'section' => 'enterprise',
                'notice' => esc_html__('New user credentials for enterprise group', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New group invite', 'masterstudy-lms-learning-management-system-pro'),
                'message' => esc_html__('Login: {{username}}; Password: {{password}}; Site URL: {{site_url}}', 'masterstudy-lms-learning-management-system-pro'),
                'vars' => array(
                    'username' => esc_html__('Username', 'masterstudy-lms-learning-management-system-pro'),
                    'password' => esc_html__('Password', 'masterstudy-lms-learning-management-system-pro'),
                    'site_url' => esc_html__('Site URL', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
            'stm_lms_enterprise_new_group_course' => array(
                'section' => 'enterprise',
                'notice' => esc_html__('New course available for enterprise group', 'masterstudy-lms-learning-management-system-pro'),
                'subject' => esc_html__('New course available for enterprise group', 'masterstudy-lms-learning-management-system-pro'),
                'message' => __(
                    "<p>{{admin_login}} invited you to a group {{group_name}} on {{blog_name}} and You were added to the {{course_title}} course.</p><a href='{{user_url}}' target='_blank'>My Account</a><p>Thanks for your time,</p><p>The {{blog_name}} Team</p>",
                    'masterstudy-lms-learning-management-system-pro'
                ),
                'vars' => array(
                    'admin_login' => esc_html__('Admin login', 'masterstudy-lms-learning-management-system-pro'),
                    'group_name' => esc_html__('Group name', 'masterstudy-lms-learning-management-system-pro'),
                    'blog_name' => esc_html__('Blog name', 'masterstudy-lms-learning-management-system-pro'),
                    'course_title' => esc_html__('Course title', 'masterstudy-lms-learning-management-system-pro'),
                    'user_url' => esc_html__('User url', 'masterstudy-lms-learning-management-system-pro'),
                )
            ),
        );

        $data = array();

        foreach($sections as $section_key => $section) {
            $data[$section_key] = array(
                'name' => $section,
                'fields' => array()
            );
        }

        foreach ($emails as $email_key => $email) {

            $data[$email['section']]['fields']["{$email_key}_enable"] = array(
                'type' => 'checkbox',
                'label' => $email['notice'],
                'value' => true
            );

            $data[$email['section']]['fields']["{$email_key}_subject"] = array(
                'type' => 'text',
                'label' => esc_html__('Subject', 'masterstudy-lms-learning-management-system-pro'),
                'value' => $email['subject'],
                'dependency' => array(
                    'key' => "{$email_key}_enable",
                    'value' => 'not_empty'
                )
            );

            $data[$email['section']]['fields'][$email_key] = array(
                'type' => 'hint_textarea',
                'label' => esc_html__('Message', 'masterstudy-lms-learning-management-system-pro'),
                'value' => $email['message'],
                'hints' => $email['vars'],
                'dependency' => array(
                    'key' => "{$email_key}_enable",
                    'value' => 'not_empty'
                )
            );

            $data[$email['section']]['fields']["{$email_key}_notice"] = array(
                'type' => 'notice',
                //'label' => $email['notice'],
                'label' => '',
            );

        }

        return apply_filters('stm_lms_email_manager_settings', $data);
    }

    static function stm_lms_get_settings()
    {
        return get_option('stm_lms_email_manager_settings', array());
    }

    static function findReplace($string)
    {
        preg_match_all("~\{\{\s*(.*?)\s*\}\}~", $string, $values);

        return $values;
    }

}