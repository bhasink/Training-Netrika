<?php
function stm_theme_import_content($layout, $builder = 'js_composer') {
	set_time_limit(0);

	if (!defined('WP_LOAD_IMPORTERS')) {
		define('WP_LOAD_IMPORTERS', true);
	}

	require_once(STM_POST_TYPE_PATH . '/importer/wordpress-importer/wordpress-importer.php');

	$wp_import = new WP_Import();
	$wp_import->fetch_attachments = true;

	if($builder == 'elementor') {
		$ready = prepare_demo($builder . '-' . $layout, $builder);
    } else {
        $ready = prepare_demo($layout);
    }

	if( $ready ){
		ob_start();
		$wp_import->import($ready, $layout);
		ob_end_clean();
	}
}


function prepare_demo( $layout, $builder = 'js_composer' ){

	if($builder == 'elementor') {
		if(defined('STM_DEV_MODE')) return STM_POST_TYPE_PATH . '/importer/demos/'. $builder . '/' . $layout . '.xml';
	} else {
	}

	$tempDir = get_temp_dir();
	$fzip = $tempDir . $layout .'.zip';
	$fxml = $tempDir . $layout .'.xml';

	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$response = wp_remote_get( get_package($layout, 'zip'), array('timeout' => 30) );
	if ( is_wp_error( $response ) ) {
		return false;
	}
	$body = wp_remote_retrieve_body( $response );

	// file_get_contents if body is empty.
	if ( empty( $body ) ) {
		if ( function_exists( 'ini_get' ) && ini_get( 'allow_url_fopen' ) ) {
			$body = @file_get_contents( get_package($layout, 'zip') );
		}
	}

	if ( ! $wp_filesystem->put_contents( $fzip , $body ) ) {
		@unlink( $fzip );
		$fp = @fopen( $fzip, 'w' );

		@fwrite( $fp, $body );
		@fclose( $fp );
	}

	if ( class_exists( 'ZipArchive' ) ) {
		$zip = new ZipArchive();
		if ( true === $zip->open( $fzip ) ) {
			$zip->extractTo( $tempDir );
			$zip->close();
			return $fxml;
		}
	}

	$unzip = unzip_file( $fzip, $tempDir );
	if($unzip){
		return $fxml;
	}

	return false;
}


function stm_import_products_content($layout, $builder = 'js_composer'){
	set_time_limit(0);

	$exclude_layouts = stm_import_products_exclude_layouts();

	if(in_array($layout,$exclude_layouts)) {
		return;
	}

	if (!defined('WP_LOAD_IMPORTERS')) {
		define('WP_LOAD_IMPORTERS', true);
	}

	require_once(STM_POST_TYPE_PATH . '/importer/wordpress-importer/wordpress-importer.php');

	$wp_import = new WP_Import();
	$wp_import->fetch_attachments = true;

	$ready = STM_POST_TYPE_PATH . '/importer/demos/products/'. $builder . '/demo.xml';

	if( $ready ){
		ob_start();
		$wp_import->import($ready, $layout);
		ob_end_clean();
	}

}


add_action('stm_masterstudy_importer_done', 'stm_masterstudy_importer_done');
function stm_masterstudy_importer_done(){
	$exclude_layouts = stm_import_products_exclude_layouts();

	if(in_array($layout,$exclude_layouts)) {
		return;
	}

	$options = get_option('stm_option', array());
	$options['enable_shop'] = '1';
	update_option('stm_option', $options);
}
