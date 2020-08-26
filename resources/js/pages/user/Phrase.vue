<template>
<div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Cụm từ" @back="() => $router.go(-1)" />

    <div class="main-content">
        <a-row style="padding-top: 20px">
            <a-col class="desc-side" :span="10">
                <img class="phrase-img" src="/images/empty-phrase.svg" alt="">
                <div class="phrase-desc">
                    <h2>Đây là nơi bạn có thể lưu những cụm từ mà bạn muốn học</h2>
                </div>
                <a-button type="primary" style="background-color: #921cb9;" icon="eye" @click="openReviewModal()">
                    Trình chiếu
                </a-button>
                <a-button type="primary" style="background-color: #31b108;" icon="plus-circle" @click="createWord()">
                    Thêm từ
                </a-button>
                <div class="styles__viewBtnPlay___3lqzv" style="padding-top: 20px">
                    <div id="btnGameCenter" class="styles__button___dn9S6 effectScale">
                        <div class="styles__text___GW6do" style="visibility: visible;">Chơi trò chơi</div>
                    </div>
                </div>

            </a-col>
            <a-col class="word-side" :span="10">

                <div class="styles__container___AS5GT" v-for="phrase in phrases">
                    <div class="styles__center___1alr7">
                        <div class="styles__viewTitle___trc68">
                            <div class="styles__soundIcon___3F62k">
                                <div class="styles__sound_icon___2JvL9 styles__sound_icon_auto_width___3KkW9 [object Object]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="rgb(122, 199, 12)" d="M4.931 9.714l5.686-3.939v13.442L4.934 15.28H.5V9.714h4.431zm7.103-1.792l.814-.474a7.628 7.628 0 0 1 1.908 5.048 7.628 7.628 0 0 1-1.908 5.048l-.814-.474a6.702 6.702 0 0 0 1.802-4.574c0-1.77-.688-3.375-1.802-4.574zm3.806-2.21l.804-.47a11.99 11.99 0 0 1 2.43 7.254c0 2.728-.909 5.244-2.436 7.26l-.804-.467a11.06 11.06 0 0 0 2.321-6.793c0-2.556-.866-4.91-2.315-6.785zM20.496 3a16.45 16.45 0 0 1 3.004 9.496A16.45 16.45 0 0 1 20.49 22l-.8-.466a15.523 15.523 0 0 0 2.89-9.038 15.52 15.52 0 0 0-2.884-9.03l.8-.466z"></path>
                                    </svg></div>
                            </div>
                            <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                </span><span>{{phrase.word}}</span>
                            </div>
                        </div>
                        <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                        <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                    </div>
                    <div class="styles__right___4LtJ-">
                        <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                        <img :src="phrase.image" alt="ambitious">
                    </div>
                </div>
            </a-col>
        </a-row>
        <review-modal></review-modal>
        <word-modal @refresh="refresh()"></word-modal>
    </div>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import ReviewModal from './../../modals/Review';
import WordModal from './../../modals/Word';

export default {
    components: {
        ReviewModal,
        WordModal
    },
    data() {
        return {
            phrases: [],
            seachKey: '',
            newWord: {
                word: '',
                image: '',
                hint: '',
                meaning: ''
            }
        }
    },
    methods: {
        getAllPhrases() {
            rf.getRequest('WordRequest').getAllPhrases().then(res => {
                this.phrases = res;
            })
        },
        openReviewModal() {
            this.$modal.show('review', { categoryId: 1 });
        },
        onSeach(value) {
            alert(value);
        },
        createWord() {
            this.$modal.show('word', { categoryId: 1, title: 'Thêm cụm từ mới' });
        },
        refresh() {
            this.newWord = {
                word: '',
                image: '',
                hint: '',
                meaning: ''
            }
            this.getAllPhrases();
        }
    },
    mounted() {
        this.getAllPhrases();
    }

}
</script>

<style lang="scss" scoped>
.desc-side {
    padding-right: 20px;
}

.main-content {
    padding: 50px;
}

.phrase-img {
    height: 300px;
}

.word-side {
    border-left: 1px solid #b3b3b3;
    height: 550px;
    // overflow: scroll;
    min-height: 101%;
    overflow-y: scroll;
}

.phrase-desc {
    font-size: 1.1875rem;
    font-weight: 400;
    font-style: normal;
    font-stretch: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #000;
}

.styles__viewBtnPlay___3lqzv {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.styles__button___dn9S6 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 3.0625rem;
    padding: 0 2.625rem;
    border-radius: 1.5rem;
    cursor: pointer;
    position: relative;
}

.styles__text___GW6do {
    font-size: 1.1875rem;
    font-weight: 400;
    color: #fff;
    white-space: nowrap;
}

.styles__viewLoading___oTL1G {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

#btnGameCenter {
    background: rgb(29, 161, 242);
    box-shadow: rgba(29, 161, 242, 0.7) 0px 0px 0px 0px;
    animation: 2s cubic-bezier(0.66, 0, 0, 1) 0s infinite normal none running pulse;
    cursor: pointer;
}

.styles__container___AS5GT {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
    margin: 0 1rem;
    padding: .0625rem 0;
    height: 6rem;
}

.styles__left___22i0T {
    padding: 1rem 1rem 1rem 0;
}

.styles__center___1alr7 {
    flex-grow: 1;
    width: 1%;
    padding: .25rem 0;
}

.styles__viewTitle___trc68 {
    display: flex;
    align-items: center;
}

.styles__soundIcon___3F62k {
    padding-right: .5rem;
}

.styles__sound_icon___2JvL9 {
    cursor: pointer;
    display: flex;
}

.styles__textTitle___3ne0o {
    font-weight: 600;
    line-height: 1.5rem;
    font-size: 1.125rem;
    color: #232323;
    cursor: pointer;
}

.styles__textHighLight___EdWX6 {
    background: #fc0;
}

.styles__desc___2IcIn {
    margin-top: .5rem;
    flex-grow: 1;
    padding-right: .5rem;
    font-weight: 400;
    line-height: 1rem;
    font-size: .75rem;
    color: #8c8c8c;
}

.styles__right___4LtJ- {
    width: 62px;
    height: 62px;
    position: relative;
    background: rgba(0, 0, 0, .1);
    border-radius: 4px;
}

.styles__status___2gUWg {
    position: absolute;
    top: .25rem;
    right: .25rem;
    border: 1px solid hsla(0, 0%, 100%, .8);
    border-radius: 4px;
    width: 1rem;
    height: 1rem;
}

.styles__right___4LtJ- img {
    width: 100%;
    height: 100%;
    border-radius: 5px;
}

::-webkit-scrollbar {
    -webkit-appearance: none;
    width: 10px;
}

::-webkit-scrollbar-thumb {
    border-radius: 5px;
    background-color: rgba(0, 0, 0, .5);
    -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
}
</style>
