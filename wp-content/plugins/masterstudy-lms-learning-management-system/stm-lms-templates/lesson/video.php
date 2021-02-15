<?php
/**
 *
 * @var $id
 */

$lesson_video_poster = get_post_meta($id,'lesson_video_poster', true);
$lesson_video_url = get_post_meta($id,'lesson_video_url', true);
$lesson_video = get_post_meta($id,'lesson_video', true);
if(!empty($lesson_video)){
    $uploaded_video = wp_get_attachment_url($lesson_video);
    $type = explode('.', $uploaded_video);
    $type = strtolower(end($type));
}

if(!empty($lesson_video_poster) and !empty($lesson_video_url)): ?>
    <div class="stm_lms_video" style="background: url('<?php echo esc_url(stm_lms_get_image_url($lesson_video_poster, 'full')); ?>');">
        <i class="stm_lms_play"></i>
        <iframe src="<?php echo esc_url($lesson_video_url); ?>" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>
    </div>
<?php endif;

if(!empty($uploaded_video)): ?>
    <video id="stm_lms_video"
           class="video-js"
           data-id="<?php echo esc_attr($id); ?>"
           poster="<?php if(!empty($lesson_video_poster)) echo esc_url(stm_lms_get_image_url($lesson_video_poster, 'full')); ?>"
           controls>
        <source src="<?php echo esc_url($uploaded_video); ?>" type='video/<?php echo esc_attr($type); ?>'>
    </video>
<?php endif; ?>
