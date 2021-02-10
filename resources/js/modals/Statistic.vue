<template>
<modal name="statistic" height="auto" width="700px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">
    <div class="close-button-mobile" @click="cancel">
        <a-button type="danger" shape="circle" icon="close" />
    </div>

    <div class="content">
        <div slot="top-right">
        </div>
        <span class="md-title">{{title}}</span>
        <a-row v-if="statistics.total_category">
            <a-col span="12" style="padding-top: 20px;">
                <p>Tổng số danh mục: {{statistics.total_category}}</p>
                <p>Tổng số từ vựng: {{statistics.total_word}}</p>
                <p>Đang chia sẻ: {{statistics.total_sharing_category}}</p>
            </a-col>
            <a-col span="12">
                <PieChart :id="studentId"/>
            </a-col>
        </a-row>
        <a-row  style="text-align: center;" v-else>
            <a-spin style="padding: 40px;" size="large" />
        </a-row>
    </div>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
import PieChart from '../pages/admin/Chart/PieChart';
export default {
    components: {
        PieChart
    },
    data() {
        return {
            title: 'Category',
            studentId: '',
            student: {},
            statistics: {}
        }
    },
    methods: {
        beforeOpen(event) {
            this.title = event.params.title;
            this.studentId = event.params.id;
            this.student = event.params.selectedStudent;
            this.getStatistics();
        },
        beforeClose() {
            this.editingId = '';
            this.oldCover = '';
            this.category = {
                is_public: false
            };
        },
        getStatistics() {
            rf.getRequest('UserRequest').getStudentInfo(this.studentId).then(res => {
                this.statistics = res;
                console.log(res);
            })
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
