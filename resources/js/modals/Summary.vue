<template>
<a-modal v-model="showSummary" width="750px" style="top: 0px;" :footer="null">
    <div slot="title">
        Danh sách từ mới
        <br />
        <br />
        <a-input-search size="medium" placeholder="Tìm kiếm" style="width: 200px" v-model="searchKey" @search="onNormalSearch" />
        <a-button type="dashed" icon="printer" @click="print">In</a-button>
    </div>
    <a-table @change="handleChange" :columns="dataColumns" :data-source.sync="words" :locale="locale" :pagination="{ pageSize: 20 }" :scroll="{ y: 340}">

        <b slot="word" slot-scope="word">{{ word | capitalize}}</b>
        <b slot="priority" slot-scope="priority">
            <a-tag>{{ priority| formatPriorityToPercent}}%</a-tag>
        </b>
        <div slot="category" slot-scope="category">
            <a :href="`/category/${category.slug}`" target="_blank" style="color: #1890ff;">{{category.title}}</a>
        </div>
        <img slot="image" style="max-height: 70px; max-width: 50px;" slot-scope="image" v-lazy="image" />
        <p slot="created_at" slot-scope="created_at">
            {{created_at | formatToDate}}
        </p>
        <template slot="footer" slot-scope="currentPageData">
            <div style="text-align: right;">
                Tổng số: {{words.length}} từ
            </div>
        </template>
    </a-table>
    <div id="printMe" v-show="false">
            <h1>Danh sách từ mới</h1>
            <p>Tổng số từ: {{words.length}}</p>
            <table class="table table-striped">
                <thead>
                    <th>STT</th>
                    <th>Từ</th>
                    <th>Nghĩa</th>
                    <th>Gợi ý</th>
                    <th>Thành thạo</th>
                    <th>Danh mục</th>
                    <!-- <th>Ảnh</th> -->
                    <th>Ngày tạo</th>
                </thead>
                <tbody>
                    <tr v-for="(word, index) in words" :key="word">
                        <td>{{index + 1}}</td>
                        <td>{{word.word | capitalize}}</td>
                        <td>{{word.meaning}}</td>
                        <td>{{word.hint}}</td>
                        <td>{{word.priority | formatPriorityToPercent}}%</td>
                        <td>{{word.category.title}}</td>
                        <!-- <td><img style="max-width: 70px; max-height: 70px;" :src="word.image"/></td> -->
                        
                        <td>{{word.created_at | formatToDate}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
</a-modal>
</template>

<script>
import rf from '../requests/RequestFactory';
import moment from 'moment';
import _ from 'lodash';
const columns = [{
        title: 'Từ',
        dataIndex: 'word',
        key: 'word',
        scopedSlots: { customRender: 'word' },
    },
    {
        title: 'Nghĩa',
        dataIndex: 'meaning',
        key: 'meaning',
    },
    {
        title: 'Gợi ý',
        dataIndex: 'hint',
        key: 'hint',
    },
    {
        title: 'Thành thạo',
        dataIndex: 'priority',
        key: 'priority',
        scopedSlots: { customRender: 'priority' },
        sorter: (a, b) => {
            return b.priority - a.priority;
        },
    },
    {
        title: 'Danh mục',
        dataIndex: 'category',
        key: 'category',
        scopedSlots: { customRender: 'category' },
        onFilter: (value, record) => record.category.title.indexOf(value) === 0,
    },
    {
        title: 'Ảnh',
        dataIndex: 'image',
        key: 'image',
        scopedSlots: { customRender: 'image' },
    },
    {
        title: 'Ngày tạo',
        dataIndex: 'created_at',
        key: 'created_at',
        scopedSlots: { customRender: 'created_at' },
        sorter: (a, b) => {
            let firstTime = a.created_at ? moment.utc(a.created_at).valueOf() : 0;
            let secondTime = b.created_at ? moment.utc(b.created_at).valueOf() : 0;
            return firstTime - secondTime;
        },
    },
];
export default {
    props: {
        showSummary: Boolean
    },
    watch: {
        showSummary: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                if(!newValue) {
                    this.$emit('close');
                }
            }
        },
        searchKey: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                this.onNormalSearch(this.searchKey);
            }
        }
    },
    data() {
        return {
            searchKey: '',
            words: [],
            sourceWords: [],
            printWords: [],
            dataColumns: columns,
            showAdvancedSearch: false,
            locale: {
                filterConfirm: 'Lọc',
                filterReset: 'Bỏ lọc',
                emptyText: 'Không có dữ liệu'
            }
        };
    },
    methods: {
        handleChange(pagination, filters, sorter, { currentDataSource }) {
            if(filters) {
                if(filters.category) {
                    if(filters.category) {
                        if(!filters.category.length) {
                            this.words = this.sourceWords;
                            this.searchKey = '';
                            return;
                        }
                    }
                    if(filters.category.length) {
                        let categories = filters.category;
                        this.words = this.sourceWords.filter(word => {
                            return categories.indexOf(word.category.title) >= 0;
                        });
                        return;
                    }
                }
            }
            if(sorter) {
                console.log(sorter);
                if(sorter.field == 'priority') {
                    if(sorter.order == 'ascend') {
                        this.words = this.words.sort((a, b) => {
                            return b.priority - a.priority;
                        });
                    } else {
                        this.words = this.words.sort((a, b) => {
                            return a.priority - b.priority;
                        });
                    }
                }

                if(sorter.field == 'createdAt') {
                    this.words = this.words.sort((a, b) => {
                        let firstTime = a.created_at ? moment.utc(a.created_at).valueOf() : 0;
                        let secondTime = b.created_at ? moment.utc(b.created_at).valueOf() : 0;
                        return firstTime - secondTime;
                    });
                }
            }
            this.words = currentDataSource;
            this.searchKey = '';
        },
        print() {
            this.$htmlToPaper('printMe');
        },
        onNormalSearch(value) {
            let searchKey = value.toLowerCase();
            this.words = this.sourceWords;
            if (searchKey) {
                this.words = this.words.filter((word) => {
                    let wordContent = word.word ? word.word.toLowerCase() : '';
                    let wordHint = word.hint ? word.hint.toLowerCase() : '';
                    let wordMeaning = word.meaning ? word.meaning.toLowerCase() : '';
                    let category = word.category.title ? word.category.title.toLowerCase() : '';
                    return category.includes(searchKey) || wordContent.includes(searchKey) || wordHint.includes(searchKey) || wordMeaning.includes(searchKey);
                });
            } else {
                this.words = this.sourceWords;
            }
        }
    },
    mounted() {
        let params = {};
        rf.getRequest('WordRequest').getAllWords(params).then(res => {
            this.words = res;
            this.sourceWords = res;
            let categoryFilter = _.uniq(this.sourceWords.map((word) => {
                return word.category.title;
            })).map(category => {
                return {
                    text: category,
                    value: category
                }
            });
            this.dataColumns[4].filters = categoryFilter;
        });
    },
}
</script>

<style lang="scss">
.ant-table-filter-dropdown-btns {
    display: inline-flex;

    .ant-table-filter-dropdown-link {
        padding-right: 15px;
        color: #1890ff !important;
    }
}

.ant-pagination-item-active {
    a {
        color: white !important;
        background-color: #1890ff;
    }
}

.ant-pagination-item {
    &:not(.ant-pagination-item-active) {
        a {
            color: #1890ff !important;
        }
    }
}

.ant-pagination-item-link {
    svg {
        fill: #1890ff !important;
    }
}
</style>
