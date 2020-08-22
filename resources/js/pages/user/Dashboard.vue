<template>
<div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Title" sub-title="This is a subtitle" @back="() => null" />
    <a-form-model ref="ruleForm" :model="ruleForm" :rules="rules" v-bind="layout">
        <a-form-model-item has-feedback label="Từ mới" prop="word">
            <a-input v-model.lazy="ruleForm.word" @keyup="handleWordChange" type="text" autocomplete="off" />
        </a-form-model-item>
        <a-form-model-item has-feedback label="Gợi ý" prop="hint">
            <a-input v-model="ruleForm.hint" type="text" autocomplete="off" />
        </a-form-model-item>
        <a-form-model-item has-feedback label="Nghĩa" prop="meaning">
            <a-input v-model.number="ruleForm.meaning" />
        </a-form-model-item>

        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-success="uploadSuccess" @vdropzone-complete="afterComplete">

        </vue-dropzone>

        <a-form-model-item :wrapper-col="{ span: 20, offset: 0 }">
            <a-button type="primary" @click="submitForm('ruleForm')">
                Thêm
            </a-button>
            <a-button style="margin-left: 10px" @click="resetForm('ruleForm')">
                Hoàn tác
            </a-button>
        </a-form-model-item>
    </a-form-model>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';

function getBase64(img, callback) {
    const reader = new FileReader();
    reader.addEventListener('load', () => callback(reader.result));
    reader.readAsDataURL(img);
}
export default {
    data() {
        let checkPending;
        return {
            loading: false,
            imageUrl: '',
            ruleForm: {
                word: '',
                hint: '',
                meaning: '',
                image: ''
            },
            dropzoneOptions: {
                url: 'http://localhost:8000/api/image/store',
                thumbnailWidth: null,
                maxFiles: 1,
                maxFilesize: 1000,
                addRemoveLinks: true,
                headers: {
                    "My-Awesome-Header": "header value"
                }
            },
            // rules: {
            //     pass: [{
            //         validator: validatePass,
            //         trigger: 'change'
            //     }],
            //     checkPass: [{
            //         validator: validatePass2,
            //         trigger: 'change'
            //     }],
            //     age: [{
            //         validator: checkAge,
            //         trigger: 'change'
            //     }],
            // },
            layout: {
                labelCol: {
                    span: 4
                },
                wrapperCol: {
                    span: 14
                },
            },
        };
    },
    methods: {
        afterComplete(file, response) {
            // console.log(response);
        },
        uploadSuccess(file, response) {
            console.log(response);
            this.ruleForm.image = response;
        },
        handleWordChange(e) {
            // console.log(this.ruleForm.word);
            if (e.key == 'Enter') {
                rf.getRequest('TranslateRequest').translate({
                    'text': this.ruleForm.word
                }).then(res => {
                    this.ruleForm.meaning = res;
                })
            }

        },
        handleChange(info) {
            if (info.file.status === 'uploading') {
                this.loading = true;
                return;
            }
            if (info.file.status === 'done') {
                // Get this url from response in real world.
                getBase64(info.file.originFileObj, imageUrl => {
                    this.imageUrl = imageUrl;
                    this.loading = false;
                });
            }
        },
        beforeUpload(file) {
            const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
            if (!isJpgOrPng) {
                this.$message.error('You can only upload JPG file!');
            }
            const isLt2M = file.size / 1024 / 1024 < 2;
            if (!isLt2M) {
                this.$message.error('Image must smaller than 2MB!');
            }
            return isJpgOrPng && isLt2M;
        },
        submitForm(formName) {
            let params = {
                ...this.ruleForm
            };
            rf.getRequest('WordRequest').store(params).then(res => {
                console.log(res);
                this.$notification['success']({
                    message: 'Thành công',
                    description: 'Tạo từ mới thành công'
                });
            })
            console.log(this.ruleForm);
            // this.$refs[formName].validate(valid => {
            //     if (valid) {
            //         alert('submit!');
            //     } else {
            //         console.log('error submit!!');
            //         return false;
            //     }
            // });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        handleChange(info) {
            const status = info.file.status;
            if (status !== 'uploading') {
                console.log(info.file, info.fileList);
            }
            if (status === 'done') {
                this.$message.success(`${info.file.name} file uploaded successfully.`);
            } else if (status === 'error') {
                this.$message.error(`${info.file.name} file upload failed.`);
            }
        },
    },
};
</script>
