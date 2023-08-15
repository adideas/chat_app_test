<template>
    <div class="login">
        <el-card v-loading="actionCheckAuth" style="width: 400px;">
            <template #header>Вход</template>

            <el-form @submit.native.prevent="login">

                <el-form-item>
                    <el-input v-model="model.username" placeholder="Почта или Email">
                        <template #prefix>
                            <el-icon class="el-input__icon">
                                <avatar/>
                            </el-icon>
                        </template>
                    </el-input>
                </el-form-item>

                <el-form-item>
                    <el-input v-model="model.password" placeholder="Пароль" type="password">
                        <template #prefix>
                            <el-icon class="el-input__icon">
                                <lock/>
                            </el-icon>
                        </template>
                    </el-input>
                </el-form-item>

                <el-form-item>
                    <el-button
                        :loading="actionLogIn"
                        :disabled="actionLogIn"
                        style="width: 100%"
                        type="success"
                        native-type="submit"
                        block>
                        Войти
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
import {Avatar, Lock} from '@element-plus/icons-vue'
import {logIn, check} from '../../shared/models/auth'
import {HomeRoute} from "../index.js";

export default {
    name: "Login",
    components: {Avatar, Lock},
    data() {
        return {
            actionCheckAuth: true,
            actionLogIn: false,
            loading: false,
            model: {
                username: 'admin@admin.ru',
                password: '123456'
            }
        };
    },
    async mounted() {
        if (await check()) {
            this.$router.replace({name: HomeRoute.name})
        }
        this.actionCheckAuth = false
    },
    methods: {
        async login() {
            this.actionLogIn = true;
            if (await logIn(this.model)) {
                this.$message.success("Login success");
                this.$router.push({name: HomeRoute.name})
            }
            this.actionLogIn = false;
        }
    }
};
</script>

<style scoped>
.login {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

el-card {
    background: red;
}
</style>

