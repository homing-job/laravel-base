<template>
  <b-container fluid class="py-4">
    <h2>{{ title }}</h2>

    <!-- 登録内容 -->
    <b-card
      header="登録内容"
      header-tag="header">
      <b-row>
        <b-col lg="12" class="my-1">
          <b-form-group
            label="競技名"
            label-for="kyogi_nm"
            :invalid-feedback="errors.kyogi_nm"
            :state="input_state(errors.kyogi_nm)">
              <b-form-input
                v-model="item.kyogi_nm"
                type="search"
                id="kyogi_nm"
                :state="input_state(errors.kyogi_nm)"></b-form-input>
          </b-form-group>
        </b-col>

        <b-col lg="12" class="my-1">
          <b-form-group
            label="住所"
            label-for="address"
            :invalid-feedback="errors.address"
            :state="input_state(errors.address)">
            <b-form-input
              v-model="item.address"
              type="search"
              id="address"
              :state="input_state(errors.address)"></b-form-input>
          </b-form-group>
        </b-col>

        <b-col lg="12" class="my-1">
          <b-form-group
            label="会場名"
            label-for="kaizyo_nm"
            :invalid-feedback="errors.kaizyo_nm"
            :state="input_state(errors.kaizyo_nm)">
            <b-input-group>
              <b-form-input
                v-model="item.kaizyo_nm"
                type="search"
                id="kaizyo_nm"
                :state="input_state(errors.kaizyo_nm)"></b-form-input>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>
      <template #footer>
        <b-button variant="success" @click="$emit('submit', item)">登録</b-button>
        <b-button variant="secondary" @click="$emit('back')">戻る</b-button>
      </template>
    </b-card>
  </b-container>
</template>
 
<script>
  export default {
      props: {
          initialItem: Object,
          errors: Object,
          title: String,
          isCreate: Boolean,
      },
      data() {
        return {
          item: this.initialItem,
        }
      },
  }
</script>