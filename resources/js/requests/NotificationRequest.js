import BaseModelRequest from './BaseModelRequest';

export default class NotificationRequest extends BaseModelRequest {

    saveToken(params) {
        const url = '/notification/save-token';
        return this.post(url, params);
    }

    getToken() {
        const url = '/notification/get-token';
        return this.get(url);
    }

    sendTestNotification() {
        const url = '/notification/test';
        return this.post(url);
    }

}