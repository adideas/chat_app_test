<template>
    <div>
        <el-card>
            <template #header>
                <page-header
                    title="Телефоны"
                    @update="getData"
                    @add="actionCreateNew"
                />
            </template>

            <el-table :data="tableData" v-loading="actionLoadingTableData" empty-text="Нет телефоов">
                <el-table-column label="Телефон" prop="phone"></el-table-column>
                <el-table-column label="Действие" width="200" align="right">
                    <template #default="data">
                        <el-button @click="actionEdit(data.row)">
                            <el-icon><edit/></el-icon>
                        </el-button>
                        <el-button @click="actionDelete(data.row)">
                            <el-icon><delete/></el-icon>
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>

            <pagination :disabled="actionLoadingTableData" :data="table"/>
        </el-card>
    </div>
</template>

<script>
import {alert} from "../../widget/dialog/dialog";
import PageHeader from "../../widget/page/pageHeader.vue";
import {destroy, list} from "../../shared/models/phone";
import Pagination from "../../widget/pagination/pagination.vue";
import {PhoneAddRoute, PhoneUpdateRoute} from "../index.js";

import { Delete, Edit } from '@element-plus/icons-vue'

export default {
    name: 'Phone',
    components: {Pagination, PageHeader, Delete, Edit},
    data() {
        return {
            actionLoadingTableData: false,
            query: {to: 10, page: 1},
            table: null
        }
    },
    computed: {
        tableData() {
            if (this.table && this.table.data) {
                return this.table.data
            }
            return []
        }
    },
    created() {
        this.getData()
    },
    methods:{
        async getData() {
            this.actionLoadingTableData = true
            const table = await list(this.query)
            if (table.data) {
                this.table = table.data
            } else {
                this.table = null
            }
            this.actionLoadingTableData = false
        },
        actionCreateNew() {
            this.$router.push({name: PhoneAddRoute.name})
        },
        /**
         * @param {Phone} item
         */
        actionDelete(item) {
            alert('Внимание', 'Вы хотите удалить этот элемент?').then(async () => {
                const data = await destroy(item.uuid)
                if (data) {
                    await this.getData()
                }
            }).catch(() => {})
        },
        /**
         * @param {Phone} item
         */
        actionEdit(item) {
            this.$router.push({name: PhoneUpdateRoute.name, params: {id: item.uuid}})
        }
    }
}
</script>

<style scoped>

</style>
