<template>
    <div class="mt-3">
        <div v-show="!isDaihyo">
            <p>続けて参加者情報を入力される場合は以下にチェックを入れてください。</p>
            <label><input type="checkbox" name="chk_multiple" v-on:click="dispChange" v-model="reception_member.is_disp">続けて入力する</label>
        </div>

        <b-card no-body v-show="reception_member.is_disp">
            <b-card-header v-text="cardTitle">></b-card-header>
            <b-card-body>
                <b-row>
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="first_nm">氏名(全角)</label>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="first_nm" v-model="reception_member.first_nm" class="mb-2" placeholder="姓" :state="input_state(errors.first_nm)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.first_nm"></div>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="last_nm" v-model="reception_member.last_nm" class="mb-2" placeholder="名":state="input_state(errors.last_nm)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.last_nm"></div>
                    </b-col>
                </b-row>
                
                <b-row class="my-2">
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="first_nm_kana">フリガナ(全角)</label>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="first_nm_kana" v-model="reception_member.first_nm_kana" class="mb-2" placeholder="姓" :state="input_state(errors.first_nm_kana)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.first_nm_kana"></div>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="last_nm_kana" v-model="reception_member.last_nm_kana" class="mb-2" placeholder="名" :state="input_state(errors.last_nm_kana)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.last_nm_kana"></div>
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col lg="2" sm="12">
                        <label class="col-form-label">生年月日</label>
                    </b-col>
                    <b-col lg="2" sm="4">
                        <b-form-select id="birthday" name="birthday" v-model="reception_member.birthday_year" :options="getYears()" class="mb-2" placeholder="年" :state="input_state(errors.birthday_year)"></b-form-select>
                        <div class="invalid-feedback" v-text="errors.birthday_year"></div>
                    </b-col>
                    <b-col lg="1" sm="12">
                        <label class="col-form-label">年</label>
                    </b-col>
                    <b-col lg="2" sm="4">
                        <b-form-select id="birthday_month" name="birthday_month" v-model="reception_member.birthday_month" :options="months" class="mb-2" placeholder="月" :state="input_state(errors.birthday_month)"></b-form-select>
                        <div class="invalid-feedback" v-text="errors.birthday_month"></div>
                    </b-col>
                    <b-col lg="1" sm="12">
                        <label class="col-form-label">月</label>
                    </b-col>
                    <b-col lg="2" sm="4">
                        <b-form-select id="birthday_day" name="birthday_day" v-model="reception_member.birthday_day" :options="getDates(reception_member.birthday_year, reception_member.birthday_month)" class="mb-2" placeholder="日" :state="input_state(errors.birthday_day)"></b-form-select>
                        <div class="invalid-feedback" v-text="errors.birthday_day"></div>
                    </b-col>
                    <b-col lg="1" sm="12">
                        <label class="col-form-label">日生まれ</label>
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col lg="2" sm="12">
                        <label class="col-form-label">性別</label>
                    </b-col>
                    <b-col lg="2" sm="12">
                        <b-form-select id="sex" name="sex" v-model="reception_member.sex" :options="constValues.sex" class="mb-2" placeholder="年" :state="input_state(errors.sex)"></b-form-select>
                        <div class="invalid-feedback" v-text="errors.sex"></div>
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="first_nm">郵便番号</label>
                    </b-col>
                    <b-col lg="2" sm="12">
                        <b-form-input name="post_cd" v-model="reception_member.post_cd" class="mb-2" :state="input_state(errors.post_cd)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.post_cd"></div>
                    </b-col>
                    <b-col lg="3" sm="12">
                        <b-button name="serach_address" variant="primary" v-on:click="setAddress()">住所自動検索</b-button>
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="prefectures_cd">都道府県</label>
                    </b-col>
                    <b-col lg="2" sm="12">
                        <b-form-select id="prefectures_cd" name="prefectures_cd" v-model="reception_member.prefectures_cd" :options="constValues.prefectures" class="mb-2" :state="input_state(errors.prefectures_cd)"></b-form-select>
                        <div class="invalid-feedback" v-text="errors.prefectures_cd"></div>
                    </b-col>

                    <b-col lg="1" sm=12>
                        <label class="col-form-label" label-for="address1">住所</label>
                    </b-col>
                    <b-col lg="7" sm="12">
                        <b-form-input name="address1" v-model="reception_member.address1" class="mb-2" :state="input_state(errors.address1)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.address1"></div>
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="address2">建物名</label>
                    </b-col>
                    <b-col lg="10" sm="12">
                        <b-form-input name="address2" v-model="reception_member.address2" class="mb-2" :state="input_state(errors.address2)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.address2"></div>
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="tel_keitai">電話番号</label>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="tel_keitai" v-model="reception_member.tel_keitai" class="mb-2" placeholder="携帯電話" :state="input_state(errors.tel_keitai)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.tel_keitai"></div>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="tel_zitaku" v-model="reception_member.tel_zitaku" class="mb-2" placeholder="自宅電話" :state="input_state(errors.tel_zitaku)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.tel_zitaku"></div>
                    </b-col>
                </b-row>

                <b-row v-show="isDaihyo" class="my-2">
                    <b-col sm="2">
                        <label for="textarea-default">要望</label>
                    </b-col>
                    <b-col sm="10">
                        <b-form-textarea
                            name="hope"
                            size="sm"
                            v-model="reception_member.hope"
                            placeholder="ご要望などがございましたらお書きください。"
                            rows="5"
                            max-rows="5"
                            class="mb-2"
                            :state="input_state(errors.hope)"
                        ></b-form-textarea>
                        <div class="invalid-feedback" v-text="errors.hope"></div>
                    </b-col>
                </b-row>

                <b-row v-show="isDaihyo" class="my-2">
                    <b-col lg="2" sm=12>
                        <label class="col-form-label" label-for="email">メールアドレス</label>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="email" v-model="reception_member.email" class="mb-2" placeholder="" :state="input_state(errors.email)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.email"></div>
                    </b-col>
                    <b-col lg="5" sm="12">
                        <b-form-input name="email_confirm" v-model="reception_member.email_confirm" class="mb-2" placeholder="確認用" :state="input_state(errors.email_confirm)"></b-form-input>
                        <div class="invalid-feedback" v-text="errors.email_confirm"></div>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import birthday from '@content/mixins/birthday';
    export default {
        mixins: [birthday],
        model: {
            prop: 'reception_member',
            event: 'input'
        },
        props: {
            reception_member: {
                type: Object,
                default: null,
            },
            errors: Object
        },
        data() {
            return {
                dispMain: false,
            }
        },
        mounted() {
            if(this.reception_member.is_daihyo){
                this.dispMain = true;
            }
        },
        methods: {
            // 住所セット
            setAddress: function () {
                let _this = this;
                new window.YubinBango.Core(_this.reception_member.post_cd, function(addr) {
                    _this.reception_member.prefectures_cd  = ('00' + addr.region_id).slice(-2)
                    _this.reception_member.address1 = addr.locality + addr.street
                })
            },
            // 表示切替
            dispChange: function (){
                this.dispMain = !this.dispMain;
            },
            // 表示切替
            
        },
        computed: {
            cardTitle(){
                return this.isDaihyo ? '代表者' : '申込者';
            },
            isDaihyo: function (){
                return this.reception_member.is_daihyo;
            }
        }
    }
</script>
