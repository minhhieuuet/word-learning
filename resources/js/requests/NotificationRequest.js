import BaseModelRequest from './BaseModelRequest';

export default class NotificationRequest extends BaseModelRequest {

    saveToken(params) {
        const url = '/notification/save-token';
        return this.post(url, params);
    }

}