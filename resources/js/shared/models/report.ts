import type { AxiosPromise } from "axios";
import api from "./../api";
import {ListPhoneParams} from "./phone";

export type ListReportParams = {
    to: number;
    page: number;
};

class ReportItem {
    error_message: string;
    message_uuid: string;
    phone_uuid: string;
    status: string;
    token_message: string;

    phone: {
        phone: string;
        uuid: string;
    };
    message: {
        body: string;
        uuid: string;
    };
}

export const list = (params?: ListPhoneParams): AxiosPromise<ReportItem[]> => {
    return api.get('report', { params, baseURL: 'api/v1' });
};
