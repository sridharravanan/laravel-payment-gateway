/**
 * Created by sridhar on 19/8/20.
 */
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import FieldDefs from './field-defs';
import VueTableDefaultClass from '../__global/vue-table-default-class';
Vue.component('manage-post', {
    components : {
        'vue-table':Vuetable,
        'vuetable-pagination':VuetablePagination,
        VuetablePaginationInfo,
    },
    data() {
        return {
            fields         : FieldDefs,
            displayForm     : false,
            vueTableParams : {
                filter      :   ""
            },
            css: VueTableDefaultClass,
            currentRecord : null
        };
    },

    created(){

    },
    beforeDestroy(){

    },
    mounted(){

    },
    computed:{
        vueTableFetch: function() {
            return axios.get;
        }
    },
    filters : {


    },

    methods : {
        onPaginationData (paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
            this.$refs.paginationInfo.setPaginationData(paginationData)
        },
        onChangePage (page) {
            this.$refs.vuetable.changePage(page)
        },
        reloadRefresh(){
            this.$refs.vuetable.refresh();
        },
        clearDataTable(){
            this.vueTableParams.filter='';
            this.reloadRefresh();
        },
        showForm(){
            this.displayForm = true;
        },
        showGrid(){
            this.currentRecord = null;
            this.displayForm = false;
        },
        onAction(action, data, index){
            switch (action) {
                case 'edit-item':
                    axios.get('/post/' + data.id)
                        .then(response => {
                            console.log(response);
                            this.currentRecord = response.data;
                            this.showForm();
                        }).catch(bankLedger => {
                            console.log(bankLedger);
                            this.$snotify.error(bankLedger);
                        })
                break;
            }
        }
    }
});
