<template>
    <el-drawer :model-value="true" size="50%">
        <template #header>
            <h2>Телефоны</h2>
        </template>

        <div class="info">
            <el-alert type="success" :closable="false">
                <h2>Enter -> addPhone</h2>
            </el-alert>
        </div>

        <input-phone v-loading="loadingPhone" :value="phone" @update="x => {phone = x}" @enter="addPhone"/>

        <div>
            <el-alert v-for="(phone, index) in phones" type="success" :closable="false" :key="index">
                <div class="phone_item">{{ phone }}</div>
            </el-alert>
        </div>
    </el-drawer>
</template>

<script>
import InputPhone from "../../../widget/input/inputPhone.vue";
import {message} from "../../../widget/dialog/dialog";
import {create} from "../../../shared/models/phone";
import {addMessagePhones, getMessagePhones} from "../../../shared/models/message";

export default {
    name: 'DrawerAddPhone',
    components: {InputPhone},
    props: {
      id: {type: String, required: true}
    },
    data() {
      return {
          phone: '',
          cache: new Set(),
          phones: [],
          loadingPhone: false
      }
    },
    created() {
        getMessagePhones(this.id).then(({data}) => {
            data.forEach(item => {
                this.phones.push(item.phone)
                this.cache.add(item.phone)
            })
        })
    },
    methods: {
        addPhone() {
            if (this.phone.length === 11) {
                if (this.cache.has(this.phone)) {
                    message('Этот телефон уже добавлен','error')
                    this.phone = ''
                    return;
                }
                this.loadingPhone = true
                create({phone: this.phone}).then(({data}) => {
                    return addMessagePhones(this.id, data.uuid).then(() => {
                        this.phones.unshift(this.phone)
                        this.cache.add(this.phone)
                        this.phone = ''
                    })
                }).catch(() => {
                    message('Пройзошла непредвиземая ошибка','error')
                }).finally(() => {
                    this.loadingPhone = false
                })
            } else {
                message('В номере телефона должно быть 11 символов','error')
            }
        }
    }
}
</script>

<style scoped>
.info {
    margin-bottom: 20px;
}
.phone_item {
    font-size: 16px;
}
</style>
