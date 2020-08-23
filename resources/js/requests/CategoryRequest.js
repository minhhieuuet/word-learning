import BaseModelRequest from './BaseModelRequest';

export default class CategoryRequest extends BaseModelRequest {
    getCategories(params) {
        const url = '/category';
        return this.get(url, params);
    }
    getWordsByCategory(caregoryId) {
        const url = `/word-by-category/${caregoryId}`;
        return this.get(url);
    }
    store(params) {
        const url = '/word';
        return this.post(url, params);
    }

}