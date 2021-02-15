Vue.component('questions_image', {
    props: ['item'],
    data() {
        return {
            loading : false,
            error : '',
        };
    },
    mounted: function () {

    },
    methods: {
        handleFileChange(e) {
            var _this = this;
            console.log(e.target.files);
            if (e.target.files.length) {
                var file = e.target.files[0];
                _this.error = '';
                _this.loading = true;

                var formData = new FormData();
                formData.append('file', file);

                var url = stm_wpcfto_ajaxurl + '?action=stm_lms_question_2_upload_image';

                _this.$http.post(url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (r) {
                    r = r.body;
                    _this.loading = false;

                    console.log(r);

                    if(r.error) {
                        _this.error = r.error;
                    } else {
                        _this.$set(_this.item, 'image', {id : r.id, url : r.url})
                    }
                });

            }
        },
        hasImage : function() {
            return (typeof this.item.image !== 'undefined' && this.item.image.id);
        }
    },
    computed: {

    },
});