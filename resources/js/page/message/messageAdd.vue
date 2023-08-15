<template>
  <div>
      <el-card>
          <template #header>
              <page-header
                  title="Создание сообщения"
                  add-text="Сохранить"
                  :show-update="false"
                  @add="createNew"
              />
          </template>

          <el-form>
              <el-form-item label="Сообщение">
                  <el-input class="el-col-24" v-model="model.body" type="textarea"/>
              </el-form-item>
          </el-form>
      </el-card>
  </div>
</template>

<script>
import PageHeader from "../../widget/page/pageHeader.vue";
import {create} from "../../shared/models/message";
import {alert, message} from "../../widget/dialog/dialog";
import {MessageUpdateRoute} from "../index.js";

export default {
    name: "MessageAdd",
    components: {PageHeader},
    data() {
        return {
            model: {
                body: ''
            }
        }
    },
    methods: {
        async createNew() {
            const data = await create(this.model)
            if (data.data.uuid) {
                alert('Успешно', 'Сообщение было создано перейти к редактированию?').then(() => {
                    this.$router.replace({name: MessageUpdateRoute.name, params: {id: data.data.uuid}})
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
