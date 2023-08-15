<template>
    <div>

        <div v-if="!loadingTokens && tokens.length === 0">
            <chat-app-dialog @update="getAll()"/>
        </div>

        <el-card>
            <template #header>
                <page-header
                    title="ChatApp токен"
                    :show-add="false"
                    @update="getTokens"
                />
            </template>

            <el-table v-loading="loadingTokens" :data="tokens">
                <el-table-column prop="cabinetUserId" label="token"/>
                <el-table-column prop="accessTokenEndTime" label="Истечение до">
                    <template #default="data">
                        {{ new Date(data.row.accessTokenEndTime * 1000).toLocaleString() }}
                    </template>
                </el-table-column>
                <el-table-column prop="refreshTokenEndTime" label="Востановление до">
                    <template #default="data">
                        {{ new Date(data.row.refreshTokenEndTime * 1000).toLocaleString() }}
                    </template>
                </el-table-column>
                <el-table-column label="Действие" width="200" align="right">
                    <template #default="data">
                        <el-button @click="actionRefreshToken(data.row)">
                            <el-icon><refresh/></el-icon>
                        </el-button>
                        <el-button @click="actionDeleteToken(data.row)">
                            <el-icon><delete/></el-icon>
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>

        </el-card>

        <el-card style="margin-top: 20px;">
            <template #header>
                <page-header
                    title="ChatApp лицензии"
                    :show-add="false"
                    @update="getLicenses"
                />
            </template>

            <el-table v-loading="loadingLicenses" :data="licenses">
                <el-table-column prop="licenseId" label="Лицензия"/>
                <el-table-column prop="licenseTo" label="Истечение до">
                    <template #default="data">
                        {{ new Date(data.row.licenseTo * 1000).toLocaleString() }}
                    </template>
                </el-table-column>
                <el-table-column prop="isUse" label="Использовать?">
                    <template #default="data">
                        <el-checkbox :model-value="!!data.row.isUse" @change="changeLicense(data.row)"/>
                    </template>
                </el-table-column>
            </el-table>

        </el-card>

        <el-card style="margin-top: 20px;">
            <template #header>
                <page-header
                    title="ChatApp web-hooks"
                    :show-add="false"
                    @update="getWebHook"
                />
            </template>

            <el-table v-loading="loadingWebHook" :data="webHooks">
                <el-table-column prop="licenseId" label="Лицензия"/>
                <el-table-column prop="type" label="Тип"/>
                <el-table-column prop="url" label="Адрес"/>
            </el-table>

        </el-card>
    </div>
</template>

<script>
import { Delete, Refresh } from '@element-plus/icons-vue'
import PageHeader from "../../widget/page/pageHeader.vue";
import {
    callbackList,
    licenseChange,
    licenseList,
    tokenList,
    tokenRefresh,
    tokenRemove
} from "../../shared/models/chatAppConfig";
import {alert, message} from "../../widget/dialog/dialog";
import ChatAppDialog from "../../widget/chatAppDialog/chatAppDialog.vue";

export default {
    name: 'ChatApp',
    components: {ChatAppDialog, PageHeader, Delete, Refresh},
    data() {
      return {
          loadingTokens: false,
          tokens: [],
          loadingLicenses: false,
          licenses: [],
          loadingWebHook: false,
          webHooks: [],
      }
    },
    created() {
        this.getAll()
    },
    methods: {
        getAll() {
            this.getTokens()
            this.getLicenses()
            this.getWebHook()
        },
        async getTokens() {
            this.loadingTokens = true
            const data = await tokenList()
            this.tokens = data.data
            this.loadingTokens = false
        },
        async getLicenses() {
            this.loadingLicenses = true
            const data = await licenseList()
            this.licenses = data.data
            this.loadingLicenses = false
        },
        async getWebHook() {
            this.loadingWebHook = true
            const data = await callbackList()
            this.webHooks = data.data
            this.loadingWebHook = false
        },
        /**
         * @param {License} license
         */
         changeLicense(license) {
            alert('Внимание', 'Переключить лицензию?').then(async () => {
                this.loadingLicenses = true
                await licenseChange(license.licenseId)
                await this.getLicenses()
                this.loadingLicenses = false
            })
        },
        /**
         * @param {Token} token
         */
        actionRefreshToken(token) {
            alert('Внимание', 'Попытатся обновить токен?').then(async () => {
                this.loadingTokens = true
                await tokenRefresh(token.cabinetUserId).catch(() => {
                    message('Не удалось обновить токен', 'error')
                })
                await this.getTokens()
                this.loadingTokens = false
            })
        },
        /**
         * @param {Token} token
         */
        actionDeleteToken(token) {
            alert('Внимание', 'Удалить токен?').then(async () => {
                this.loadingTokens = true
                await tokenRemove(token.cabinetUserId).catch(() => {
                    message('Не удалось удалить токен', 'error')
                })
                await this.getTokens()
                this.loadingTokens = false

                await this.getLicenses()
                await this.getWebHook()
            })
        }
    }
}
</script>

<style scoped>

</style>
