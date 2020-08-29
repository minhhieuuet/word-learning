import BaseModelRequest from './BaseModelRequest';

export default class TranslateRequest extends BaseModelRequest {
    store(params) {
        const url = '/word';
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
    
    getRandomWord() {
        const url = '/random-word';
        return this.get(url);
    }

    getAllPhrases() {
        const url = '/phrases';
        return this.get(url);
    }

}