<template>
    <div>
        <el-card>
            <template #header>
                <page-header
                    title="Редактирование номера телефона"
                    add-text="Обновить"
                    :show-update="false"
                    @add="updateElement"
                />
            </template>

            <div v-loading="!model.uuid">
                <el-form>
                    <el-form-item label="Номер телефона">
                        <input-phone :value="model.phone" @update="x => {model.phone = x}" tel-code="+7" placeholder="+7(000)000-00-00"/>
                    </el-form-item>
                </el-form>
            </div>
        </el-card>
    </div>
</template>

<script>
import {show, update} from "../../shared/models/phone";
import {message} from "../../widget/dialog/dialog";
import PageHeader from "../../widget/page/pageHeader.vue";
import InputPhone from "../../widget/input/inputPhone.vue";

export default {
    name: 'PhoneUpdate',
    components: {InputPhone, PageHeader},
    created() {
        if (this.$route.params.id) {
            this.phone_uuid = this.$route.params.id
            this.getElement()
        }
    },
    data() {
        return {
            phone_uuid: null,
            model: {
                phone: ''
            }
        }
    },
    methods: {
        async getElement() {
            const {phone_uuid} = this
            const data = await show({phone_uuid})
            if (data.data && data.data.uuid) {
                this.model = data.data
            } else {
                this.$router.back()
                message('Произошла непредвидемая ошибка', 'error')
            }
        },
        async updateElement() {
            if (!this.model) {
                return;
            }

            const data = await update(this.phone_uuid, this.model)

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

</style>
