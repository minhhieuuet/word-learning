<template>
<modal name="category" height="auto" width="400px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">
     <div class="close-button-mobile" @click="cancel">
        <a-button type="danger" shape="circle" icon="close" />
    </div>

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

        <a-row>
            Chia sẻ
            <a-switch :checked="category.is_public" @change="onStatusChange" />
        </a-row>

        <a-row style="margin-top: 20px;">
            Ảnh bìa
            <vue-dropzone ref="myVueDropzone" :style="{backgroundImage: `url(${oldCover})`}" id="dropzone" accepted-file-types=".jpg,.png,.jpeg" :options="dropzoneOptions" @vdropzone-success="uploadSuccess" @vdropzone-complete="afterComplete">

            </vue-dropzone>
        </a-row>

    </div>
    <div class="mobile-btn-group">
        <a-button type="primary" size="large" block @click="submit">
            Lưu
        </a-button>
        <a-button type="dashed" size="large" block @click="cancel">
            Thoát
        </a-button>
    </div>
    <div class="md-right pc-btn-group">
        <a-button type="primary" @click="submit">
            {{editingId ? 'Lưu' : 'Thêm'}}
        </a-button>
        <a-button type="dashed" @click="cancel">Bỏ qua</a-button>
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
            oldCover: '',
            category: {
                title: '',
                cover: '',
                is_public: false,
            },
            dropzoneOptions: {
                url: `${window.location.origin}/api/image/store`,
                thumbnailWidth: null,
                maxFiles: 1,
                maxFilesize: 100000,
                addRemoveLinks: true,
                headers: {
                    "My-Awesome-Header": "header value"
                },
                dictDefaultMessage: 'Nhấn vào đây hoặc kéo ảnh vào để tải lên',
            }
        }
    },
    methods: {
        beforeOpen(event) {
            this.title = event.params.title;
            if (event.params.categoryId) {
                this.editingId = event.params.categoryId;
                rf.getRequest('CategoryRequest').getCategory(this.editingId).then((category) => {
                    this.oldCover = category.cover;
                    this.category = category;
                });
            }
        },
        beforeClose() {
            this.editingId = '';
            this.oldCover = '';
            this.category = {
                is_public: false
            };
        },
        afterComplete(file, response) {
            // console.log(response);
        },
        uploadSuccess(file, response) {
            this.category.cover = response;
            document.getElementById('dropzone').style.backgroundImage = '';
        },
        onStatusChange(isPublic) {
            this.category.is_public = isPublic;
        },
        async submit() {
            if(this.editingId) {
                this.updateCategory();
                return;
            }
            this.createOneCategory();
        },
        updateCategory() {
            rf.getRequest('CategoryRequest').update(this.editingId, this.category).then((res) => {
                this.$modal.hide('category');
                this.$message.success('Cập nhật thành công');
                this.$emit('refresh');
            }).catch((err) => {
                this.$message.error('Đã có lỗi xảy ra, vui lòng thử lại');
            });
        },
        createOneCategory() {
            rf.getRequest('CategoryRequest').store(this.category).then((res) => {
                this.$modal.hide('category');
                this.$message.success('Tạo danh mục thành công');
                this.$emit('refresh');
            }).catch((err) => {
                this.$message.error('Đã có lỗi xảy ra, vui lòng thử lại');
            });
        },
        cancel() {
            this.$modal.hide('category');
        }
    }
}
</script>

<style lang="scss" scoped>
@media screen and (max-width: 900px) {

    .styles__container___16een {
        min-width: 10rem !important;
    }
}

#dropzone {
    background-size: cover;
}

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
