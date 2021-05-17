<template>
    <div>
        <loading :isLoading="!loadComplete"></loading>

        <div v-if="loadComplete">
            <div class="card" style="width:90%" hidden>
                <div class="card-header">エラー</div>
                <div class="card-body">
                    <p v-for="error in errors_reception">
                        {{ error }}
                    </p>
                    <div v-for="errors_reception_member in errors_reception_members">

                        <p v-for="error in errors_reception_member">
                            {{ error }}
                        </p>
                    </div>
                </div>
            </div>

            <b-container fluid class="py-4">
                <p>希望競技と参加者の詳細を入力の上、確認画面に進んでください。</p>
                <!-- 希望競技 -->
                <b-card header="希望競技" header-tag="header">
                    <b-row>
                        <b-col lg="12">
                            <b-form-group label="競技名" label-for="kyogiNm" :invalid-feedback="errors_reception.kyogi_id" :state="input_state(errors_reception.kyogi_id)">
                                <b-input-group>
                                    <b-form-select name="kyogi_nm" v-model="reception.kyogi_id" :options="options.kyogiNm" v-on:change="resetKyogiHopeDate()" :state="input_state(errors_reception.kyogi_id)"></b-form-select>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col lg="12">
                            <b-form-group label="会場地市町名" label-for="kbn">
                                <b-form-input v-bind:value="selctedAddress" disabled></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col lg="12">
                            <b-form-group label="競技会場名" label-for="kbn">
                                <b-form-input v-bind:value="selctedKaizyoNm" disabled></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col lg="12">
                            <b-form-group label="希望日" v-slot="{ ariaDescribedby }" :invalid-feedback="errors_reception.kyogi_hope_date" :state="input_state(errors_reception.kyogi_hope_date)">
                                <b-form-radio-group name="kyogi_hope_date" v-model="reception.kyogi_hope_date" :options="selctedKyogiDates" :aria-describedby="ariaDescribedby" :state="input_state(errors_reception.kyogi_hope_date)"></b-form-radio-group>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card>

                <!-- 代表者 -->
                <div id="member1">
                    <reception-member v-model="reception_members[0]" :errors="errors_reception_members[0]"></reception-member>
                </div>

                <!-- 申込者2~4 -->
                <div id="member2">
                    <reception-member v-model="reception_members[1]" :errors="errors_reception_members[1]"></reception-member>
                </div>
                <div id="member3">
                    <reception-member v-model="reception_members[2]" :errors="errors_reception_members[2]"></reception-member>
                </div>
                <div id="member4">
                    <reception-member v-model="reception_members[3]" :errors="errors_reception_members[3]"></reception-member>
                </div>


                <b-row>
                    <b-col lg="2">
                        <b-button variant="danger" v-on:click="initReception(true)">入力内容の取消し</b-button>
                    </b-col>
                    <b-col lg="2">
                        <b-button variant="success" v-on:click="submit()">確認画面へ進む</b-button>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>
    import Loading from '@content/components/Loading';
    import ReceptionMember from '@content/components/ReceptionMemberComponent';

    export default {
        name: 'hoge',
        components:{
            ReceptionMember,
            Loading,
        },
        data() {
            return {
                reception: [],
                reception_members: [],
                kyogis: [],
                options:{kyogiNm:[],
                },
                errors_reception: {},
                errors_reception_members: [{}, {}, {}, {}],
            }
        },
        mounted() {
            this.initReception();
            // 競技一覧
            axios.get('/reception/kyogis').then(response => {
                this.kyogis = response.data;
            });

            // 以下オプション
            // 競技名
            axios.get('/reception/kyogis_nm').then(response => {
                this.options.kyogiNm = response.data;
            });
        },
        methods: {
            // 申込初期化
            initReception: function (is_reset=false) {
                // 申込 空データ
                axios.post('/reception/init_data', {'isReset':is_reset}).then(response => {
                    this.reception = response.data.reception;
                    this.reception_members = response.data.reception_members;
                });
            },
            // エラー初期化
            initError: function () {
                this.errors_reception = {};
                this.errors_reception_members = [{}, {}, {}, {}];
            },
            // 観覧希望日ﾘｾｯﾄ
            resetKyogiHopeDate: function(){
                this.reception.kyogi_hope_date="";
            },
            // submit
            submit: function(){
                // チェックされていない申込者を消す。
                const dispMembers = this.reception_members.filter(reception_member => {
                    return reception_member.is_disp
                });

                const dispMembersSortNo = dispMembers.map(reception_member => {
                    return reception_member.sort_no;
                });

                axios.post('/reception/validation', {reception:this.reception, reception_members:dispMembers}).then(response => {
                    location.href = response.data;
                }).catch(error => {
                    const errors = error.response.data.errors;
                    // エラー初期化
                    this.initError();

                    // receptionエラー取得
                    Object.keys(errors).filter(error => {
                        return error.match(/reception\./);
                    }).map(value => {
                        const key = value.replace("reception.", "");
                        this.errors_reception[key] = errors[value][0];
                    })

                    // reception_membersエラー取得
                    const _this = this;
                    dispMembersSortNo.forEach((sort_no, index, array) => {
                        Object.keys(errors).filter(function (error) {
                            return !error.indexOf('reception_members.' + index + '.');
                        }).map(function (value) {
                            const key = value.replace("reception_members." + index + ".", "");
                            _this.errors_reception_members[sort_no - 1][key] = errors[value][0];
                        });
                    });
                });
            },
        },
        computed: {
            // 選択競技
            selctedKyogi(){
                if(this.kyogis.length === 0 || this.reception.kyogi_id == "") return null;
                return this.kyogis.find(f => f.id == this.reception.kyogi_id);
            },
            // 選択競技 会場地
            selctedAddress(){
                return this.selctedKyogi ? this.selctedKyogi.address : '';
            },
            // 選択競技 会場名
            selctedKaizyoNm(){
                return this.selctedKyogi ? this.selctedKyogi.kaizyo_nm : '';
            },
            // 選択競技予定
            selctedKyogiPlans(){
                return this.selctedKyogi ? this.selctedKyogi.kyogi_plans : '';
            },
            // 選択競技日
            selctedKyogiDates(){
                return this.selctedKyogi ? this.selctedKyogiPlans.map(function(kyogiPlan){return kyogiPlan.kyogi_date;}) : '';
            },
            // メイン表示条件
            loadComplete(){
                return !this.isEmptyObject(this.reception) && !this.isEmptyObject(this.reception_members);
            },
        }
    }
</script>
