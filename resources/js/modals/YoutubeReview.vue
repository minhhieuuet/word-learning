<template>
<modal name="youtube-review" height="700px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">

    <div class="content">
        <div class='video' v-show="videos.length">
            <iframe width="760" height="615" style="height: 500px" ref="youtube-video" id="youtube-video" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
        </div>
        <div style="text-align:center;">
            <div id="content"></div>
            <a-button icon="step-backward" @click="prev()">Prev</a-button>
            <a-button icon="step-forward" @click="next()">Next</a-button>
            <a-button icon="retweet" @click="replay()">Replay</a-button>

        </div>
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
            videos: [
            ]
        }
    },
    methods: {
        beforeOpen(event) {
            let params = {word: event.params.word.word};
            rf.getRequest('WordRequest').getYoutubeVideos(params).then(res => {
                this.videos = res.transcripts;
                this.next();
            })
        },
        beforeClose() {},
        next() {
            let duration = parseInt(this.videos[this.currentIndex].fields.duration) + 5;
            let start = parseInt(this.videos[this.currentIndex].fields.start) - 1;
            document.getElementById('youtube-video').setAttribute('src', `https://www.youtube.com/embed/${this.videos[this.currentIndex].fields.youtube_id}?cc_load_policy=1&showinfo=0&controls=0&start=${start}&end=${parseInt(this.videos[this.currentIndex].fields.start) + duration}`);
            document.getElementById('youtube-video').src += '&autoplay=1';

            document.getElementById('content').innerHTML = this.videos[this.currentIndex].fields.en;
            this.currentIndex++;
        },
        prev() {
            if(this.currentIndex == 0) {
                return;
            }
            this.currentIndex--;
            let duration = parseInt(this.videos[this.currentIndex].fields.duration) + 5;
            let start = parseInt(this.videos[this.currentIndex].fields.start) - 1;
            document.getElementById('youtube-video').setAttribute('src', `https://www.youtube.com/embed/${this.videos[this.currentIndex].fields.youtube_id}?cc_load_policy=1&showinfo=0&controls=0&start=${start}&end=${parseInt(this.videos[this.currentIndex].fields.start) + duration}`);
            document.getElementById('youtube-video').src += '&autoplay=1';
            document.getElementById('content').innerHTML = this.videos[this.currentIndex].fields.en;
        },
        replay() {
            document.getElementById('youtube-video').src += '&autoplay=1';
        },
        cancel() {
            this.$modal.hide('yotube-review');
        }
    }
}
</script>

<style lang="scss" scoped>
.content {
    padding: 30px 30px 10px 30px;
    height: 600px;
    .video {
        // height: 500px !important;
    }
}

#content {
    margin-bottom: 10px;
    font-size: 20px;
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
