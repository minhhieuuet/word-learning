<template>
<div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Cụm từ" @back="() => $router.go(-1)" />

    <div class="main-conten phrase">
        <a-row style="padding-top: 20px">
            <a-col class="desc-side" :span="10">
                <img class="phrase-img" src="/images/empty-phrase.svg" alt="">
                <div class="phrase-desc">
                    <h2>Đây là nơi bạn có thể lưu những cụm từ mà bạn muốn học</h2>
                </div>
                <div style="text-align: center;">
                    <a-button type="primary" style="background-color: #921cb9;" icon="eye" @click="openReviewModal()">
                        Ôn tập
                    </a-button>
                    <a-button type="primary" style="background-color: #31b108;" icon="plus-circle" @click="createWord()">
                        Thêm từ
                    </a-button>
                    <a-button type="primary" icon="trophy" @click="playGame()">
                        Trò chơi
                    </a-button>
                </div>

            </a-col>
            <a-col class="word-side" :span="14">
                <a-tabs default-active-key="1" style="border: 1px solid rgba(0, 0, 0, 0.1);">
                    <a-tab-pane key="1">
                        <span slot="tab">
                            <a-icon type="ordered-list" />
                            Tất cả
                        </span>
                        <div v-if="!phrases.length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="phrase in phrases" :key="phrase.id">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{phrase.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="phrase.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="phrase.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                        </span><span>{{phrase.word | capitalize}}</span>

                                    </div>
                                    <a-icon style="margin-left: 5px;" type="eye" @click="showReviewModalFromWord(phrase.id)"></a-icon>

                                    <StarButton :word.sync="phrase" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img v-lazy="phrase.image ? phrase.image : '/images/default.jpg'" :alt="phrase.word">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2">
                        <span slot="tab">
                            <a-icon type="star" />
                            Yêu thích
                        </span>
                        <div v-if="!phrases.filter(phrase => phrase.is_important).length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="phrase in phrases.filter(phrase => phrase.is_important)">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{phrase.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="phrase.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="phrase.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                        </span><span>{{phrase.word | capitalize}}</span>

                                    </div>
                                    <a-icon style="margin-left: 5px;" type="eye" @click="showReviewModalFromWord(phrase.id)"></a-icon>

                                    <StarButton :word.sync="phrase" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img v-lazy="phrase.image ? phrase.image : '/images/default.jpg'" :alt="phrase.word">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="3">
                        <span slot="tab">
                            <a-icon type="check-circle" />
                            Hoàn thành
                        </span>
                        <div v-if="!phrases.filter(word => word.priority <= -5).length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="phrase in phrases.filter(phrase => phrase.priority <= -5)">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{phrase.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="phrase.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="phrase.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                        </span><span>{{phrase.word | capitalize}}</span>

                                    </div>
                                    <a-icon style="margin-left: 5px;" type="eye" @click="showReviewModalFromWord(phrase.id)"></a-icon>

                                    <StarButton :word.sync="phrase" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img v-lazy="phrase.image ? phrase.image : '/images/default.jpg'" :alt="phrase.word">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                </a-tabs>
            </a-col>
        </a-row>
        <review-modal @reload="refresh()"></review-modal>
        <word-modal @refresh="refresh()"></word-modal>
    </div>
    <div class="main-conten phrase-mobile">
        <a-row>
            <a-col class="desc-side-mobile" :span="24">
                <div class="phrase-desc hit-the-floor">
                    <h2>Phrase</h2>
                </div>
            </a-col>
        </a-row>
        <a-row style="padding-top: 20px">
            <a-col class="word-side" :span="24">
                <a-button-group style="text-align: center;width: 100%;">
                    <a-button type="primary" size="large" style="background-color: #31b108;width: 33%;" icon="plus-circle" @click="createWord()">
                    </a-button>
                    <a-button type="primary" size="large" style="background-color: rgb(135 106 253);width: 33%;" icon="eye" @click="openReviewModal()">
                    </a-button>
                    <a-button type="primary" size="large" style="rgb(243 162 41);width: 33%;" icon="trophy" @click="playGame()">
                    </a-button>
                </a-button-group>
                <a-tabs default-active-key="1" style="border: 1px solid rgba(0, 0, 0, 0.1);">
                    <a-tab-pane key="1">
                        <span slot="tab">
                            <a-icon type="ordered-list" />
                            Tất cả
                        </span>
                        <div v-if="!phrases.length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="phrase in phrases" :key="phrase.id">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{phrase.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="phrase.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="phrase.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                        </span><span>{{phrase.word | capitalize}}</span>

                                    </div>
                                    <a-icon style="margin-left: 5px;" type="eye" @click="showReviewModalFromWord(phrase.id)"></a-icon>
                                    <StarButton :word.sync="phrase" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img v-lazy="phrase.image ? phrase.image : '/images/default.jpg'" :alt="phrase.word">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2">
                        <span slot="tab">
                            <a-icon type="star" />
                            Yêu thích
                        </span>
                        <div v-if="!phrases.filter(phrase => phrase.is_important).length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="phrase in phrases.filter(phrase => phrase.is_important)">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{phrase.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="phrase.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="phrase.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                        </span><span>{{phrase.word | capitalize}}</span>

                                    </div>
                                    <a-icon style="margin-left: 5px;" type="eye" @click="showReviewModalFromWord(phrase.id)"></a-icon>
                                    <StarButton :word.sync="phrase" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img v-lazy="phrase.image ? phrase.image : '/images/default.jpg'" :alt="phrase.word">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="3">
                        <span slot="tab">
                            <a-icon type="check-circle" />
                            Hoàn thành
                        </span>
                        <div v-if="!phrases.filter(phrase => phrase.priority <= -5).length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="phrase in phrases.filter(phrase => phrase.priority <= -5)">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{phrase.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="phrase.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="phrase.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="phrase.hint">
                                        </span><span>{{phrase.word | capitalize}}</span>

                                    </div>
                                    <a-icon style="margin-left: 5px;" type="eye" @click="showReviewModalFromWord(phrase.id)"></a-icon>
                                    <StarButton :word.sync="phrase" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{phrase.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="phrase.hint">Gợi ý: <span>{{phrase.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img v-lazy="phrase.image ? phrase.image : '/images/default.jpg'" :alt="phrase.word">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                </a-tabs>
            </a-col>
        </a-row>
        <review-modal @reload="refresh()"></review-modal>
        <word-modal @refresh="refresh()"></word-modal>
    </div>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import ReviewModal from './../../modals/Review';
import WordModal from './../../modals/Word';
import SpeakButton from '../../components/SpeakButton';
import StarButton from '../../components/StarButton';

export default {
    components: {
        ReviewModal,
        WordModal,
        SpeakButton,
        StarButton
    },
    data() {
        return {
            phrases: [],
            phraseId: 1,
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
                this.phraseId = res.id;
                this.phrases = res.data;
            })
        },
        openReviewModal() {
            this.$modal.show('review', { categoryId: this.phraseId });
        },
        onSeach(value) {
            alert(value);
        },
        createWord() {
            this.$modal.show('word', { categoryId: this.phraseId, title: 'Thêm cụm từ mới' });
        },
        playGame() {
            localStorage.setItem('selectedCategoryId', this.phraseId);
            this.$router.push({name: 'Game'})
        },
        showReviewModalFromWord(wordId) {
            this.$modal.show('review', { categoryId: this.phraseId, startWordId: wordId });
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

<style lang="scss">
@media screen and (max-width: 900px) {
    .phrase {
        display: none;
    }

    .phrase-mobile {
        display: block !important;

        .ant-tabs-nav {
            width: 100% !important;
            // text-align: center;
        }

        .ant-tabs-tab {
            width: 40% !important;
        }
    }
}

.hit-the-floor {
    color: #fff;
    font-size: 12em;
    font-weight: bold;
    font-family: Helvetica;
    text-shadow:
        0 1px 0 #ccc,
        0 2px 0 #c9c9c9,
        0 3px 0 #bbb,
        0 4px 0 #b9b9b9,
        0 5px 0 #aaa,
        0 6px 1px rgba(0, 0, 0, .1),
        0 0 5px rgba(0, 0, 0, .1),
        0 1px 3px rgba(0, 0, 0, .3),
        0 3px 5px rgba(0, 0, 0, .2),
        0 5px 10px rgba(0, 0, 0, .25),
        0 10px 10px rgba(0, 0, 0, .2),
        0 20px 20px rgba(0, 0, 0, .15);
}

.phrase-mobile {
    display: none;
}

.phrase {
    .ant-tabs-nav {
        width: 100% !important;

        .ant-tabs-tab {
            width: 40% !important;
        }
    }

}
</style>
<style lang="scss" scoped>
.phrase {
    padding: 10px;
}
.desc-side {
    padding-right: 20px;
}

.star-btn {
    margin-left: 5px;
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
