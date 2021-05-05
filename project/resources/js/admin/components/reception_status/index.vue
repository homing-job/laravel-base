<template>
  <b-container fluid class="py-4">
    <h2>申込状況</h2>
    <msg-danger :message="message"></msg-danger>

    <!-- 抽出条件 -->
    <b-card header="抽出条件" header-tag="header">
      <b-row>
        <b-col lg="6" class="my-1">
          <b-form-group label="競技名" label-for="kyogi_nm">
            <b-input-group>
              <b-form-input v-model="conds.kyogi_nm" type="search" id="kyogi_nm"></b-form-input>
            </b-input-group>
          </b-form-group>
        </b-col>
        <b-col lg="6" class="my-1">
          <b-form-group label="希望日" label-for="kyogi_hope_date">
            <b-input-group>
              <b-form-input v-model="conds.kyogi_hope_date" type="search" id="kyogi_hope_date"></b-form-input>
            </b-input-group>
          </b-form-group>
        </b-col>
        <b-col lg="6" class="my-1">
          <b-form-group label="携帯番号" label-for="tel_keitai">
            <b-input-group>
              <b-form-input v-model="conds.tel_keitai" type="search" id="tel_keitai"></b-form-input>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>
      <template #footer>
        <b-button variant="primary" @click="getItem()">検索</b-button>
      </template>
    </b-card>

    <b-card>
        <!-- User Interface controls -->
        <b-row>
          <b-col lg="6" class="my-1">
            <b-form-group label="Filter" label-cols-sm="3" label-align-sm="right" label-for="filterInput">
              <b-input-group>
                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Type to Search"></b-form-input>
                <b-input-group-append>
                  <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col sm="5" md="6" class="my-1">
            <b-form-group label="Per page" label-cols-sm="6" label-cols-md="4" label-cols-lg="3" label-align-sm="right" label-for="perPageSelect">
              <b-form-select v-model="perPage" id="perPageSelect" :options="pageOptions"></b-form-select>
            </b-form-group>
          </b-col>
        </b-row>

        <!-- Main table element -->
        <b-table
          :items="items"
          :busy="isBusy"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
          :filter-included-fields="filterOn"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :sort-direction="sortDirection"
          @filtered="onFiltered"
        >
          <template #table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>Loading...</strong>
            </div>
          </template>

          <template #cell(reception_no)="row">
            {{ row.item.reception_no }}
          </template>

          <template #cell(kyogi_nm)="row">
            {{ row.item.kyogi_nm }}
          </template>

          <template #cell(kyogi_hope_date)="row">
            {{ row.item.kyogi_hope_date }}
          </template>

          <template #cell(daihyo_full_nm)="row">
            {{ row.item.daihyo_full_nm }}
          </template>

          <template #cell(tel_keitai)="row">
            {{ row.item.tel_keitai }}
          </template>

          <template #cell(tel_zitaku)="row">
            {{ row.item.tel_zitaku }}
          </template>

          <template #cell(created_at)="row">
            {{ row.item.created_at | moment }}
          </template>

          <template #cell(actions)="row">
            <b-button variant="primary" @click="showDetail(row.item)">
              詳細
            </b-button>
            <b-button variant="danger" @click="showDelConirm(row.item)">
              削除
            </b-button>
          </template>
        </b-table>

        <!-- User Interface controls -->
        <b-row class="py-1">
          <b-col sm="5" md="6" class="my-1">
            <span v-text="tableInfo()"></span>
          </b-col>

          <b-col sm="7" md="6" class="my-1">
            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"></b-pagination>
          </b-col>
        </b-row>
    </b-card>
  </b-container>
</template>

<script>
  import BtnDl from '@admin/components/utility/button_donwload'
  import MsgDanger from '@admin/components/utility/msg_danger';
  import moment from 'moment';
  export default {
    components: { 
        BtnDl,
        MsgDanger
    },
    filters: {
        moment: function (date) {
            return moment(date).format('YYYY/MM/DD');
        }
    },
    props: {
      isInit: Boolean,
    },
    data() {
      return {
        items: [],
        conds: {kyogi_nm: null, kyogi_hope_date: null, tel_keitai: null},
        fields: [
          { key: 'reception_no', label: '申込番号', sortable: true, sortDirection: 'desc' },
          { key: 'kyogi_nm', label: '競技名', sortable: true, sortDirection: 'desc' },
          { key: 'kyogi_hope_date', label: '希望日', sortable: true, class: 'text-left' },
          { key: 'daihyo_full_nm', label: '代表者名', sortable: true, class: 'text-left' },
          { key: 'tel_keitai', label: '携帯番号', sortable: true, class: 'text-left' },
          { key: 'tel_zitaku', label: '自宅番号', sortable: true, class: 'text-left' },
          { key: 'created_at', label: '登録日', sortable: true, class: 'text-left' },
          { key: 'actions', label: 'Actions' }
        ],
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 25,
        pageOptions: [15, 25, 50, { value: 100, text: "Show a lot" }],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        filterOn: [],
        message: "",
      }
    },
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      }
    },
    mounted() {
       this.isBusy = true;
       axios.post("/reception_status/get_conds", {isInit: this.isInit})
        .then(response => {
          if(!this.isEmptyObject(response.data)){
            this.conds.kyogi_nm = response.data.kyogi_nm;
            this.conds.kyogi_hope_date = response.data.kyogi_hope_date;
            this.conds.tel_keitai = response.data.tel_keitai;
          }
          this.getItem();
        })
    },
    methods: {
      getItem() {
        // 条件をセッションに保存
        axios.post("/reception_status/set_conds", {
          kyogi_nm: this.conds.kyogi_nm,
          kyogi_hope_date: this.conds.kyogi_hope_date,
          tel_keitai: this.conds.tel_keitai,
          isInit: this.isInit
        }).catch();

        // 一覧読込
        axios.post("/reception_status/index", {
          kyogi_nm: this.conds.kyogi_nm,
          kyogi_hope_date: this.conds.kyogi_hope_date,
          tel_keitai: this.conds.tel_keitai,
          isInit: this.isInit
        })
        .then(response => {
          this.items = response.data;
          this.totalRows = this.items.length
          this.isBusy = false;
          this.message = "";
        })
        .catch(erorr => {
          this.isBusy = false;
          this.message = erorr;
        });
      },
      delete(item) {
        axios.delete("/reception_status/" + item.id).then(response => {
          this.getItem();
          this.message = "";
        })
        .catch(error => {
          this.message = error;
        });
      },
      onFiltered(filteredItems) {
        // フィルタリング時のページネーション更新
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
      tableInfo() {
        let page_st = (this.currentPage - 1) * this.perPage + 1;
        let page_ed = (this.currentPage * this.perPage) > this.items.length ? this.items.length : (this.currentPage * this.perPage)
        return format.sprintf('%1$s 件中 %2$s から %3$s まで表示', this.items.length, page_st, page_ed);
      },
      showDelConirm(item) {
        this.$bvModal.msgBoxConfirm(format.sprintf('[競技名]:%1$s [競技日]:%2$s [代表社名]:%3$s を削除します。よろしいですか?', item.kyogi_nm, item.kyogi_hope_date, item.daihyo_full_nm))
          .then(result => {
            if(result) this.delete(item)
          })
          .catch(error => {
            this.message = error;
          })
      },
      showDetail(item) {
        window.open(format.sprintf('/confirmation/%1$s', item.id));
      },
    }
  }
</script>