import type { AxiosPromise } from "axios";
import api from "./../api";

class Message {
    uuid: string;
    body: string;
    created_at: number;
    updated_at: number;
}

export type ListMessageParams = {
    to: number;
    page: number;
};

export const list = (params?: ListMessageParams): AxiosPromise<Message[]> => {
    return api.get('message', { params, baseURL: 'api/v1' });
};

export type CreateMessageParams = {
    body: string;
}

export const create = (message: CreateMessageParams): AxiosPromise<Message> => {
    return api.post('message', message, { baseURL: 'api/v1' });
};

export type ShowMessageParams = { message_uuid: number; };

export const show = ({ message_uuid, ...params }: ShowMessageParams): AxiosPromise<Message> => {
    return api.get(`message/${message_uuid}`, { params, baseURL: 'api/v1' });
};

export const update = (message_uuid: string, params: CreateMessageParams): AxiosPromise<Message> => {
    return api.put(`message/${message_uuid}`, params, { baseURL: 'api/v1' });
};

export const destroy = (message_uuid: string): Promise<boolean> => {
    return api.delete(`message/${message_uuid}`, { baseURL: 'api/v1' }).then(() => true).catch(() => false);
};

export type ShowMessagePhoneParams = {
    phone: string;
    pivot: {
        message_uuid: number;
        phone_uuid: number;
    }
};

export const getMessagePhones = (message_uuid: string): AxiosPromise<ShowMessagePhoneParams[]> => {
    return api.get(`message/${message_uuid}/phone`, { baseURL: 'api/v1' })
};

export const addMessagePhones = (message_uuid: string, phone_uuid: string): AxiosPromise<void> => {
    return api.put(`message/${message_uuid}/phone/${phone_uuid}`, {},{ baseURL: 'api/v1' })
};

export const remMessagePhones = (message_uuid: string, phone_uuid: string): AxiosPromise<void> => {
    return api.delete(`message/${message_uuid}/phone/${phone_uuid}`,{ baseURL: 'api/v1' })
};
