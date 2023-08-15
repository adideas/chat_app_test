<template>
    <div>
        <hr/>
        <div class="about_text">Войти через</div>
        <div class="container">
            <el-tooltip content="Войти с помощью ChatApp">
                <div class="chatApp" @click="openChatApp"/>
            </el-tooltip>
        </div>
        <chat-app-dialog v-if="visible"/>
    </div>
</template>

<script>
import ChatAppDialog from "../chatAppDialog/chatAppDialog.vue";

export default {
    name: "sso",
    components: {ChatAppDialog},
    data() {
        return {
            visible: false
        }
    },
    methods: {
        openChatApp() {
            this.visible = true
        }
    }
}
</script>

<style scoped lang="scss">
.container {
    width: 100%;
    display: flex;
    justify-content: center;

    div.chatApp {
        width: 60px;
        content: url(https://cabinet.chatapp.online/img/logo.png);
    }
}
.about_text {
    color: #b5b5b5;
    font-size: 0.9em;
}
</style>
