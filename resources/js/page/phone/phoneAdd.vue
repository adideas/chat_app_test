<template>
  <div>
      <el-card>
          <template #header>
              <page-header
                  title="Добавление номера телефона"
                  add-text="Сохранить"
                  :show-update="false"
                  @add="createNew"
              />
          </template>

          <el-form>
              <el-form-item label="Номер телефона">
                  <input-phone :value="model.phone" @update="x => {model.phone = x}" tel-code="+7" placeholder="+7(000)000-00-00"/>
              </el-form-item>
          </el-form>
      </el-card>
  </div>
</template>

<script>
import PageHeader from "../../widget/page/pageHeader.vue";
import {create} from "../../shared/models/phone";
import {alert, message} from "../../widget/dialog/dialog";
import {PhoneUpdateRoute} from "../index.js";
import InputPhone from "../../widget/input/inputPhone.vue";

export default {
    name: "PhoneAdd",
    components: {InputPhone, PageHeader},
    data() {
        return {
            model: {
                phone: ''
            }
        }
    },
    methods: {
        async createNew() {
            const data = await create(this.model)
            if (data.data.uuid) {
                alert('Успешно', 'Номер телефона был создан перейти к редактированию?').then(() => {
                    this.$router.replace({name: PhoneUpdateRoute.name, params: {id: data.data.uuid}})
                }).catch(() => {
                    this.$router.back()
                })
            } else {
                message('Произошла не предвидемая ошибка', 'error')
            }
        }
    }
}
</script>

<style scoped>

</style>
