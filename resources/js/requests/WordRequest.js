import BaseModelRequest from './BaseModelRequest';

export default class WordRequest extends BaseModelRequest {
    getAllWords(params) {
        const url = '/word';
        return this.get(url, params);
    }

    getSuggestImages(params) {
        const url = '/word/suggest-image';
        return this.get(url, params);
    }
    store(params) {
        const url = '/word';
        return this.post(url, params);
    }
    quickStore(params) {
        const url = '/word/quick-store';
        return this.post(url, params);
    }
    removeWord(wordId) {
        const url=`/word/${wordId}`;
        return this.del(url);
    }

    updateWord(wordId, params) {
        const url = `/word/${wordId}`;
        return this.put(url, params);
    }
    
    updateWordImage(wordId, params) {
        const url =`/word/update-image/${wordId}`;
        return this.post(url, params);
    }

    increasePriority(ids) {
        return this.post('/word/priority/increase', {ids: ids});
    }

    decreasePriority(ids) {
        return this.post('/word/priority/decrease', {ids: ids});
    }

    changeImportant(wordId) {
        const url = `/word/change-important/${wordId}`;
        return this.get(url);
    }

    getRandomWord() {
        const url = '/random-word';
        return this.get(url);
    }

    getAllPhrases() {
        const url = '/phrases';
        return this.get(url);
    }

    getYoutubeVideos(params) {
        const url = '/word/youtube-videos';
        return this.get(url, params);
    } 

}