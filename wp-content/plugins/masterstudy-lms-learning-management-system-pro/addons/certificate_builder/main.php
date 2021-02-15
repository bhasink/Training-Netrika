<?php
new STM_LMS_Certificate_Builder;

class STM_LMS_Certificate_Builder
{

    function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ), 10 );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'wp_ajax_stm_get_certificates', array( $this, 'get_certificates' ) );
        add_action( 'wp_ajax_stm_get_certificate_fields', array( $this, 'get_fields' ) );
        add_action( 'wp_ajax_stm_save_certificate', array( $this, 'save_certificate' ) );
        add_action( 'wp_ajax_stm_get_certificate', array( $this, 'get_certificate' ) );
        add_action( 'wp_ajax_stm_delete_certificate', array( $this, 'delete_certificate' ) );
        add_action( 'wp_ajax_stm_get_certificate_categories', array( $this, 'get_categories' ) );
        add_action( 'init', array( $this, 'demo_import' ), 10 );
    }

    function admin_menu()
    {
        add_menu_page( esc_html__( 'Certificate Builder', 'masterstudy-lms-learning-management-system-pro' ), esc_html__( 'Certificate Builder', 'masterstudy-lms-learning-management-system-pro' ), 'manage_options', 'certificate_builder', array( $this, 'admin_page' ), 'dashicons-awards', 40 );
    }

    function admin_page()
    {
        $translations = array(
            'text' => esc_html__( 'Text', 'masterstudy-lms-learning-management-system-pro' ),
            'course_name' => esc_html__( 'Course name', 'masterstudy-lms-learning-management-system-pro' ),
            'student_name' => esc_html__( 'Student name', 'masterstudy-lms-learning-management-system-pro' ),
            'image' => esc_html__( 'Image', 'masterstudy-lms-learning-management-system-pro' ),
            'author' => esc_html__( 'Author', 'masterstudy-lms-learning-management-system-pro' ),
        );

        wp_enqueue_style( 'stm_certificate_builder', STM_LMS_URL . '/assets/css/parts/certificate_builder/main.css', false, stm_lms_custom_styles_v() );
        wp_enqueue_style( 'stm_certificate_fonts', 'https://fonts.googleapis.com/css?family=Katibeh|Merriweather:400,700|Montserrat:400,700|Open+Sans:400,700|Oswald:400,700', false, stm_lms_custom_styles_v() );
        wp_register_script( 'jspdf', STM_LMS_URL . '/assets/vendors/jspdf.umd.js', array(), stm_lms_custom_styles_v() );
        wp_enqueue_script( 'stm_generate_certificate', STM_LMS_URL . '/assets/js/certificate_builder/generate_certificate.js', array( 'jquery', 'jspdf' ), stm_lms_custom_styles_v() );
        wp_enqueue_script( 'stm_certificate_builder', STM_LMS_URL . '/assets/js/certificate_builder/main.js', array( 'jquery', 'vue.js', 'vue-resource.js' ), stm_lms_custom_styles_v() );
        wp_localize_script( 'stm_certificate_builder', 'stm_translations', $translations );
        require_once STM_LMS_PRO_PATH . '/addons/certificate_builder/templates/main.php';
    }

    static function register_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => esc_html__( 'Certificates', 'masterstudy-lms-learning-management-system-pro' ),
                'singular_name' => esc_html__( 'Certificate', 'masterstudy-lms-learning-management-system-pro' ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'supports' => array( 'title', 'thumbnail' ),
        );

        register_post_type( 'stm-certificates', $args );
    }

    function get_fields()
    {
        check_ajax_referer( 'stm_get_certificate_fields', 'nonce' );
        $fields = array(
            'text' => array(
                'name' => esc_html__( 'Text', 'masterstudy-lms-learning-management-system-pro' ),
                'value' => esc_html__( 'Any text', 'masterstudy-lms-learning-management-system-pro' )
            ),
            'course_name' => array(
                'name' => esc_html__( 'Course name', 'masterstudy-lms-learning-management-system-pro' ),
                'value' => '-Course Name-'
            ),
            'student_name' => array(
                'name' => esc_html__( 'Student name', 'masterstudy-lms-learning-management-system-pro' ),
                'value' => '-Student Name-'
            ),
            'image' => array(
                'name' => esc_html__( 'Image', 'masterstudy-lms-learning-management-system-pro' ),
                'value' => ''
            ),
            'author' => array(
                'name' => esc_html__( 'Instructor', 'masterstudy-lms-learning-management-system-pro' ),
                'value' => '-Instructor-'
            )
        );

        wp_send_json( apply_filters( 'stm_certificates_fields', $fields ) );

    }

    function save_certificate()
    {
        check_ajax_referer( 'stm_save_certificate', 'nonce' );
        if( !empty( $_POST[ 'certificate' ] ) ) {
            $certificate = $_POST[ 'certificate' ];
            $args = array(
                'post_title' => !empty( $certificate[ 'title' ] ) ? wp_strip_all_tags( $certificate[ 'title' ] ) : esc_html__( 'New template', 'masterstudy-lms-learning-management-system-pro' ),
                'post_type' => 'stm-certificates',
                'post_status' => 'publish',
            );
            if( !empty( $certificate[ 'id' ] ) ) {
                $post_id = intval( $certificate[ 'id' ] );
            }
            else {
                $post_id = wp_insert_post( wp_slash( $args ) );
            }

            if( !empty( $certificate[ 'thumbnail_id' ] ) ) {
                set_post_thumbnail( $post_id, intval( $certificate[ 'thumbnail_id' ] ) );
            }

            $orientation = !empty( $certificate[ 'data' ][ 'orientation' ] ) ? sanitize_text_field( $certificate[ 'data' ][ 'orientation' ] ) : 'landscape';
            $fields = !empty( $certificate[ 'data' ][ 'fields' ] ) ? json_encode( $certificate[ 'data' ][ 'fields' ], JSON_UNESCAPED_UNICODE ) : '';
            $category = !empty( $certificate[ 'data' ][ 'category' ] ) ? sanitize_text_field( $certificate[ 'data' ][ 'category' ] ) : '';
            update_post_meta( $post_id, 'stm_orientation', $orientation );
            update_post_meta( $post_id, 'stm_fields', $fields );
            update_post_meta( $post_id, 'stm_category', $category );
            $r = array(
                'id' => $post_id
            );
            wp_send_json( $r );
        }
    }

    function get_certificates()
    {
        check_ajax_referer( 'stm_get_certificates', 'nonce' );
        $args = array(
            'post_type' => 'stm-certificates',
            'posts_per_page' => -1
        );
        $r = array();
        $q = new WP_Query( $args );
        if( $q->have_posts() ) {
            while ( $q->have_posts() ) {
                $q->the_post();
                $id = get_the_ID();
                $certificate = array();
                $certificate[ 'id' ] = $id;
                $certificate[ 'title' ] = get_the_title();
                $certificate[ 'thumbnail_id' ] = get_post_thumbnail_id( $id );
                $certificate[ 'thumbnail' ] = get_the_post_thumbnail_url( $id, 'thumbnail' );
                $certificate[ 'image' ] = get_the_post_thumbnail_url( $id, 'full' );
                $filename = '';
                if( !empty( $certificate[ 'thumbnail_id' ] ) ) {
                    $filename = basename( get_attached_file( $certificate[ 'thumbnail_id' ] ) );
                }
                $certificate[ 'filename' ] = $filename;
                $orientation = get_post_meta( $id, 'stm_orientation', true );
                $fields = get_post_meta( $id, 'stm_fields', true );
                $category = get_post_meta( $id, 'stm_category', true );
                if( empty( $fields ) ) {
                    $fields = array();
                }
                else {
                    $fields = json_decode( $fields, true );
                }
                if( empty( $orientation ) ) {
                    $orientation = 'landscape';
                }
                $data = array(
                    'orientation' => $orientation,
                    'fields' => $fields,
                    'category' => $category,
                );
                $certificate[ 'data' ] = $data;
                $r[] = $certificate;
            }
        }
        wp_reset_postdata();
        wp_send_json( $r );
    }

    function get_categories()
    {
        check_ajax_referer( 'stm_get_certificate_categories', 'nonce' );
        $r = array();
        $terms = get_terms( [
            'taxonomy' => 'stm_lms_course_taxonomy',
            'hide_empty' => false,
        ] );

        foreach( $terms as $term ) {
            $r[] = array(
                'id' => $term->term_id,
                'name' => $term->name
            );
        }
        wp_send_json( $r );
    }

    function get_certificate()
    {
        check_ajax_referer( 'stm_get_certificate', 'nonce' );
        $id = '';
        $course_id = '';
        if( !empty( $_GET[ 'course_id' ] ) && $_GET[ 'course_id' ] ) {
            $course_id = intval( $_GET[ 'course_id' ] );
            $terms = wp_get_post_terms( $course_id, 'stm_lms_course_taxonomy', array( 'fields' => 'ids' ) );
            $meta_query = array(
                'relation' => 'OR'
            );
            foreach( $terms as $term ) {
                $meta_query[] = array(
                    'key' => 'stm_category',
                    'value' => $term
                );
            }
            $meta_query[] = array(
                'key' => 'stm_category',
                'value' => 'entire_site'
            );
            $args = array(
                'post_type' => 'stm-certificates',
                'posts_per_page' => 1,
                'meta_query' => $meta_query,
            );

            $query = new WP_Query( $args );
            if( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $id = get_the_ID();
                }
            }
            wp_reset_postdata();
        }
        if( empty( $id ) && !empty( $_GET[ 'post_id' ] ) ) {
            $id = intval( $_GET[ 'post_id' ] );
        }

        if( !empty( $id ) ) {
            $certificate = array();
            $orientation = get_post_meta( $id, 'stm_orientation', true );
            $fields = get_post_meta( $id, 'stm_fields', true );
            $image = get_the_post_thumbnail_url( $id, 'full' );

            if( empty( $fields ) ) {
                $fields = array();
            }
            else {
                $fields = json_decode( $fields, true );
            }
            if( empty( $orientation ) ) {
                $orientation = 'landscape';
            }
            $base64 = false;
            $image_size = false;
            if( $image ) {
                $type = pathinfo( $image, PATHINFO_EXTENSION );
                $image_data = file_get_contents( $image );
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode( $image_data );
                $image_size = getimagesizefromstring( $image_data );
            }
            $fields_with_data = array();
            foreach( $fields as $field ) {
                if( $field[ 'type' ] === 'image' && !empty( $field[ 'content' ] ) ) {
                    $field[ 'image_data' ] = $this->encode_base64( $field[ 'content' ] );
                }
                else if( $field[ 'type' ] === 'course_name' && !empty( $course_id ) ) {
                    $field[ 'content' ] = get_the_title( $course_id );
                }
                else if( $field[ 'type' ] === 'author' && !empty( $course_id ) ) {
                    $author = get_post_field( 'post_author', $course_id );
                    $author_name = get_the_author_meta( 'display_name', $author );
                    $field[ 'content' ] = $author_name;
                }
                else if( $field[ 'type' ] === 'student_name' && !empty( $course_id ) ) {
                    $current_user = wp_get_current_user();
                    if( !empty( $current_user ) ) {
                        $field[ 'content' ] = $current_user->display_name;
                    }
                }
                $fields_with_data[] = $field;
            }
            $data = array(
                'orientation' => $orientation,
                'fields' => $fields_with_data,
                'image' => $base64,
                'image_size' => $image_size,
            );
            $certificate[ 'data' ] = $data;
            wp_send_json( $certificate );
        }
    }

    function encode_base64( $image_url )
    {
        $type = pathinfo( $image_url, PATHINFO_EXTENSION );
        $image_data = file_get_contents( $image_url );
        return 'data:image/' . $type . ';base64,' . base64_encode( $image_data );
    }

    function delete_certificate()
    {
        if( !empty( $_GET[ 'certificate_id' ] ) ) {
            wp_delete_post( intval( $_GET[ 'certificate_id' ] ), true );
            wp_send_json( 'deleted' );
        }
    }

    function demo_import()
    {
        $is_imported = get_option( 'stm_lms_certificates_imported', '' );

        if( empty( $is_imported ) ) {

            $landscape_bg_id = $this->upload_image(STM_LMS_PRO_PATH . '/addons/certificate_builder/assets/images/demo-1.png');
            $portrait_bg_id = $this->upload_image(STM_LMS_PRO_PATH . '/addons/certificate_builder/assets/images/demo-2.png');
            $logo_id = $this->upload_image(STM_LMS_PRO_PATH . '/addons/certificate_builder/assets/images/logo.png');
            $sign_id = $this->upload_image(STM_LMS_PRO_PATH . '/addons/certificate_builder/assets/images/sign.png');
            $logo_url = wp_get_attachment_url($logo_id);
            $sign_url = wp_get_attachment_url($sign_id);
            $demos = array(
                array(
                    'post_title' => 'Demo 1',
                    'image' => $landscape_bg_id,
                    'stm_orientation' => 'landscape',
                    'stm_category' => '',
                    'stm_fields' => '[{"type":"image","content":"'. $logo_url . '","x":"411","y":"58","w":"79","h":"72","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":""},"imageId":"1404"},{"type":"text","content":"CERTIFICATE","x":"0","y":"149","w":"900","h":"71","styles":{"fontSize":"60px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":"true"}},{"type":"student_name","content":"-Student Name-","x":"0","y":"242","w":"900","h":"50","styles":{"fontSize":"28px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":"true"}},{"type":"course_name","content":"-Course Name-","x":"203","y":"380","w":"494","h":"50","styles":{"fontSize":"20px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"text","content":"Lorem ipsum dolor sit amet,  tempor incididunt ut labore et dolore. Successfully completed courses in:","x":"194","y":"312","w":"512","h":"50","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"text","content":"Instructor","x":"201","y":"482","w":"150","h":"27","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"author","content":"-Instructor-","x":"201","y":"464","w":"250","h":"23","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":"true"}},{"type":"image","content":"'. $sign_url . '","x":"497","y":"430","w":"107","h":"107","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":""},"imageId":"1405"}]'
                ),
                array(
                    'post_title' => 'Demo 2',
                    'image' => $portrait_bg_id,
                    'stm_orientation' => 'portrait',
                    'stm_category' => '',
                    'stm_fields' => '[{"type":"text","content":"CERTIFICATE","x":"51","y":"212","w":"498","h":"80","styles":{"fontSize":"60px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":"true"}},{"type":"image","content":"'. $logo_url . '","x":"260","y":"75","w":"90","h":"83","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":""},"imageId":"1404"},{"type":"student_name","content":"-Student Name-","x":"123","y":"322","w":"363","h":"50","styles":{"fontSize":"32px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"text","content":"Lorem ipsum dolor sit amet,  tempor incididunt ut labore et dolore. Successfully completed courses in:","x":"92","y":"387","w":"430","h":"50","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"course_name","content":"-Course Name-","x":"163","y":"445","w":"286","h":"50","styles":{"fontSize":"24px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"center","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"text","content":"Istructor","x":"126","y":"576","w":"150","h":"33","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":""}},{"type":"author","content":"-Instructor-","x":"126","y":"553","w":"223","h":"34","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":"true"}},{"type":"image","content":"'. $sign_url . '","x":"345","y":"522","w":"132","h":"138","styles":{"fontSize":"14px","fontFamily":"Montserrat","color":{"hex":"#000"},"textAlign":"left","textDecoration":"","fontStyle":"","fontWeight":""},"imageId":"1405"}]'
                )
            );

            foreach($demos as $demo) {
                $post_data = array(
                    'post_title' => sanitize_text_field($demo['post_title']),
                    'post_type' => 'stm-certificates',
                    'post_status' => 'publish',
                );
                $post_id = wp_insert_post( wp_slash( $post_data ) );
                set_post_thumbnail( $post_id, $demo['image'] );
                update_post_meta($post_id, 'stm_orientation', $demo['stm_orientation']);
                update_post_meta($post_id, 'stm_category', $demo['stm_category']);
                update_post_meta($post_id, 'stm_fields', $demo['stm_fields']);
            }
            update_option( 'stm_lms_certificates_imported', '1' );
        }
    }

    function upload_image($path = '')
    {

        global $wp_filesystem;

        if( empty( $wp_filesystem ) ) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $upload_dir = wp_upload_dir();

        $image_data = $wp_filesystem->get_contents( $path );

        $filename = basename( $path );

        if( wp_mkdir_p( $upload_dir[ 'path' ] ) ) {
            $file = $upload_dir[ 'path' ] . '/' . $filename;
        }
        else {
            $file = $upload_dir[ 'basedir' ] . '/' . $filename;
        }
        $wp_filesystem->put_contents( $file, $image_data, FS_CHMOD_FILE );

        $wp_filetype = wp_check_filetype( $filename, null );

        $attachment = array(
            'post_mime_type' => $wp_filetype[ 'type' ],
            'post_title' => sanitize_file_name( $filename ),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $file );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        $placeholder = $attach_id;
        return $placeholder;
    }
}