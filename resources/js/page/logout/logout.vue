<template>
    <div>
        <el-card>
            <template #header>Выход</template>
            Вы уверены что хотите выйти?
            <div style="margin-top: 40px">
                <el-button type="success" @click="abortEvent">Нет</el-button>
                <el-button plain type="danger" @click="logOutEvent">Выйти</el-button>
            </div>
        </el-card>
    </div>
</template>

<script>
import {logout} from "../../shared/models/auth";
import {LoginRoute} from "../index.js";

export default {
    name: "Logout",
    methods: {
        abortEvent() {
            this.$router.back()
        },
        async logOutEvent() {
            await logout()
            this.$router.replace({name: LoginRoute.name})
        }
    }
}
</script>

<style scoped>

</style>
