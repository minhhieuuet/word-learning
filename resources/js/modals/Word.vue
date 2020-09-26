<template>
<modal name="word" height="auto" width="400px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">

    <div class="close-button-mobile" @click="cancel">
        <a-button type="danger" shape="circle" icon="close" />
    </div>

    <div class="content">
        <div slot="top-right">
        </div>
        <span class="md-title">{{title}}</span>

        <md-field>
            <label>Từ</label>
            <md-input type="text" :name="`${_uid}_word`" @keyup.enter="translate()" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="word.word" :class="errors.has(`general.${_uid}_word`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            <a-tooltip @click="translate()">
                <template slot="title">
                    Nhấn để dịch
                </template>
                <md-icon style="cursor: pointer;">translate</md-icon>
            </a-tooltip>
        </md-field>
        <div v-if="errors.has(`general.${_uid}_word`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_word`)}}
        </div>
        <md-field>
            <label>Nghĩa</label>
            <md-input type="text" :name="`${_uid}_meaning`" @keyup.enter="translateToEn()" data-vv-validate-on="none" data-vv-as="nghĩa" v-validate="'required|max:300'" data-vv-scope="general" v-model="word.meaning" md-counter="300">
            </md-input>
            <a-tooltip @click="translateToEn()">
                <template slot="title">
                    Nhấn để dịch
                </template>
                <md-icon style="cursor: pointer;">translate</md-icon>
            </a-tooltip>
        </md-field>
        <div v-if="errors.has(`general.${_uid}_meaning`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_meaning`)}}
        </div>
        <md-field>
            <label>Gợi ý</label>
            <md-input type="text" :name="`${_uid}_hint`" data-vv-validate-on="none" data-vv-as="gợi ý" v-validate="'required|max:300'" data-vv-scope="general" v-model="word.hint" md-counter="300">
            </md-input>
        </md-field>
        <div v-if="errors.has(`general.${_uid}_hint`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_hint`)}}
        </div>
        <a-row>
            Quan trọng
            <a-switch @change="onIsImportantChange" />
        </a-row>

        <a-row style="margin-top: 20px;">
            Ảnh
            <vue-dropzone :style="{backgroundImage: `url(${chosedImage})`, backgroundSize: 'cover'}" ref="myVueDropzone" vdropzone-file-added="handleFileAdded" id="dropzone" :options="dropzoneOptions" accepted-file-types=".jpg,.png,.jpeg" @vdropzone-success="uploadSuccess" @vdropzone-complete="afterComplete">

            </vue-dropzone>
        </a-row>
        <a-row v-if="suggestImages.length">
            <div class="image-list">
                <img class="suggest-image" v-for="image in suggestImages" @click="chooseImage(image)" style="width: 100px;" :key="image" v-lazy="image" alt="">

            </div>
        </a-row>

    </div>

    <div class="mobile-btn-group">
        <a-button type="primary" size="large" :loading="isLoading" block @click="submit">
            Lưu
        </a-button>
        <a-button type="dashed" size="large" block @click="cancel">
            Thoát
        </a-button>
    </div>
    <div class="md-right pc-btn-group">
        <a-button type="primary" :loading="isLoading" @click="submit">Thêm</a-button>
        <a-button type="dashed" @click="cancel">Bỏ qua</a-button>
    </div>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
    data() {
        return {
            title: 'Word',
            suggestImages: [],
            isLoading: false,
            chosedImage: '',
            word: {
                word: '',
                hint: '',
                image: '',
                meaning: '',
                is_important: false,
                category_id: 1,
                suggestImage: []
            },
            dropzoneOptions: {
                url: `${process.env.MIX_APP_URL}/api/image/store`,
                thumbnailWidth: null,
                maxFiles: 1,
                maxFilesize: 1000,
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
            this.word.category_id = event.params.categoryId;
            this.suggestImages = [];
            this.chosedImage = '';
        },
        beforeClose() {
            this.word = {
                word: '',
                hint: '',
                image: '',
                meaning: '',
                is_important: false,
                category_id: 1
            }
        },
        handleFileAdded() {
            this.chosedImage = '';
        },
        chooseImage(image) {
            this.$refs.myVueDropzone.removeAllFiles();
            this.chosedImage = image;
        },
        afterComplete(file, response) {
            this.chosedImage = '';
        },
        uploadSuccess(file, response) {
            this.chosedImage = '';
            this.word.image = response;
        },
        onIsImportantChange(isImportant) {
            this.word.is_important = isImportant;
        },
        async submit() {
            this.createNewWord();
        },
        createNewWord() {
            let params = { ...this.word };
            params.external_image = this.chosedImage;
            this.isLoading = true;
            rf.getRequest('WordRequest').store(params).then((res) => {
                this.isLoading = false;
                this.$emit('refresh');
                this.$emit('created');
                this.$modal.hide('word');
                this.$message.success('Thêm từ mới thành công');

            }).catch((err) => {
                this.isLoading = false;
                // this.$message.success('Đã có lỗi xảy ra, vui lòng thử lại');
            });
        },
        getSuggestImages() {
            let params = {
                word: this.word.word
            }
            rf.getRequest('WordRequest').getSuggestImages(params).then(res => {
                this.suggestImages = res.items.map(item => {
                    return item.link;
                });
            })
        },
        translate() {
            this.getSuggestImages();
            rf.getRequest('TranslateRequest').translate({ text: this.word.word }).then(res => {
                this.word.meaning = res;
            })
        },
        translateToEn() {
            rf.getRequest('TranslateRequest').translateToEn({ text: this.word.meaning }).then(res => {
                    this.word.word = res;
                    this.getSuggestImages();
            })
        },
        cancel() {
            this.$modal.hide('word');
        }
    }
}
</script>

<style lang="scss" scoped>
.content {
    padding: 30px 30px 10px 30px;
}

.image-list {
    height: 100px;
    overflow-x: scroll;
    display: flex;

    img {
        cursor: pointer;
        opacity: 0.7;

        &:hover {
            opacity: 1;
        }
    }
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
