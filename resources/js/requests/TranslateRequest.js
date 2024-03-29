import BaseModelRequest from './BaseModelRequest';

export default class TranslateRequest extends BaseModelRequest {
    translate(params) {
        const url = '/translate';
        return this.get(url, params);
    }
    
    translateToEn(params) {
        const url = '/translate-to-en';
        return this.get(url, params);
    }

}