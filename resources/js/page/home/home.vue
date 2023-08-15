<template>
    <div class="container collapse">
        <div>
            <navigation/>
        </div>
        <div class="container_body">
            <router-view/>
        </div>
    </div>
</template>

<script>
import {check} from '../../shared/models/auth';
import {LoginRoute} from '../index.js';
import Navigation from "../../widget/navigation/navigation.vue";

export default {
    name: "Home",
    components: {Navigation},
    async mounted() {
        if (!await check()) {
            this.$router.replace({name: LoginRoute.name})
        }
    },
}
</script>

<style scoped lang="scss">
.container {
    display: grid;
    grid-template-columns: 200px 100%;
    grid-template-rows: 1fr;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    height: calc(100vh - 200px);
    &.collapse {
        grid-template-columns: 65px 100%;
        div {
            width: calc(100% - 65px);
        }
    }
}
.container_body {
    background: #FFFFFF;
    height: 100%;
    overflow: auto;
    overflow-y: scroll;
}

.container_body::-webkit-scrollbar {
    width: 25px;
}

.container_body::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
}

.container_body::-webkit-scrollbar-thumb {
    background-color: darkgrey;
    outline: 1px solid slategrey;
}
</style>
