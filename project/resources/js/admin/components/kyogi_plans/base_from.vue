<template>
  <b-container fluid class="py-4">
    <h2>{{ title }}</h2>

    <!-- 登録内容 -->
    <b-card header="登録内容" header-tag="header">
      <b-row>
        <b-col lg="12" class="my-1">
          <b-form-group
            label="競技名"
            label-for="kyogi_nm"
            :invalid-feedback="errors.kyogi_id"
            :state="input_state(errors.kyogi_id)">
              <b-input-group>
                <b-form-input
                  disabled
                  v-model="kyogi.kyogi_nm"
                  id="kyogi_nm"
                  :state="input_state(errors.kyogi_id)"></b-form-input>
                  <btn-modal-kyogi v-on:submit="setKyogi"></btn-modal-kyogi> 
              </b-input-group>
          </b-form-group>
        </b-col>

        <b-col lg="12" class="my-1">
          <b-form-group
            label="住所"
            label-for="address">
            <b-form-input
              disabled
              v-model="kyogi.address"
              id="address"></b-form-input>
          </b-form-group>
        </b-col>

        <b-col lg="12" class="my-1">
          <b-form-group
            label="会場名"
            label-for="kaizyo_nm">
            <b-input-group>
              <b-form-input
                disabled
                v-model="kyogi.kaizyo_nm"
                id="kaizyo_nm"></b-form-input>
            </b-input-group>
          </b-form-group>
        </b-col>

        <b-col lg="12" class="my-1">
          <b-form-group
            label="競技日"
            label-for="kyogi_date"
            :invalid-feedback="errors.kyogi_date"
            :state="input_state(errors.kyogi_date)">
            <b-input-group>
              <b-form-datepicker 
                v-model="item.kyogi_date"
                id="kyogi_date"
                :state="input_state(errors.kyogi_date)"></b-form-datepicker>
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
  import BtnModalKyogi from './modal_kyogi'
  export default {
      components: { 
          BtnModalKyogi,
      },
      props: {
          initialItem: Object,
          errors: Object,
          title: String,
          isCreate: Boolean,
      },
      data() {
        return {
          item: this.initialItem,
          kyogi:Object,
        }
      },
      mounted() {
        axios.post("/utility/empty_table_columns", {table_nm: 'kyogi', num: 1}).then(response => {
          this.kyogi = response.data;
        });
      },
      methods: {
        setKyogi(item){
          this.kyogi = item;
          this.item.kyogi_id = item.id;
        },
      }
  }
</script>