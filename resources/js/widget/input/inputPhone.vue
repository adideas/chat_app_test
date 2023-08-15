<template>
    <div>
        <el-input
            v-if="masked"
            v-model="getterPhone"
            placeholder="+7(000)000-00-00"
            clearable
            @keydown.enter="actionEnter"/>
        <el-input v-else :value="phone"/>
    </div>
</template>

<script>
import IMask from 'imask/esm/imask'
import 'imask/esm/masked/regexp'
export default {
    name: 'InputPhone',
    data() {
        return {
            phone: '',
            oldPhone: '',
            with_emit: true,
            masked: IMask.createMask({ mask: '+{7}(000)000-00-00'}),
            telCode: '+7'
        }
    },
    props: {
        '@enter': { type: Function, default: () => {} },
        '@update': { type: Function, default: () => {} },
        value: { type: String, default: () => '' }
    },
    computed: {
        getterPhone: {
            get() {
                if (!this.masked) {
                    return ''
                }
                return this.masked.value
            },
            set(v) {
                this.masked.resolve(v)
                const value = this.masked.unmaskedValue

                if (String(this.telCode).length) {
                    if (value.slice(0, String(this.telCode).length) !== this.telCode) {
                        this.phone = value
                    }
                } else {
                    this.phone = value
                }
                this.updatePhone()
                this.oldPhone = value
            }
        }
    },
    watch: {
        value(value) {
            this.getPhoneFromProps()
            if (value === '') {
                this.masked.value = ''
            }
        },
        phone(phone) {
            // console.error('watch:' + phone)
        }
    },
    created() {
        this.getPhoneFromProps()
    },
    methods: {
        actionEnter() {
            this.$emit('enter')
        },
        updatePhone() {
            this.with_emit = false
            this.$emit('update', this.phone)
        },
        getPhoneFromProps() {
            if (!this.value) {
                return 0
            }

            if (this.with_emit && this.value) {
                this.with_emit = false
                if (this.value) {
                    if (!this.phone) {
                        this.phone = String(this.value)
                    }

                    const v = String(this.phone)
                    const i = setInterval(() => {
                        if (this.masked) {
                            this.masked.resolve(v)
                            setTimeout(() => {
                                this.masked.resolve(v)
                            }, 200)
                            clearInterval(i)
                        }
                    }, 100)
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
