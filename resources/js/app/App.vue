<template>
    <div id="app">
        <div class="header">
            <img src="https://chatapp.online/pictures/svg//chatapp-logo-text.svg" class="chatApp">
        </div>

        <router-view></router-view>

        <div class="footer">
            <div class="links">
                <span>
                    <a href="docs" target="_blank">
                        <el-button type="text">API Docs</el-button>
                    </a>
                </span>
                <span>
                    <a href="https://chatapp.online/" target="_blank">
                        <el-button type="text">Powered by ChatApp</el-button>
                    </a>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import Login from "../page/login/login.vue";

export default {
    name: "App",
    components: {Login}
}
</script>

<style lang="scss">
#app {
    font-family: Roboto, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
body {
    margin: 0;
    padding: 0;
    background: #FFFFFF;
    background-size: contain;
}
.footer,
.header {
    padding: 20px 20px;
    color: #f0f4f8;
    display: flex;
    justify-content: center;
    align-items: center;
    h1,
    h2,
    h3 {
        color: #f0f4f8;
        padding: 0;
        margin: 0;
    }
    .links {
        display: flex;
        span {
            padding: 0 10px;
            font-size: 18px;
            border-right: 1px solid #9fb3c8;
            &:last-child {
                border-right: none;
            }
        }
    }
    .version {
        font-family: "Open Sans";
        padding: 0 10px;
        color: #9fb3c8;
        font-size: 12px;
        margin-top: 5px;
    }
}
.header {
    padding: 10px 20px;
    img.bot {
        width: 50px;
        height: 50px;
        letter-spacing: 3px;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    img.chatApp {
        margin-left: 20px;
        width: 150px;
        height: 34px;
        padding-top: 15px;
        padding-bottom: 0;
    }
}
</style>
