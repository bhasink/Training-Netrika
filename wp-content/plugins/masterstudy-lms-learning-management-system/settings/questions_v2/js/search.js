Vue.component('questions_search', {
    props: ['items'],
    data() {
        return {
            opened: false,
            search: '',
            loading: false,
            excludeIDs: [],
            searchList: [],
            timer: false
        };
    },
    mounted: function () {

        (function ($) {
            $('html').addClass('curriculum-search-activated');
        })(jQuery);

        this.$refs['curriculum_search'].focus();

        this.getExcludedIDs();

        this.searchItems();

    },
    destroyed: function () {
        (function ($) {
            $('html').removeClass('curriculum-search-activated');
        })(jQuery);
    },
    methods: {
        selectItem: function (item, item_key) {
            var _this = this;

            if (typeof item.selected === 'undefined') {
                _this.$set(item, 'selected', true);
                return false;
            }

            _this.$set(item, 'selected', !item.selected);

        },
        addItems: function () {

            var _this = this;

            _this.searchList.forEach(function (item) {
                if (item.selected) _this.items.push(item);
            });

            _this.getExcludedIDs();

            _this.$emit('close_popup');
        },
        searchingItems: function () {
            var _this = this;

            clearTimeout(_this.timer);

            _this.timer = setTimeout(function () {

                _this.searchItems();

            }, 600);
        },
        searchItems: function () {
            var _this = this;
            var url = stm_lms_ajaxurl + '?action=stm_curriculum&exclude_ids=' + this.excludeIDs.join(',') + '&s=' + this.search;
            url += '&only_items=true&post_types=stm-questions';
            url += '&nonce=' + stm_wpcfto_nonces['stm_curriculum'];

            _this.loading = true;

            _this.$http.get(url).then(function (response) {
                _this.loading = false;
                _this.$set(_this, 'searchList', response.body);
            });
        },
        getExcludedIDs: function () {
            var _this = this;

            _this.excludeIDs = [];

            _this.items.forEach(function (item) {
                _this.excludeIDs.push(item.id);
            });

            _this.excludeIDs = _this.unique(_this.excludeIDs);

        },
        unique: function (array) {
            return array.filter(function (el, index, arr) {
                return index === arr.indexOf(el);
            });
        },
        countSelected: function (text) {
            var count = this.searchListFiltered.length;
            if (!count) count = '';
            return text.replace('{x}', count);
        }
    },
    computed: {
        searchListFiltered() {
            var _this = this;

            _this.getExcludedIDs();

            return _this.searchList.filter(function (item) {
                if (item.selected) return item;
            });
        },
    },
    // watch : {
    //     sections : {
    //         deep : true,
    //         handler : function() {
    //             this.getExcludedIDs();
    //         }
    //     },
    // }
});