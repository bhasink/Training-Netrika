<div class="add_item" v-if="tab === 'new_quiz'">

    <div class="stm_lms_add_new_question">

        <div class="question_types_input">

            <div class="question_types_input_label">
                <span v-html="choices[add_new_question_type]"></span>
                <i class="fa fa-chevron-down"></i>

                <div class="question_types_wrapper">
                    <div class="question_types">
                        <div class="question_type"
                             v-for="(choice_label, choice_key) in choices"
                             v-html="choice_label"
                             v-bind:class="{'active' : add_new_question_type === choice_key}"
                             @click="add_new_question_type = choice_key">
                        </div>
                    </div>
                </div>
            </div>

            <input type="text"
                   v-model="add_new_question"
                   @keydown.enter.prevent="createQuestion()"
                   v-bind:placeholder="'<?php esc_html_e('Enter question title', 'wp-custom-fields-theme-options'); ?>'"/>

        </div>

        <a href="#"
           class="add_question_button"
           @click.prevent="createQuestion()">
            <span>
                <?php esc_html_e('Add question', 'wp-custom-fields-theme-options'); ?>
            </span>
        </a>

    </div>

</div>