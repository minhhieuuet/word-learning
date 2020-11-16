import BaseModelRequest from './BaseModelRequest';

export default class CategoryRequest extends BaseModelRequest {
    getCategories(params) {
        const url = '/category';
        return this.get(url, params);
    }

    getPublicCategories(params) {
        const url = '/category/public';
        return this.get(url, params);
    }

    getCategoryIdBySlug(slug) {
        const url = `/category/id-by-slug/${slug}`;
        return this.get(url);
    }
    getCategory(categoryId) {
        const url = `/category/${categoryId}`;
        return this.get(url);
    }

    getWordsByCategory(caregoryId) {
        const url = `/word-by-category/${caregoryId}`;
        return this.get(url);
    }
    store(params) {
        const url = '/category';
        return this.post(url, params);
    }
    update(categoryId, params) {
        const url = `/category/${categoryId}`;
        return this.put(url, params);
    }
    shareCategory(categoryId) {
        const url = `/category/share/${categoryId}`;
        return this.get(url);
    }
    cloneCategory(params) {
        const url = '/category/clone';
        return this.post(url, params);
    }
    getTotalWordByCategories(params) {
        const url = '/category/total-word';
        return this.get(url, params);
    }

    removeCategory(categoryId) {
        const url=`/category/${categoryId}`;
        return this.del(url);
    }

    removeCategoryFromStore(categoryId) {
        const url=`/admin/category/remove-from-store/${categoryId}`;
        return this.post(url);
    }
}