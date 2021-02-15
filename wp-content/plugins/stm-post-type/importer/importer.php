<?php
require_once($plugin_path . '/importer/helpers/content.php');
require_once($plugin_path . '/importer/helpers/theme_options.php');
require_once($plugin_path . '/importer/helpers/set_lms_content.php');
require_once($plugin_path . '/importer/helpers/slider.php');
require_once($plugin_path . '/importer/helpers/addons.php');
require_once($plugin_path . '/importer/helpers/widgets.php');
require_once($plugin_path . '/importer/helpers/set_content.php');
require_once($plugin_path . '/importer/helpers/set_hb_options.php');
require_once($plugin_path . '/importer/helpers/megamenu/config.php');

function stm_demo_import_content()
{

    if (current_user_can('manage_options')) {

        $layout = 'default';
        $builder = 'js_composer';

        if (!empty($_GET['demo_template'])) {
            $layout = sanitize_title($_GET['demo_template']);
        }

        if(!empty($_GET['builder'])) $builder = sanitize_title($_GET['builder']);

        update_option('stm_lms_layout', $layout);

        stm_theme_before_import_content($layout, $builder);

        /*Import content*/
        stm_theme_import_content($layout, $builder);

        /*Import products*/
        stm_import_products_content($layout, $builder);

        /*Import theme options*/
        stm_set_layout_options($layout);

        /*Import sliders*/
        stm_theme_import_sliders($layout);

        /*Import Widgets*/
        stm_theme_import_widgets($layout);

        /*Set menu and pages*/
        stm_set_content_options($layout, $builder);

        /*Set LMS Options*/
        stm_set_lms_options($layout);

        /*Addons*/
        stm_theme_enable_addons($layout);

        do_action('stm_masterstudy_importer_done');

        wp_send_json(array(
            'url' => get_home_url('/'),
            'title' => esc_html__('View site', 'stm-configurations'),
            'theme_options_title' => esc_html__('Theme options', 'stm-configurations'),
            'theme_options' => esc_url_raw(admin_url('admin.php?page=stm_option_options'))
        ));

        die();

    }

}

add_action('wp_ajax_stm_demo_import_content', 'stm_demo_import_content');


function masterstudy_get_post_types_for_elementor(){

    $field = array();

    $post_types_objects = get_post_types(
        [
            'public' => true,
        ], 'objects'
    );

    foreach ( $post_types_objects as $cpt_slug => $post_type ) {

        $field[ $cpt_slug ] = $post_type->labels->name;

    }

    unset($field['elementor_library']);
    unset($field['attachment']);

    return array_keys($field);
}

function stm_theme_before_import_content($layout, $builder) {
    if($builder === 'elementor') {

        /*Update Options Elementor*/
        update_option('elementor_cpt_support', masterstudy_get_post_types_for_elementor());
        update_option('elementor_disable_color_schemes', 'yes');
        update_option('elementor_disable_typography_schemes', 'yes');
        update_option('elementor_load_fa4_shim', 'yes');
        update_option('elementor_container_width', 1200);
        update_option('elementor_space_between_widgets', 0);

    }
}


add_action('stm_masterstudy_importer_done', 'elementor_set_default_settings', 15);
function elementor_set_default_settings(){
    $active_kit = intval(get_option( 'elementor_active_kit', 0 ));
    $meta = get_post_meta($active_kit, '_elementor_page_settings', true);

    if(!empty($active_kit)) {
    $meta = (!empty($meta)) ? $meta : array();
        $meta['container_width'] = array(
            'size' => '1200',
            'unit' => 'px',
            'sizes' => array(),
        );
        $meta['space_between_widgets']['size'] = array(
            'size' => '0',
            'unit' => 'px',
            'sizes' => array(),
        );
        update_post_meta($active_kit,'_elementor_page_settings',$meta);

        if(class_exists('Elementor\Core\Responsive\Responsive')) {
            Elementor\Core\Responsive\Responsive::compile_stylesheet_templates();
        }
    }


    global $wpdb;

    $from = trim('http://lmsdemo.loc');
    $to = get_site_url();

    $rows_affected = $wpdb->query(
        "UPDATE {$wpdb->postmeta} " .
        "SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from ) . "', '" . str_replace( '/', '\\\/', $to ) . "') " .
        "WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" ); // meta_value LIKE '[%' are json formatted

    if(class_exists('Elementor\Core\Responsive\Responsive')) {
        Elementor\Core\Responsive\Responsive::compile_stylesheet_templates();
    }
}


function stm_import_products_exclude_layouts(){
	return array(
		'default',
        'ms'
	);
}
