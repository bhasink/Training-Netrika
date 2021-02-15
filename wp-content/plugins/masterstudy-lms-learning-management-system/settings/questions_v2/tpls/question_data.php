<div class="section_data" v-if="typeof item !== 'undefined'">

    <div class="section_data__title">
        <i class="fa fa-chevron-down" v-if="item.opened" @click="$set(item, 'opened', false)"></i>
        <i class="fa fa-chevron-up" @click="$set(item, 'opened', true)" v-else></i>

        <input type="text"
               v-model="items[item_key]['title']"
               v-bind:size="items[item_key]['title'].length + 2"
               @blur="changeTitle(item.id, items[item_key]['title'], item_key)">
    </div>


    <div class="section_data__actions">

        <div class="question_types_input" v-if="typeof choices[item.type] !== 'undefined'">

            <div class="question_types_input_label">
                <span v-html="choices[item.type]"></span>
                <i class="fa fa-chevron-down"></i>

                <div class="question_types_wrapper">
                    <div class="question_types">
                        <div class="question_type"
                             v-for="(choice_label, choice_key) in choices"
                             v-html="choice_label"
                             v-bind:class="{'active' : item.type === choice_key}"
                             @click="$set(item, 'type', choice_key)">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="question_image" v-bind:class="{'opened' : typeof item.image_opened !== 'undefined' && item.image_opened, 'filled' : typeof item.image !== 'undefined' && item.image.id}">
            <div class="question_image__btn" @click="$set(item, 'image_opened', !item.image_opened)">
                <img :src="item.image.url" v-if="typeof item.image !== 'undefined' && item.image.url">
                +<i class="fa fa-image"></i>
            </div>

            <div class="question_image__popup_wrapper" v-if="item.image_opened">
                <?php stm_lms_questions_v2_load_template('image'); ?>
            </div>

        </div>

        <div class="question_delete"
             @click="deleteQuestion(item_key, '<?php esc_attr_e('Do you really want to delete this question?', 'masterstudy-lms-learning-management-system') ?>')">
            <i class="fa fa-trash"></i>
        </div>

        <div class="question_move">
            <?php STM_LMS_Helpers::print_svg('settings/curriculum/images/dots.svg'); ?>
        </div>

    </div>

</div>