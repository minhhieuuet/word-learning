import BaseModelRequest from './BaseModelRequest';

export default class TranslateRequest extends BaseModelRequest {
    store(params) {
        const url = '/word';
        return this.post(url, params);
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