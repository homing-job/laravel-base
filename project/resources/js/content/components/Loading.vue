<template>
  <div class="modal-mask" v-if="isLoading === true">
    <div class="loading">
      <vue-loading type="spin" color="#333" :size="{ width: '50px', height: '50px'}"></vue-loading>
    </div>
  </div>
</template>

<script>
import { VueLoading } from 'vue-loading-template';

export default {
  props: {
    isLoading: Boolean,
  },
  components: {
    VueLoading
  },
}
</script>

<style scoped>
.modal-mask {
  z-index:1;
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background-color:rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>