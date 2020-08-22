<template>
<div>
<audio id="success" ref="success" src='/sound/success.mp3'></audio>
<audio id="error" ref="error" src='/sound/error.mp3'></audio>
<a-row>
    <a-col span="19">
        <div class="container">
            <h1>Điểm: {{score}}</h1>
            <ul class="deck" id="deck">
                <li :class="{card: true, flip: wordList[0].flip || wordList[0].isDisable}" :data-card="wordList[0].word" @click="flipCard(0)">
                    <h3 v-if="wordList[0].type == 'word'" class="front-face">{{wordList[0].word}}</h3>
                    <img v-else class="front-face" :src="wordList[0].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[1].flip || wordList[1].isDisable}" :data-card="wordList[1].word" @click="flipCard(1)">
                    <h3 v-if="wordList[1].type == 'word'" class="front-face">{{wordList[1].word}}</h3>
                    <img v-else class="front-face" :src="wordList[1].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[2].flip || wordList[2].isDisable}" :data-card="wordList[2].word" @click="flipCard(2)">
                    <h3 v-if="wordList[2].type == 'word'" class="front-face">{{wordList[2].word}}</h3>
                    <img v-else class="front-face" :src="wordList[2].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[3].flip || wordList[3].isDisable}" :data-card="wordList[3].word" @click="flipCard(3)">
                    <h3 v-if="wordList[3].type == 'word'" class="front-face">{{wordList[3].word}}</h3>
                    <img v-else class="front-face" :src="wordList[3].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[4].flip || wordList[4].isDisable}" :data-card="wordList[4].word" @click="flipCard(4)">
                    <h3 v-if="wordList[4].type == 'word'" class="front-face">{{wordList[4].word}}</h3>
                    <img v-else class="front-face" :src="wordList[4].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[5].flip || wordList[5].isDisable}" :data-card="wordList[5].word" @click="flipCard(5)">
                    <h3 v-if="wordList[5].type == 'word'" class="front-face">{{wordList[5].word}}</h3>
                    <img v-else class="front-face" :src="wordList[5].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[6].flip || wordList[6].isDisable}" :data-card="wordList[6].word" @click="flipCard(6)">
                    <h3 v-if="wordList[6].type == 'word'" class="front-face">{{wordList[6].word}}</h3>
                    <img v-else class="front-face" :src="wordList[6].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[7].flip || wordList[7].isDisable}" :data-card="wordList[7].word" @click="flipCard(7)">
                    <h3 v-if="wordList[7].type == 'word'" class="front-face">{{wordList[7].word}}</h3>
                    <img v-else class="front-face" :src="wordList[7].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[8].flip || wordList[8].isDisable}" :data-card="wordList[8].word" @click="flipCard(8)">
                    <h3 v-if="wordList[8].type == 'word'" class="front-face">{{wordList[8].word}}</h3>
                    <img v-else class="front-face" :src="wordList[8].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[9].flip || wordList[9].isDisable}" :data-card="wordList[9].word" @click="flipCard(9)">
                    <h3 v-if="wordList[9].type == 'word'" class="front-face">{{wordList[9].word}}</h3>
                    <img v-else class="front-face" :src="wordList[9].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[10].flip || wordList[10].isDisable}" :data-card="wordList[10].word" @click="flipCard(10)">
                    <h3 v-if="wordList[10].type == 'word'" class="front-face">{{wordList[10].word}}</h3>
                    <img v-else class="front-face" :src="wordList[10].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[11].flip || wordList[11].isDisable}" :data-card="wordList[11].word" @click="flipCard(11)">
                    <h3 v-if="wordList[11].type == 'word'" class="front-face">{{wordList[11].word}}</h3>
                    <img v-else class="front-face" :src="wordList[11].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[12].flip || wordList[12].isDisable}" :data-card="wordList[12].word" @click="flipCard(12)">
                    <h3 v-if="wordList[12].type == 'word'" class="front-face">{{wordList[12].word}}</h3>
                    <img v-else class="front-face" :src="wordList[12].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[13].flip || wordList[13].isDisable}" :data-card="wordList[13].word" @click="flipCard(13)">
                    <h3 v-if="wordList[13].type == 'word'" class="front-face">{{wordList[13].word}}</h3>
                    <img v-else class="front-face" :src="wordList[13].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[14].flip || wordList[14].isDisable}" :data-card="wordList[14].word" @click="flipCard(14)">
                    <h3 v-if="wordList[14].type == 'word'" class="front-face">{{wordList[14].word}}</h3>
                    <img v-else class="front-face" :src="wordList[14].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
                <li :class="{card: true, flip: wordList[15].flip|| wordList[15].isDisable }" :data-card="wordList[15].word" @click="flipCard(15)">
                    <h3 v-if="wordList[15].type == 'word'" class="front-face">{{wordList[15].word}}</h3>
                    <img v-else class="front-face" :src="wordList[15].image">
                    <img class="back-face" src="https://naruhodo.repop.jp/wp-content/uploads/2017/12/Button-Black-Large.png" alt="Memory Card">
                </li>
            </ul>
            <div class="modal">
                <h2>You win!</h2>
                <button class="restart">Play again?</button>
            </div>
        </div>
    </a-col>
    <a-col span="5">
        <md-list class="md-triple-line">
            <template v-for="word in matchedWords">
                <md-list-item>
                    <md-avatar>
                        <img :src="word.image" alt="People">
                    </md-avatar>

                    <div class="md-list-item-text">
                        <span>{{word.word}}</span>
                        <!-- <span>Nghĩa:</span> -->
                        <p>{{word.meaning}}</p>
                    </div>

                </md-list-item>

                <md-divider class="md-inset"></md-divider>
            </template>
        </md-list>

    </a-col>
</a-row>
</div>
</template>

<script>
import rf from '../../requests/RequestFactory';

export default {
    data() {
        return {
            wordList: [],
            firstCardIndex: 0,
            secondCardIndex: 0,
            isFlipped: false,
            score: 0,
            matchedWords: []
        }
    },
    watch: {
        matchedWords() {

            if (this.matchedWords.length == 8) {
                this.$swal({
                    icon: "success",
                    button: false,
                    title: "Bạn đã chiến thắng",
                    button: "Chơi lại"
                    // timer: 500
                }).then((value) => {
                if(value) {
                    this.playAgain();
                }  
                })
            }
        }
    },
    methods: {
        playSound(ref) {
            this.$refs[ref].pause();
            this.$refs[ref].src = this.$refs[ref].src;
            this.$refs[ref].play();
        },
        stopSound(ref) {
            this.$refs[ref].pause();
            this.$refs[ref].src = this.$refs[ref].src;
        },
        flipCard(wordIndex) {
            // console.log(this.wordList);
            this.wordList[wordIndex].flip = true;
            if (!this.isFlipped) {
                this.firstCardIndex = wordIndex;
                this.isFlipped = true;
                return;
            }
            this.secondCardIndex = wordIndex;
            setTimeout(() => {
                if (this.isMatch()) {
                    this.playSound('success');
                    console.log("matched");
                    this.score++;
                    this.$swal({
                        icon: "success",
                        button: false,
                        position: 'top',
                        timer: 500,
                        className: "game-noti"
                    });
                    this.matchedWords.push(this.wordList[this.firstCardIndex]);
                    this.wordList[this.firstCardIndex].isDisable = true;
                    this.wordList[this.secondCardIndex].isDisable = true;
                    this.isFlipped = false;
                } else {
                    this.playSound('error');
                    this.$swal({
                        position: 'top',
                        icon: "error",
                        button: false,
                        timer: 500,
                        className: "game-noti"
                    });

                    this.wordList[this.firstCardIndex].flip = false;
                    this.wordList[this.secondCardIndex].flip = false;
                    this.isFlipped = false;
                }
            }, 700);
        },

        isMatch() {
            return this.wordList[this.firstCardIndex].word == this.wordList[this.secondCardIndex].word;
        },
        playAgain() {
            this.getWords();
            this.firstCardIndex = 0;
            this.secondCardIndex = 0;
            this.isFlipped = 0;
            this.score = 0;
            this.matchedWords = [];

        },
        getWords() {
            rf.getRequest('WordRequest').getRandomWord().then(res => {
                let image = JSON.parse(JSON.stringify(res)).map(word => {
                    word.type = 'image';
                    word.flip = false;
                    word.isDisable = false;
                    return word;
                });
                console.log(image);
                let word = JSON.parse(JSON.stringify(res)).map(word => {
                    word.type = 'word';
                    word.flip = false;
                    word.isDisable = false;
                    return word;
                })
                console.log(word);
                this.wordList = _.shuffle(word.concat(image));
            })
        }
    },
    created() {
        this.getWords();
    },
    mounted() {
       
    },
}
</script>

<style>
.game-noti {
    width: 148px;
    height: 149px;
    border-radius: 30%;
}

.swal-overlay {
    background-color: transparent;
}
</style>
<style lang="scss" scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Pacifico', cursive;
    margin-top: 61px;
}

li {
    list-style: none;
    display: inline-block;
}

.deck {
    width: 600px;
    height: 600px;
    background-color: #02ccba;
    padding: 22px;
    border-radius: 10px;
    box-shadow: 12px 15px 20px 0 rgba(46, 61, 73, 0.5);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin: auto;
    font-family: 'Pacifico', cursive;
}

.card {
    width: calc(25% - 30px);
    height: calc(25% - 30px);
    margin: 15px;
    position: relative;
    transform-style: preserve-3d;
    perspective: 500px;
    transition: transform .5s;
    cursor: pointer;
}

.front-face,
.back-face {
    width: 100%;
    height: 100% !important;
    padding: 20px;
    position: absolute;
    border-radius: 5px;
    background: #a0d8d2;
    box-shadow: 3px 3px 5px rgba(0, 0, 0, .2);
    backface-visibility: hidden;
    text-align: center;
    word-break: break-word;
    font-size: 23px;
    font-family: "Pacifico", cursive !important;
}

.card.flip {
    transform: rotateY(180deg);
}

.front-face {
    transform: rotateY(180deg);
}

.modal {
    z-index: -1;
    background: rgba(0, 0, 0, .7);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin: auto;
    width: 600px;
    height: 600px;
    border-radius: 10px;
    position: absolute;
    top: 0;
}

h2 {
    text-transform: uppercase;
    color: #eee;
    padding-bottom: 30px;
}

button {
    background-color: #43b948;
    border: none;
    color: #eee;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    text-transform: uppercase;
    outline: none;
}

button:active {
    background-color: #75b778;
}
</style>
