<template>
    <div>
        <el-card>
            <template #header>
                <page-header
                    title="Отчет отправки"
                    @update="getData"
                    :show-add="false"
                />
            </template>

            <el-table :data="tableData" v-loading="actionLoadingTableData" empty-text="Нет телефоов">
                <el-table-column label="Телефон" prop="phone.phone"></el-table-column>
                <el-table-column label="Сообщение" prop="message.body"></el-table-column>
                <el-table-column label="Отправлено">
                    <template #default="data">
                        <el-checkbox :model-value="!!data.row.token_message"/>
                    </template>
                </el-table-column>


                <el-table-column label="Статус" prop="status"></el-table-column>
                <el-table-column label="Ошибка" prop="error_message"></el-table-column>
            </el-table>

            <pagination :disabled="actionLoadingTableData" :data="table"/>
        </el-card>
    </div>
</template>

<script>
import PageHeader from "../../widget/page/pageHeader.vue";
import {list} from "../../shared/models/report";
import Pagination from "../../widget/pagination/pagination.vue";

export default {
    name: 'Report',
    components: {Pagination, PageHeader},
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
        }
    }
}
</script>

<style scoped>

</style>
