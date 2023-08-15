import type { AxiosPromise } from "axios";
import api from "./../api";

class Phone {
    uuid: string;
    phone: string;
    created_at: number;
    updated_at: number;
}

export type ListPhoneParams = {
    to: number;
    page: number;
};

export const list = (params?: ListPhoneParams): AxiosPromise<Phone[]> => {
    return api.get('phone', { params, baseURL: 'api/v1' });
};

export type CreatePhoneParams = {
    phone: string;
}

export const create = (message: CreatePhoneParams): AxiosPromise<Phone> => {
    return api.post('phone', message, { baseURL: 'api/v1' });
};

export type ShowParams = { phone_uuid: number; };

export const show = ({ phone_uuid, ...params }: ShowParams): AxiosPromise<Phone> => {
    return api.get(`phone/${phone_uuid}`, { params, baseURL: 'api/v1' });
};

export const update = (phone_uuid: string, params: CreatePhoneParams): AxiosPromise<Phone> => {
    return api.put(`phone/${phone_uuid}`, params, { baseURL: 'api/v1' });
};

export const destroy = (phone_uuid: string): Promise<boolean> => {
    return api.delete(`phone/${phone_uuid}`, { baseURL: 'api/v1' }).then(() => true).catch(() => false);
};
