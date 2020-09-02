<template>
<div class="hangman" style="background-color: aliceblue;">
    <div class="guess">
        <ul class="word">
            <li v-for="(character, index) in characters" :key="character" :class="{letter: true, 'true-letter': isCompletedWord, 'wrong-letter': isVisibleWrong}" :data-pos="index" v-if="character.content != ' '">
                {{ character.isVisible || character.isVisibleWrong  ? character.content : '&nbsp;' }}
            </li>
            <li v-else class="space-letter">

            </li>
        </ul>
    </div>
    <div class="guessForm">
        <md-input v-model="inputCharacter" @keyup.enter="submit" type="text" maxlength="1"></md-input>
        <button @click="submit" class="guessButton">Đoán</button>
    </div>
    <div>
        <a-icon class="heart-icon" v-for="i in lifeScore" :key="i" type="heart" theme="filled" two-tone-color="#e60965" />
        <a-icon class="heart-disabled-icon" v-for="i in (5-lifeScore)" :key="i" type="heart" theme="twoTone" two-tone-color="#40012c" />
    </div>
    <h4 class="hint"><b>Gợi ý:</b> &nbsp;{{currentWord.hint}}</h4>
    <div class="wrong">
        <ul class="wrongLetters">
            <!-- <p>Wrong Letters: </p> -->
            <li v-for="character in wrongCharacters" :key="character">{{character}}</li>
        </ul>
    </div>
    <transition name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
        <div class="message" v-show="isWinner">
            <h1 class="title" style="display: block;">Chúc mừng, bạn đã chiến thắng</h1>
            <p class="text" style="display: block;">You solved the word in
                <span class="highlight">13</span> Guesses!<br>Score: <span class="highlight">38%</span>
            </p>
            <button class="restart button" style="display: inline-block;">Chơi lại</button>
        </div>
    </transition>
</div>
</template>

<script>
export default {

    data() {
        return {
            words: [{
                    word: 'Gender',
                    hint: 'Day la gioi tinh',
                    meaning: 'hihi'
                },
                {
                    word: 'Result',
                    hint: 'Day la ket qua',
                    meaning: 'result'
                }
            ],
            currentWord: {},
            currentWordIndex: 0,
            inputCharacter: '',
            characters: [],
            wrongCharacters: [],
            isWinner: false,
            isCompletedWord: false,
            isVisibleWrong: false,
            lifeScore: 5
        }
    },
    watch: {
        inputCharacter: {
            handler() {
                this.inputCharacter = this.inputCharacter.toUpperCase();
            }
        },
        characters: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                console.log(this.characters);
                if (this.characters && this.characters.length) {
                    let isRemainingChar = !!this.characters.find((character) => {
                        return character.isVisible == false && character.content != ' ';
                    });
                    if (!isRemainingChar) {

                        this.currentWordIndex = this.currentWordIndex + 1;
                        if (!this.words[this.currentWordIndex]) {
                            console.log("win");
                            this.winGame();
                            return;
                        }
                        this.isCompletedWord = true;
                        setTimeout(() => {
                            this.currentWord = this.words[this.currentWordIndex];
                            this.isCompletedWord = false;
                        }, 2000);
                        console.log(this.currentWordIndex);
                    }
                }
            }
        },
        currentWord: {
            handler() {
                this.setCharacters(this.currentWord.word);
            }
        },
        lifeScore: {
            handler() {
                if (this.lifeScore == 0) {
                    this.isVisibleWrong = true;
                    this.showAllCharacter();
                    setTimeout(() => {
                        this.currentWordIndex = this.currentWordIndex + 1;
                        this.currentWord = this.words[this.currentWordIndex];
                        this.resetWord();
                    }, 2000);
                }
            }
        }
    },
    methods: {
        submit() {
            let inputCharacter = this.inputCharacter.trim().toLowerCase();
            if (!inputCharacter) {
                this.inputCharacter = '';
                return;
            }
            if (this.characters.find(character => character.content == inputCharacter)) {
                this.characters = [...this.characters].map(character => {
                    return {
                        content: character.content,
                        isVisible: character.content == inputCharacter || character.isVisible
                    }
                });
                this.inputCharacter = '';
                return;
            }
            if (this.wrongCharacters.indexOf(inputCharacter) == -1) {
                this.wrongCharacters.push(inputCharacter);
                this.lifeScore--;
            }
            this.inputCharacter = '';

        },
        setCharacters(word) {
            this.characters = word.split('').map(word => {
                return {
                    content: word.toLowerCase(),
                    isVisible: false
                }
            });
        },
        winGame() {
            this.isWinner = true;
        },
        resetWord() {
            this.lifeScore = 5;
            this.wrongCharacters = [];
            this.isVisibleWrong = false;
        },
        showAllCharacter() {
            this.characters = this.characters.map(character => {
                character.isVisibleWrong = true;
                return character;
            });
        }
    },
    mounted() {
        this.currentWord = this.words[this.currentWordIndex];
        this.characters = this.setCharacters(this.currentWord.word);
    }
}
</script>

<style lang="scss" scoped>
$blue: #53BDFF;
$green: #2EB933;
$drk-blue: darken($blue, 10%);

a {
    color: $blue;
    text-decoration: none;
    font-size: 14px;
    font-family: 'Pacifico', cursive;

    &:hover {
        color: lighten($blue, 10%);
    }
}

.hangman {
    margin: 0 auto;
    text-align: center;
    padding: 10px;

}

h1 {
    font-size: 50px;
    margin-bottom: 20px;
    color: $blue;
    font-weight: 300;
}

p {
    margin-bottom: 20px;
    color: gray;
    line-height: 1.3;

}

@keyframes letteranim {
    50% {
        transform: translateY(-5px) scale(1.05);
    }
}

.letter {
    display: inline-block;
    // color: transparent;
    border-bottom: 5px solid $blue;
    margin: 0 10px;
    font-size: 50px;
    padding: 10px;
    transition: .5s;
    width: 60px;
    font-family: 'Signika Negative', sans-serif;
}

.true-letter {
    transition: 0.7s ease-in-out;
    color: #46a727;
    border-bottom: 5px solid #17dc69db;
}

.wrong-letter {
    transition: 0.7s ease-in-out;
    color: #b4410c;
    border-bottom: 5px solid #e40c0cdb;
}

.space-letter {
    display: inline-block;
    // color: transparent;
    margin: 0 10px;
    font-size: 50px;
    padding: 10px;
    transition: .5s;
}

.word {
    display: block;
    white-space: nowrap;

    li {
        text-transform: uppercase;
    }

}

.heart-icon {
    font-size: 25px;
    color: #e60965;
}

.heart-disabled-icon {
    font-size: 25px;
    color: #856974;
}

.correct {
    color: $blue;
    text-shadow: 1px 2px 0 $drk-blue;
    animation: letteranim .3s ease;
}

.guessForm {
    margin: 20px auto 0;

    .guessButton {
        font-family: 'Signika Negative', sans-serif;

    }

    input[type="text"] {
        outline: none;
        padding: 10px;
        font-size: 30px;
        margin-bottom: 20px;
        margin-right: 5px;
        border: 1px solid #aaa;
        color: gray;
        width: 170px;
        font-family: 'Signika Negative', sans-serif;
    }

    .guessButton {
        border: none;
        font-size: 30px;
        padding: 10px 20px;
        cursor: pointer;
        background: $blue;
        color: white;
        transition: .3s;
        margin: 10px 0;
        text-shadow: 1px 2px 0 $drk-blue;

        &:hover {
            background: $drk-blue;
        }
    }
}

.wrongLetters {
    font-size: 20px;
    font-family: 'Signika Negative', sans-serif;

    p {
        margin-bottom: 10px;
    }

    li {
        display: inline-block;
        font-size: 40px;
        background: lighten(red, 15%);
        text-shadow: 1px 2px 0 red;
        padding: 10px;
        color: white;
        margin-right: 10px;
        animation: letteranim .3s ease;
    }
}

.message {
    padding: 20px;
    position: absolute;
    top: 110px;
    right: 0;
    bottom: 0;
    width: 86%;
    /*   height: 100%; */
    background: darken($drk-blue, 10%);
    z-index: 12402402;

    h1 {
        display: none;
        color: white;
        text-shadow: 1px 2px 0 #ccc;
    }

    .highlight {
        color: yellow;
        text-transform: capitalize;
    }

    .text {
        color: white;
        font-size: 30px;
        display: none;

        p {
            color: white;
        }

        .highlight {
            font-size: 40px;
        }
    }

    .muted {
        margin: 20px auto;
        color: lighten($blue, 10%);
    }
}

.button {
    display: none;
    margin: 10px 0;
    border: none;
    font-size: 30px;
    padding: 10px 20px;
    cursor: pointer;
    background: lighten($green, 5%);
    color: white;
    transition: .3s;
    text-shadow: 1px 2px 0 $green;

    &:hover {
        background: lighten($green, 20%);

    }
}

.hint {}
</style>
