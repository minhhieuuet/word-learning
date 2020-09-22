<template>
<modal name="youtubereview" height="700px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">
    <div class="close-button-mobile" @click="cancel">
        <a-button type="danger" shape="circle" icon="close" />
    </div>
    <div class="content" v-if="!isNotFound">
        <div class='video' v-show="videos.length">
            <iframe width="560" height="615" ref="youtube-video" id="youtube-video" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
        </div>
        <div style="text-align:center;">
            <div id="subcontent"></div>
            <a-button icon="step-backward" :disabled="currentIndex == 1" @click="prev()">Trở về</a-button>
            <a-button icon="step-forward" @click="next()"  :disabled="currentIndex == videos.length">Tiếp theo</a-button>
            <a-button icon="retweet" @click="replay()">Phát lại</a-button>

        </div>
    </div>
    <div class="content notfound" v-else>
        <img src="/images/video-notfound.gif" alt="">
        <h2>Không tìm thấy dữ liệu liên quan</h2>
        <a-button size="large" @click="cancel()">Thoát</a-button>
    </div>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
    props: {
        word: Object
    },
    data() {
        return {
            title: 'Video Review',
            currentIndex: 0,
            videos: [],
            isNotFound: false
        }
    },
    methods: {
        beforeOpen(event) {
            this.currentIndex = 0;
            this.videos = [];
            this.isNotFound = false;
            let params = { word: event.params.word.word };
            rf.getRequest('WordRequest').getYoutubeVideos(params).then(res => {
                this.videos = res.transcripts;
                if(!this.videos.length) {
                    this.isNotFound = true;
                }
                this.next();
            })
        },
        beforeClose() {
            this.isNotFound = false;
        },
        next() {
            let duration = parseInt(this.videos[this.currentIndex].fields.duration) + 5;
            let start = parseInt(this.videos[this.currentIndex].fields.start) - 1;
            document.getElementById('youtube-video').setAttribute('src', `https://www.youtube.com/embed/${this.videos[this.currentIndex].fields.youtube_id}?cc_load_policy=1&showinfo=0&controls=0&start=${start}&end=${parseInt(this.videos[this.currentIndex].fields.start) + duration}`);
            document.getElementById('youtube-video').src += '&autoplay=1';

            document.getElementById('subcontent').innerHTML = this.videos[this.currentIndex].fields.en;
            this.currentIndex++;
        },
        prev() {
            if (this.currentIndex == 0) {
                return;
            }
            this.currentIndex--;
            let duration = parseInt(this.videos[this.currentIndex].fields.duration) + 5;
            let start = parseInt(this.videos[this.currentIndex].fields.start) - 1;
            document.getElementById('youtube-video').setAttribute('src', `https://www.youtube.com/embed/${this.videos[this.currentIndex].fields.youtube_id}?cc_load_policy=1&showinfo=0&controls=0&start=${start}&end=${parseInt(this.videos[this.currentIndex].fields.start) + duration}`);
            document.getElementById('youtube-video').src += '&autoplay=1';
            document.getElementById('subcontent').innerHTML = this.videos[this.currentIndex].fields.en;
        },
        replay() {
            document.getElementById('youtube-video').src += '&autoplay=1';
        },
        cancel() {
            this.$modal.hide('youtubereview');
        }
    }
}
</script>

<style lang="scss">
#subcontent {
    margin-bottom: 10px;
    font-size: 20px;

    em {
        color: red !important;
        font-weight: bold;
    }
}
</style>
<style lang="scss" scoped>
@media screen and (max-width: 900px) {
    #youtube-video {
        height: auto !important;
    }   
}
#youtube-video {
    height: 500px;
}
.content {
    padding: 30px 30px 10px 30px;
    height: 600px;

    .video {
        // height: 500px !important;
    }
}
.notfound {
    text-align: center;
}

#content {
    margin-bottom: 10px;
    font-size: 20px;

    em {
        color: red !important;
        font-weight: bold;
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
