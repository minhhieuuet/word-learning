<template>
<modal name="category" height="auto" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">

    <div class="content">
        <div slot="top-right">
        </div>
        <span class="md-title">{{title}}</span>

        <md-field>
            <label>Tiêu đề</label>
            <md-input type="text" :name="`${_uid}_name`" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="category.title" :class="errors.has(`general.${_uid}_title`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            <div v-if="errors.has(`general.${_uid}_name`)">
                <md-icon class="md-accent">warning</md-icon>
                {{errors.first(`general.${_uid}_name`)}}
            </div>
        </md-field>

        <md-field>
            <label>Tiêu đề</label>
            <md-input type="text" :name="`${_uid}_name`" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="category.title" :class="errors.has(`general.${_uid}_title`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            <div v-if="errors.has(`general.${_uid}_name`)">
                <md-icon class="md-accent">warning</md-icon>
                {{errors.first(`general.${_uid}_name`)}}
            </div>
        </md-field>

    </div>

    <div class="md-right">
        <md-button class="md-raised md-primary" @click="submit">Thêm</md-button>
        <md-button class="md-raised md-accent" @click="cancel">Bỏ qua</md-button>
    </div>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
    data() {
        return {
            title: 'Category',
            editingId: '',
            category: {
                title: '',
                image: '',
                active: false,
            }
        }
    },
    methods: {
        beforeOpen(event) {
            this.title = event.params.title;
            if (event.params.categoryId) {
                this.editingId = event.params.categoryId;
                rf.getRequest('CategoryRequest').show(this.editingId).then((category) => {
                    this.category = category;
                });
            }
        },
        beforeClose() {
            this.editingId = '';
            this.isEditPassword = false,
                this.category = {
                    name: '',
                    full_name: '',
                    email: '',
                };
        },
        async submit() {
            Promise.all([
                this.$validator.validateAll('general'),
            ]).then(() => {
                if (this.errors.any()) {
                    return;
                }
                if (this.editingId) {
                    this.updateOneCategory();
                } else {
                    this.createOneCategory();
                }
            });
        },
        updateOneCategory() {
            let params = this.category;
            if (!this.isEditPassword) {
                params = {};
                params.name = this.category.name;
                params.full_name = this.category.full_name;
                params.email = this.category.email;
            }
            rf.getRequest('CategoryRequest').update(this.editingId, params).then((res) => {
                this.$modal.hide('category');
                this.$emit('refresh');
            });
            this.$toasted.show('Cập nhật sinh viên thành công!', {
                theme: 'bubble',
                position: 'top-right',
                duration: 1500,
                type: 'success'
            });
        },
        createOneCategory() {
            rf.getRequest('CategoryRequest').store(this.category).then((res) => {
                this.$modal.hide('category');
                this.$emit('refresh');
            }).catch((err) => {
                // this.$toasted.show('Đã có lỗi xảy ra, vui lòng kiểm tra lại!', {
                //   theme: 'bubble',
                //   position: 'top-right',
                //   duration : 1500,
                //   type: 'danger'
                // });
            });
        },
        cancel() {
            this.$modal.hide('category');
        }
    }
}
</script>

<style lang="scss" scoped>
.content {
    padding: 30px 30px 10px 30px;
}

.md-right {
    float: right;
    padding: 0px 10px 20px;
}

.top-right {
    float: right;
}

.red-outline {
    border: 1px solid red;
}
</style>
