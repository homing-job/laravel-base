import moment from 'moment';
export default {
    data() {
        return {
            months: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            year: moment().year(),
            month: moment().month() + 1,
            date: moment().date()
        }
    },
    methods: {
        getYears: function () {
            const goBackYears = 120;
            const currentYear = moment().year();
            const startYear = currentYear - goBackYears;
            return [...Array(goBackYears + 1).keys()].map(x => x + startYear);
        },
        getDates: function (year, month) {
            const maxDate = this.getFinalDate(year, month);
            return [...Array(maxDate).keys()].map(x => x + 1);
        },
        modify: function () {
            // 年や月が変更されたとき、日が存在しなくなる場合があるので調整する。
            // 例: 2018-12-31 を選択していて月が 12 から 2 に変更された場合、日を 28 にする。
            if (!moment([this.year, this.month - 1, this.date]).isValid()) {
                this.date = this.getFinalDate(this.year, this.month);
            }
        },
        getFinalDate: function (year, month) {
            if(year == "" || month == "") return 0;
            // 月末日
            return moment([year, month - 1]).endOf('month').date();
        }
    }
}
