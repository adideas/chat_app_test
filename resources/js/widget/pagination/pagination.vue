<template>
    <div style="width: 100%; display: flex; justify-content: center; margin: 30px 0;">
        <el-pagination
            :disabled="disabled"
            :current-page="(data && data.current_page) ? data.current_page : 0"
            :page-size="(data && data.per_page) ? data.per_page : 0"
            :total="(data && data.total) ? data.total : 0"
            :page-sizes="[10, 25, 50]"
            background
            layout="total, sizes, prev, pager, next"
            @size-change="setTo"
            @current-change="setPage"
        />
    </div>
</template>

<script>
export default {
    name: "pagination",
    props: {
        '@query': {type: Function, default: () => {}},
        disabled: {type: Boolean, default: () => false},
        data: {type: Object, default: () => null}
    },
    data() {
        return {
            query: {to: 10, page: 1},
            timeout: null
        }
    },
    methods: {
        setTo(to) {
            this.query.to = to
            this.eventToParent()
        },
        setPage(page) {
            this.query.page = page
            this.eventToParent()
        },
        eventToParent() {
            if (this.timeout) {
                clearTimeout(this.timeout)
            }
            this.timeout = setTimeout(() => {
                this.$emit('query', this.query)
            }, 400)
        }
    }
}
</script>

<style scoped>

</style>
