<div class="add_items_nav">

    <div class="add_item_nav_title quiz"
         @click="tab = 'new_quiz'"
         v-bind:class="{'active' : tab === 'new_quiz'}">
        <?php STM_Metaboxes::print_svg('assets/svg/quiz.svg'); ?>
        <?php esc_html_e('Quiz questions', 'masterstudy-lms-learning-management-system'); ?>
    </div>

    <div class="add_item_nav_title question_bank"
         @click="tab = 'question_bank'"
         v-bind:class="{'active' : tab === 'question_bank'}">
        <i class="fa fa-stream"></i>
        <?php esc_html_e('Question bank', 'masterstudy-lms-learning-management-system'); ?>
    </div>

    <div class="add_item_nav_title search" @click="search = true;">
        <?php esc_html_e('Search', 'masterstudy-lms-learning-management-system'); ?>
    </div>

</div>