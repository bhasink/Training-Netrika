<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
STM_LMS_Templates::show_lms_template('vc_templates/templates/stm_lms_courses_grid', $atts);
