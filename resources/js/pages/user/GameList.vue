<template>
<div class="game-list">
    <h3>Trò chơi</h3>
    <div>
        <label class="typo__label">Trước khi bắt đầu, vui lòng chọn một hoặc nhiều danh mục từ</label>
        <multiselect v-model="value" placeholder="Vui lòng chọn" style="width: 500px" label="title" track-by="id" :options="categories" :multiple="true" :taggable="true"></multiselect>
        <span>Tổng số từ được chọn: {{totalSelectedWord}}</span>
    </div>
    <br>
    <a-row>
        <a-col :span="8">
            <a-card class="game-1" hoverable>
                <img slot="cover" alt="example" class="game-background" src="https://4.bp.blogspot.com/-QK3j84ngpOw/Wgs-z_g9bXI/AAAAAAAALAs/JNwgQX38s-AKlithq--9YD_5VvWmv0v_gCLcBGAs/s640/ai-la-trieu-phu-01.jpg" />
                <template slot="actions" class="ant-card-actions">
                    <a-icon v-if="totalSelectedWord >= 15" width="3em" type="play-circle" theme="filled" />
                    <a-icon v-else type="lock" />
                </template>
                <a-card-meta title="Ai là triệu phú" description="Mô phỏng dựa trên game show Ai là triệu phú">

                </a-card-meta>
                <span>Yêu cầu tối thiểu: 15 từ</span>
            </a-card>
        </a-col>
        <a-col class="game-2" :span="8">
            <a-card hoverable>
                <img slot="cover" alt="example" class="game-background" src="/images/word-complete.jpg" />
                <template slot="actions" class="ant-card-actions">
                    <a-icon v-if="totalSelectedWord >= 5"  type="play-circle" theme="filled" />
                    <a-icon v-else type="lock" />

                </template>
                <a-card-meta title="Hoàn thành câu" description="Hoàn thành câu bằng gợi ý">
                </a-card-meta>
                <span>Yêu cầu tối thiểu: 5 từ</span>
            </a-card>
        </a-col>
        <a-col class="game-3" :span="8">
            <a-card hoverable>
                <img slot="cover" alt="example" class="game-background" src="/images/memory-card.jpeg" />
                <template slot="actions" class="ant-card-actions">
                    <a-icon v-if="totalSelectedWord >= 8" type="play-circle" theme="filled" />
                    <a-icon v-else type="lock" />

                </template>
                <a-card-meta title="Trò chơi trí nhớ" description="Trò chơi luyện trí nhớ tìm cặp hình và từ giống nhau">
                </a-card-meta>
                <span>Yêu cầu tối thiểu: 8 từ</span>
            </a-card>
        </a-col>
    </a-row>
</div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
    watch: {
        value(newValue, oldValue) {
            console.log(this.value);
        }
    },
    data() {
        return {
            totalSelectedWord: 10,
            value: [

            ],
            categories: [

            ]
        }
    },
    methods: {
        getCategories() {
            rf.getRequest('CategoryRequest').getCategories().then(categories => {
                this.categories = categories;
            })
        }
    },
    mounted() {
        this.getCategories();
    },
}
</script>

<style lang="scss" scoped>
.game-list {
    .anticon-play-circle {
        font-size: 31px !important;
        line-height: 22px;
        color: #33d433;
    }

    .ant-card {
        opacity: 0.7;

        &:hover {
            opacity: 1;

            .anticon-play-circle:before {
                content: "";
                position: absolute;
                z-index: 0;
                left: 50%;
                top: 50%;
                transform: translateX(-50%) translateY(-50%);
                display: block;
                width: 50px;
                height: 50px;
                background: #73dc59;
                border-radius: 50%;
                animation: pulse-border 1500ms ease-out infinite;
            }

        }

    }
}

.game-1 {
    &:hover {
        .game-2 {

            opacity: 0.7;
        }
    }
}

@keyframes pulse-border {
    0% {
        transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
        opacity: 1;
    }

    100% {
        transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
        opacity: 0;
    }
}

.game-background {
    height: 230px;
}
</style>
