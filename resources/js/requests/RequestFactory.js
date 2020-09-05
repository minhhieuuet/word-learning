import UserRequest from './UserRequest';
import StudentRequest from './StudentRequest';
import TranslateRequest from './TranslateRequest';
import WordRequest from './WordRequest';
import CategoryRequest from './CategoryRequest';
import GameRequest from './GameRequest';

const requestMap = {
    UserRequest,
    StudentRequest,
    TranslateRequest,
    WordRequest,
    CategoryRequest,
    GameRequest
};

const instances = {};

export default class RequestFactory {

    static getRequest(classname) {
        const RequestClass = requestMap[classname];
        if (!RequestClass) {
            throw new Error(`Invalid request class name: ${classname}`);
        }

        let requestInstance = instances[classname];
        if (!requestInstance) {
            requestInstance = new RequestClass();
            instances[classname] = requestInstance;
        }

        return requestInstance;
    }

}