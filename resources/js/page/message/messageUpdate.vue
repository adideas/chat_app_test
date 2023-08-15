<template>
    <div>
        <el-card>
            <template #header>
                <page-header
                    title="Редактирование сообщения"
                    add-text="Обновить"
                    :show-update="false"
                    @add="updateMessage"
                />
            </template>

            <div v-loading="!model.uuid">
                <el-form>
                    <el-form-item label="Сообщение">
                        <el-input class="el-col-24" v-model="model.body" type="textarea"/>
                    </el-form-item>
                </el-form>
            </div>
            <div v-loading="!model.uuid" class="container_other">
                <el-button type="success">Добавить номера телефонов</el-button>
            </div>
        </el-card>

        <drawer-add-phone v-if="model.uuid" :id="model.uuid"/>
    </div>
</template>

<script>
import {show, update} from "../../shared/models/message";
import {message} from "../../widget/dialog/dialog";
import PageHeader from "../../widget/page/pageHeader.vue";
import DrawerAddPhone from "./component/drawerAddPhone.vue";

export default {
    name: 'MessageUpdate',
    components: {DrawerAddPhone, PageHeader},
    created() {
        if (this.$route.params.id) {
            this.message_uuid = this.$route.params.id
            this.getMessage()
        }
    },
    data() {
        return {
            message_uuid: null,
            model: {
                body: ''
            }
        }
    },
    methods: {
        async getMessage() {
            const {message_uuid} = this
            const data = await show({message_uuid})
            if (data.data && data.data.uuid) {
                this.model = data.data
            } else {
                this.$router.back()
                message('Произошла непредвидемая ошибка', 'error')
            }
        },
        async updateMessage() {
            if (!this.model) {
                return;
            }

            const data = await update(this.message_uuid, this.model)

            if (data.status === 200) {
                this.$router.back()
            } else {
                message('Произошла непредвидемая ошибка', 'error')
            }
        }
    }
}
</script>

<style scoped>
.container_other {
    display: flex;
    justify-content: end;
}
</style>
