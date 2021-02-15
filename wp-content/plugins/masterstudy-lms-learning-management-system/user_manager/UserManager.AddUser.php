<?php

new STM_LMS_User_Manager_Add_User();

class STM_LMS_User_Manager_Add_User
{

    public function __construct()
    {

        add_action('wp_ajax_stm_lms_dashboard_add_user_to_course', array($this, 'add_user'));

    }

    function add_user()
    {

        $request_body = file_get_contents('php://input');

        $data = json_decode($request_body, true);

        if (empty($data['email'])) die;

        $email = sanitize_text_field($data['email']);
        $course_id = intval($data['course_id']);
        $course_title = get_the_title($course_id);

        if (!is_email($email)) {
            wp_send_json(array(
                'status' => 'error',
                'message' => esc_html__('Enter valid email', 'masterstudy-lms-learning-management-system')
            ));
        }

        $adding = STM_LMS_Instructor::_add_student_to_course(array($course_id), array($email));

        if (!$adding['error']) {
            $adding['status'] = 'success';
        }

        /*Send letter*/
        $message = sprintf(esc_html__('Course %s is now available to learn.', 'masterstudy-lms-learning-management-system'), $course_title);

        STM_LMS_Mails::send_email(
            'Course added.',
            $message,
            $email,
            array(),
            'stm_lms_course_available_for_user',
            compact('course_title')
        );

        wp_send_json($adding);

    }

}