<template>
    <el-dialog :model-value="true" title="ChatApp">
        <el-form>
            <el-form-item label="Email">
                <el-input v-model="model.email" name="email"/>
            </el-form-item>
            <el-form-item label="Password">
                <el-input v-model="model.password" type="password" name="password"/>
            </el-form-item>
            <el-form-item label="AppID">
                <el-input v-model="model.appId"/>
            </el-form-item>
        </el-form>
        <template #footer>
            <div>
                <el-button type="success" @click="actionOauth">Авторизовать</el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import {create} from "../../shared/models/chatApp";

export default {
    name: "chatAppDialog",
    props: {
        '@update': {type: Function, default: () => {}},
    },
    data() {
        return {
            model: {
                email: '',
                password: '',
                appId: ''
            }
        }
    },
    methods: {
        actionOauth() {
            create(this.model).then(() => {
                this.$emit('update')
            })
        }
    }
}
</script>

<style scoped>

</style>
