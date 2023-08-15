import api from "./../api";
import {AxiosBasicCredentials} from "axios";

export class Auth implements AxiosBasicCredentials {
    username: string;
    password: string;
}

export const logIn = (auth: Auth): Promise<boolean> => {
    return api.get('login', { auth, baseURL: 'oauth/v1' }).then(response => {
        api.defaults.auth = undefined
        return true
    }).catch(reason => {
        return false
    });
};

export const check = (): Promise<boolean> => {
    return api.get('check', { baseURL: 'oauth/v1' }).then(response => {
        return true
    }).catch(reason => {
        return false
    });
}

export const logout = (): Promise<boolean> => {
    return api.get('logout', { baseURL: 'oauth/v1' }).then(response => {
        return true
    }).catch(reason => {
        return false
    });
}
