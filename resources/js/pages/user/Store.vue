<template>
<div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Cửa hàng" @back="() => null">
    </a-page-header>
    <div style="width: 500px;display: block;margin-left: 30px; margin-top: 20px;">
        <a-input-search style="width: 300px" v-model="searchKey" placeholder="Tìm kiếm" size="large" @change="onSearch" />
    </div>
    <div class="category inline-flex">
        <div v-for="(category, index) in categories" :key="category.id" :class="{'styles__container___2c6eo': true, 'inline-flex': true, 'last-category': (categories.length % 2 == 1 && index == categories.length - 1)}">
            <div class="setting-btn">
                <a-popover placement="top" trigger="click">
                    <template slot="content">
                        <div class="category-btn share-btn" style="cursor: pointer;" @click="cloneCategory(category.id)">
                            <a-icon type="download" style="color: #63afff;" /> Tải về
                        </div>

                    </template>
                    <a-button icon="setting"></a-button>
                </a-popover>
            </div>
            <div :style="{ backgroundImage: 'url(' + (category.cover ? category.cover : 'images/default-cover.jpg')  + ')' }" :class="{styles__overLay___1WcJB : true}">

                <div class="styles__conName___2JHZN">
                    <div class="styles__viewName___2PQg6">{{category.title}}</div>
                </div>
                <!-- <div class="styles__txtDate___1BKAV">{{category.created_at}}</div> -->
                <div class="styles__txtNum___39eD4">{{category ? category.total_word : ''}} từ</div>
                <div class="author">
                     Người tạo: <b class="bold">{{category.author}}</b>
                </div>
            </div>
        </div>
    </div>
    <category-model @refresh="refresh()"></category-model>
    <QuickWordModel />
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import CategoryModel from '../../modals/Category';
import QuickWordModel from '../../modals/QuickWord';

export default {
    components: {
        CategoryModel,
        QuickWordModel
    },
    data() {
        return {
            categories: [],
            params: {},
            searchKey: ''
        }
    },
    methods: {
        getPublicCategories(params) {
            rf.getRequest('CategoryRequest').getPublicCategories(params).then(res => {
                this.categories = res;
            })
        },
        onSearch() {
            this.getPublicCategories({search: this.searchKey});
        },
        cloneCategory(categoryId) {
            const loading = this.$message.loading('Đang tải về, vui lòng đợi ...', 0);
            rf.getRequest('CategoryRequest').cloneCategory({id: categoryId}).then(res => {
                loading();
                this.$message.success('Tải về thành công, danh mục đã được thêm vào tài khoản của bạn');
            }).catch(() => {
                loading();
                this.$message.error('Đã có lỗi xảy ra, vui lòng thử lại');
            });
        },
        goToPhrase() {
            this.$router.push({ name: 'Phrase' })
        },
        goToCategory(slug) {
            this.$router.push(`/category/${slug}`);
        },
        refresh() {
            this.getPublicCategories();
        },
        showQuickWordModal() {
            this.$modal.show('quickword', { title: 'Thêm từ nhanh' });
        },
        removeCategory(categoryId) {
            this.$swal({
                icon: "error",
                title: "Cảnh báo",
                text: "Bạn có chắc chắn muốn xoá danh mục này ?",
                buttons: true,
                dangerMode: true,
                buttons: ["Huỷ", "Xoá"],
                className: "swal-delete-word"
            }).then((value) => {
                if (value) {
                    rf.getRequest('CategoryRequest').removeCategory(categoryId).then(res => {
                        this.refresh();
                    });
                }
            })
        }
    },
    mounted() {
        this.getPublicCategories();
    }

}
</script>

<style lang="scss" scoped>
@media screen and (max-width: 900px) {
    .category {
        height: 100% !important;
    }

    .author {
        color: white;
        background-color:#3f85ef;
        position: absolute;
        padding: 5px;
        bottom: 0;
        .bold {
            font-weight: bold;
        }
    }

    .styles__container___16een,
    .styles__container___2c6eo {
        min-width: 50% !important;
        display: inline;
        height: 11rem !important;
        margin: 0px auto !important;
        border-radius: 0% !important;
        border: 1px solid rgba(0, 0, 0, 0.2);
    }

    .last-category {
        min-width: 100% !important;
    }

    .styles__viewName___3mvLd {
        font-size: 1.3rem !important;
    }

    .styles__container___3mCLH {
        // display: none !important;
        min-width: 100% !important;
        height: 6rem !important;
        margin: 0px auto !important;
        border-radius: 0% !important;
    }
}

.author {
    color: white;
    background-color:#3f85ef;
    position: absolute;
    padding: 5px;
    bottom: 0;
    .bold {
        font-weight: bold;
    }
}

.setting-btn {
    position: absolute;
    right: 0px;

    &:hover {
        border: black;
    }

    .remove-category-btn {
        color: black !important;
        cursor: pointer !important;
    }
}

.shop-icon {
    position: absolute;
    left: 0px;
    color: white;
    background-color: #398dec;
    padding: 0px 1px 0px 0px;
    border-radius: 0% 10% 10% 0%;
    box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
}

.category {
    width: 100%;
    flex-flow: wrap;
    padding: 20px;
}

.category-btn {
    padding: 4px;

    i {
        margin-right: 2px;
    }

    &:hover {
        color: rgb(36, 166, 226);
    }
}

.share-btn {
    // border-bottom: 0.1px solid rgba(0, 0, 0, 0.2);
}

.inline-flex {
    display: inline-flex;
}

.styles__container___16een {
    min-width: 20rem;
    max-width: 29rem;
    width: 16vw;
    border-radius: .375rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin: .5rem;
    background: linear-gradient(0deg, #fec551, #fec551);
    height: 8rem;
}

.styles__overLay___2RQuM {
    width: 100%;
    height: 100%;
    background-position: 100% 100%;
    background-repeat: no-repeat;
}

.styles__conName___Jiq61 {
    display: flex;
    margin-top: .75rem;
}

.styles__viewName___3mvLd {
    padding: 0 .5rem 0 1rem;
    font-size: 2.3rem;
    font-weight: 600;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
    max-width: 12rem;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.styles__txtNum___3JT46 {
    font-size: 12px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
}

.styles__txtNum___3JT46 {
    padding: 0 1rem;
}

.styles__container___3mCLH {
    min-width: 15rem;
    max-width: 19rem;
    width: 16vw;
    border-radius: .375rem;
    background-position: 50%;
    background-size: cover;
    cursor: pointer;
    margin: .5rem;
    background: linear-gradient(0deg, #e8e8e8, #e8e8e8);
    box-shadow: inset -4px -4px #d8d8d8, inset 4px 4px #d8d8d8, inset -4px 4px #d8d8d8, inset 4px -4px #d8d8d8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 8rem;
}

.styles__container___16een {
    min-width: 15rem;
    max-width: 19rem;
    width: 16vw;
    border-radius: .375rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin: .5rem;
    background: linear-gradient(0deg, #fec551, #fec551);
    transition: 0.3s ease-in-out;

    &:hover {
        box-shadow: 2px 5px 2px rgba(0, 0, 0, .5);
    }

}

.styles__icon___25pzZ {
    border-radius: 100%;
    background: #1da1f2;
    width: 37px;
    height: 37px;
    margin-right: .5rem;
}

.styles__text___NQdFz {
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    font-size: 13.91px;
    letter-spacing: -.0642px;
    color: #000;
}

@keyframes gelatine {

    from,
    to {
        transform: scale(1, 1);
    }

    25% {
        transform: scale(0.97, 1.07);
    }

    50% {
        transform: scale(1.0, 1.0);
    }

    75% {
        transform: scale(0.97, 1.05);
    }
}

.effectScale:hover {
    // transform: scale(1.2);
    animation: gelatine 0.5s;
    /* transform: scale(1); */
}

.styles__container___2c6eo {
    position: relative;
    min-width: 15rem;
    max-width: 19rem;
    width: 16vw;
    border-radius: .375rem;
    background-color: #efefef;
    display: flex;
    flex-direction: column;
    background-color: silver;
    background-position: 50%;
    background-size: cover;
    cursor: pointer;
    margin: .5rem;
    overflow: hidden;
    height: 8rem;
    transition: 0.3s ease-in-out;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);

    &:hover {
        box-shadow: 2px 5px 2px rgba(0, 0, 0, .5);
    }
}

.styles__overLay___1WcJB {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;

    &:hover {
        //    opacity: 0.5;
    }
}

.styles__conName___2JHZN {
    display: flex;
    margin-top: .75rem;
}

.styles__txtDate___1BKAV,
.styles__txtNum___39eD4 {
    font-size: 15px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
    text-shadow: 3px 3px 7px #000000;

}

.styles__txtNum___39eD4 {
    padding: 0 1.2rem;
    font-size: 12px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
}

.styles__viewName___2PQg6 {
    padding: 0 .5rem 0 1.2rem;
    font-size: 1.5rem;
    font-weight: 600;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
    max-width: 12rem;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    text-shadow: 3px 3px 7px #000000;
}

.styles__txtDate___1BKAV {
    padding: .375rem 1rem 0;
}
</style>
