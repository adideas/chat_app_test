<template>
    <el-menu @select="handleOpen" collapse>
        <el-menu-item v-for="(nav, index) in routes" :index="index">
            <el-icon><component :is="nav.meta.icon"/></el-icon>
            <template #title>{{ nav.meta.title }}</template>
        </el-menu-item>
    </el-menu>
</template>

<script>
import {HomeRoute} from "../../page/index";

export default {
    name: 'Navigation',
    computed: {
        routes() {
            return HomeRoute.children.filter((item) => !!item.meta)
        }
    },
    methods: {
        handleOpen(identify) {
            //const route = this.routes.findIndex((item) => item.name === identify)
            const route = this.routes[identify]
            this.$router.replace({name: route.name})
        }
    }
}
</script>

<style scoped>
</style>
