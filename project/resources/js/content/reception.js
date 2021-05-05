window.YubinBango = require('yubinbango-core');

window.Vue = require('vue');

Vue.component('reception-component', require('./components/ReceptionComponent.vue').default);

// bootstrapvueの初期値設定
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
Vue.use(BootstrapVue, {
    BFormInput: {
        placeholder: '',
        autocomplete: "off",
    },
    BFormGroup: {
        labelAlignSm: 'left',
        labelColsSm: "2",
    },
})
Vue.use(IconsPlugin);

// vueにグローバル定数セット
import gv from '../mixins/utils';
import gv2 from '../mixins/form_validation';
import gv3 from './mixins/const';
Vue.mixin(gv);
Vue.mixin(gv2);
Vue.mixin(gv3);

// 定数読込み
const promiseA = function() {
    return axios.get('/utility/general_code_value')
        .then(function(response){
            window.constValues = response.data;
        });
};

// 定数読込み
const processB = function() {
    return axios.get('/utility/general_code')
        .then(function(response){
            window.constCds = response.data;
        });
};

// 定数読み込み後にVueを読み込む
Promise.all([promiseA(), processB()])
    .then(function () {
        const app = new Vue({
            el: '#app',
        });
    });
