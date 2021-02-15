<div class="section_items" v-if="item.opened">

    <stm-answers v-bind:choice="item['type']"
                 v-bind:origin="item_key"
                 v-bind:stored_answers="item['answers']"
                 v-on:get-answers="$set(item, 'answers', $event)"></stm-answers>

</div>