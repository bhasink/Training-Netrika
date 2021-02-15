<?php

/**
 * @var $course_id
 */

$total_progress = STM_LMS_Lesson::get_total_progress( get_current_user_id(), $course_id );

if( !empty( $total_progress ) and $total_progress[ 'course_completed' ] ):
    stm_lms_register_style( 'lesson/total_progress' );
    if( class_exists( 'STM_LMS_Certificate_Builder' ) ){
        wp_register_script( 'jspdf', STM_LMS_URL . '/assets/vendors/jspdf.umd.js', array(), stm_lms_custom_styles_v() );
        wp_enqueue_script( 'stm_generate_certificate', STM_LMS_URL . '/assets/js/certificate_builder/generate_certificate.js', array( 'jspdf' ), stm_lms_custom_styles_v() );
    }
    ?>

    <div class="stm_lms_course_completed_summary">

        <div class="stm_lms_course_completed_summary__title">
            <span><?php esc_html_e( 'You have completed the course:', 'masterstudy-lms-learning-management-system' ); ?></span>
            <strong><?php printf( esc_html__( "Score %s", 'masterstudy-lms-learning-management-system' ), "{$total_progress['course']['progress_percent']}%" ); ?></strong>
        </div>

        <div class="stm_lms_finish_score">

            <div class="stm_lms_finish_score__stats">

                <?php foreach( $total_progress[ 'curriculum' ] as $item_type => $item_data ): ?>

                    <?php if( $item_type === 'lesson' ): ?>
                        <div class="stm_lms_finish_score__stat">
                            <div class="stm_lms_finish_score__stat_<?php echo esc_attr( $item_type ); ?>">
                                <i class="far fa-file-alt"></i>
                                <span><?php esc_html_e( 'Pages:', 'masterstudy-lms-learning-management-system' ); ?>
                                    <strong><?php echo esc_html( "{$item_data['completed']}/{$item_data['total']}" ) ?></strong></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if( $item_type === 'multimedia' ): ?>
                        <div class="stm_lms_finish_score__stat">
                            <div class="stm_lms_finish_score__stat_<?php echo esc_attr( $item_type ); ?>">
                                <i class="far fa-play-circle"></i>
                                <span><?php esc_html_e( 'Multimedia:', 'masterstudy-lms-learning-management-system' ); ?>
                                    <strong><?php echo esc_html( "{$item_data['completed']}/{$item_data['total']}" ) ?></strong></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if( $item_type === 'quiz' ): ?>
                        <div class="stm_lms_finish_score__stat">
                            <div class="stm_lms_finish_score__stat_<?php echo esc_attr( $item_type ); ?>">
                                <i class="far fa-question-circle"></i>
                                <span><?php esc_html_e( 'Quizzes:', 'masterstudy-lms-learning-management-system' ); ?>
                                    <strong><?php echo esc_html( "{$item_data['completed']}/{$item_data['total']}" ) ?></strong></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if( $item_type === 'assignment' ): ?>
                        <div class="stm_lms_finish_score__stat">
                            <div class="stm_lms_finish_score__stat_<?php echo esc_attr( $item_type ); ?>">
                                <i class="fa fa-spell-check"></i>
                                <span><?php esc_html_e( 'Assignments:', 'masterstudy-lms-learning-management-system' ); ?>
                                    <strong><?php echo esc_html( "{$item_data['completed']}/{$item_data['total']}" ) ?></strong></span>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

        </div>

    </div>
    <?php if( class_exists( 'STM_LMS_Certificate_Builder' ) ): ?>
        <a href="#"
           class="stm_lms_course_completed_summary__certificate stm_preview_certificate"
           data-course-id="<?php echo esc_attr( $course_id ); ?>">
            <i class="fa fa-cloud-download-alt"></i>
            <?php esc_html_e( 'Download your Certificate', 'masterstudy-lms-learning-management-system' ); ?>
        </a>
    <?php else: ?>
        <a href="<?php echo esc_url( $total_progress[ 'certificate_url' ] ) ?>"
           class="stm_lms_course_completed_summary__certificate" target="_blank">
            <i class="fa fa-cloud-download-alt"></i>
            <?php esc_html_e( 'Download your Certificate', 'masterstudy-lms-learning-management-system' ); ?>
        </a>
    <?php endif; ?>
<?php endif;