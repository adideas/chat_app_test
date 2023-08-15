<template>
    <el-page-header @back="actionGoBack" title="Назад">
        <template #content><span class="text-large font-600 mr-3"> {{ title }} </span></template>
        <template #extra>
            <div class="flex items-center">
                <el-button v-if="showUpdate" plain class="ml-2" @click="actionRefresh">
                    <el-icon><refresh/></el-icon>
                </el-button>
                <el-button v-if="showAdd" type="primary" class="ml-2" @click="actionAdd">
                    {{addText}} <el-icon style="margin-left: 10px"><document-add/></el-icon>
                </el-button>
            </div>
        </template>
    </el-page-header>
</template>

<script>
import {DocumentAdd, Refresh} from '@element-plus/icons-vue'
export default {
    name: 'PageHeader',
    components: {DocumentAdd, Refresh},
    props: {
        '@update': {type: Function, default: () => {}},
        '@add': {type: Function, default: () => {}},
        addText: {type: String, default: () => 'Добавить'},
        showAdd: {type: Boolean, default: () => true},
        showUpdate: {type: Boolean, default: () => true},
        title: {type: String, default: () => ''}
    },
    methods: {
        actionGoBack() {
            this.$router.back()
        },
        actionRefresh() {
            this.$emit('update')
        },
        actionAdd() {
            this.$emit('add')
        }
    }
}
</script>

<style scoped>

</style>
