import Vue from "vue";
import VueRouter from "vue-router";
 
Vue.use(VueRouter);

// 申込状況
import reception_status_index from "./components/reception_status/index.vue";

// 競技予定登録
import kyogi_plan_index from "./components/kyogi_plans/index.vue";
import kyogi_plan_create from "./components/kyogi_plans/create.vue";

// 汎用マスタ
import general_index from "./components/master/general/index.vue";
import general_edit from "./components/master/general/edit.vue";
import general_create from "./components/master/general/create.vue";

// 競技マスタ
import kyogi_index from "./components/master/kyogi/index.vue";
import kyogi_edit from "./components/master/kyogi/edit.vue";
import kyogi_create from "./components/master/kyogi/create.vue";

// not found
import page_not_found from "./components/utility/page_not_found.vue";

const router = new VueRouter({
    mode: "hash",
    routes: [
        // 申込状況
        {
            path: "/reception_status_index",
            name: "reception_status_index",
            component: reception_status_index,
            props: true
        },
        // 競技予定
        {
            path: "/kyogi_plan_index",
            name: "kyogi_plan_index",
            component: kyogi_plan_index,
            props: true
        },
        {
            path: "/kyogi_plan_create",
            name: "kyogi_plan_create",
            component: kyogi_plan_create,
            props: true,
            beforeEnter: function (to, from, next) {
                if (from.path !== "/kyogi_plan_index") {
                    next('/kyogi_plan_index')
                } else {
                    next()
                }
            }
        },
        // 汎用マスタ
        {
            path: "/general_index",
            name: "general_index",
            component: general_index,
            props: true
        },
        {
            path: "/general_edit",
            name: "general_edit",
            component: general_edit,
            props: true,
            beforeEnter: function (to, from, next) {
                if (from.path !== "/general_index") {
                    next('/general_index')
                } else {
                    next()
                }
            }
        },
        {
            path: "/general_create",
            name: "general_create",
            component: general_create,
            props: true,
            beforeEnter: function (to, from, next) {
                if (from.path !== "/general_index") {
                    next('/general_index')
                } else {
                    next()
                }
            }
        },
        // 競技マスタ
        {
            path: "/kyogi_index",
            name: "kyogi_index",
            component: kyogi_index,
            props: true
        },
        {
            path: "/kyogi_edit",
            name: "kyogi_edit",
            component: kyogi_edit,
            props: true,
            beforeEnter: function (to, from, next) {
                if (from.path !== "/kyogi_index") {
                    next('/kyogi_index')
                } else {
                    next()
                }
            }
        },
        {
            path: "/kyogi_create",
            name: "kyogi_create",
            component: kyogi_create,
            props: true,
            beforeEnter: function (to, from, next) {
                if (from.path !== "/kyogi_index") {
                    next('/kyogi_index')
                } else {
                    next()
                }
            }
        },
        // not found
        {
            path: '*',
            name: 'page_not_found',
            component: page_not_found
          } 
    ]
});

// export default 【モジュール名】
export default router;