import {createRouter, createWebHashHistory} from 'vue-router'
import {
    Message as MessageIcon,
    Phone as PhoneIcon,
    Close as LogoutIcon,
    Share as HorizonIcon,
    Setting as ChatAppIcon,
    Check as ReportIcon
} from '@element-plus/icons-vue'
import Login from './login/login.vue'
import Home from './home/home.vue'
import Message from './message/message.vue'
import MessageAdd from './message/messageAdd.vue'
import MessageUpdate from './message/messageUpdate.vue'
import Phone from './phone/phone.vue'
import PhoneAdd from './phone/phoneAdd.vue'
import PhoneUpdate from './phone/phoneUpdate.vue'
import Logout from './logout/logout.vue'
import Horizon from './horizon/horizon.vue'
import ChatApp from './chatApp/chatApp.vue'
import Report from './report/report.vue'

export const LoginRoute = {
    path: '/',
    name: "Login",
    component: Login
}

export const MessageRoute = {
    path: '/message',
    name: "Message",
    component: Message,
    meta: {icon: MessageIcon, title: 'Сообщения'}
}

export const MessageAddRoute = {
    path: '/message/create',
    name: "MessageAdd",
    component: MessageAdd
}
export const MessageUpdateRoute = {
    path: '/message/:id',
    name: "MessageUpdate",
    component: MessageUpdate
}

export const PhoneRoute = {
    path: '/phone',
    name: "Phone",
    component: Phone,
    meta: {icon: PhoneIcon, title: 'Телефоны'}
}

export const PhoneAddRoute = {
    path: '/phone/create',
    name: "PhoneAdd",
    component: PhoneAdd
}
export const PhoneUpdateRoute = {
    path: '/phone/:id',
    name: "PhoneUpdate",
    component: PhoneUpdate
}

export const LogoutPage = {
    path: '/logout',
    name: "Logout",
    component: Logout,
    meta: {icon: LogoutIcon, title: 'Выйти'}
}

export const ChatAppPage = {
    path: '/chat-app',
    name: "ChatApp",
    component: ChatApp,
    meta: {icon: ChatAppIcon, title: 'ChatApp'}
}
export const HorizonPage = {
    path: '/horizon',
    name: "Horizon",
    component: Horizon,
    meta: {icon: HorizonIcon, title: 'Horizon'}
}

export const ReportPage = {
    path: '/report',
    name: "Report",
    component: Report,
    meta: {icon: ReportIcon, title: 'Отчет отправки'}
}

export const HomeRoute = {
    path: '/home',
    name: "Home",
    component: Home,
    children: [
        MessageRoute, MessageAddRoute, MessageUpdateRoute,
        PhoneRoute, PhoneAddRoute, PhoneUpdateRoute,
        ReportPage,
        HorizonPage,
        ChatAppPage,
        LogoutPage
    ]
}

const routes = [
    LoginRoute,
    HomeRoute
];

export default createRouter({
    history: createWebHashHistory(),
    routes,
})
