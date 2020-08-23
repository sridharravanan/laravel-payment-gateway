/**
 * Created by sridhar on 21/8/20.
 */
/**
 * Created by sridhar on 18/8/20.
 */
import Paginate from 'vuejs-paginate'
Vue.component('manage-dashboard', {
    components : {
        paginate:Paginate
    },
    data() {
        return {
            previousButton : '<li class="paginate_button page-item previous"><a href="#"   class="page-link">Previous</a></li>',
            nextButton : '<li class="paginate_button page-item next"><a href="#"   class="page-link">Next</a></li>',
            currentPage: 1,
            totalPage:1,
            postLists : [],
            per_page:8,
            header_value:{
                total_students  : 0,
                total_tutors    : 0,
                total_posts     : 0,
            }

        };
    },

    created(){

    },
    beforeDestroy(){

    },
    mounted(){
        this.additionalData();
        this.getAllPost(1);
    },
    computed:{

    },
    methods : {
        additionalData(){
            let self = this;
            axios.post('/dashboard/additional-data', {})
                .then(function (response) {
                    let responceData = response.data;
                    self.header_value.total_students = responceData.student;
                    self.header_value.total_tutors = responceData.tutor;
                    self.header_value.total_posts = responceData.post;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        getAllPost() {
            let self = this;
            axios.get('/dashboard/grid', {
                    params: {
                        page: self.currentPage,
                        per_page:self.per_page,
                        filter:""
                    }
                })
                .then(function (response) {
                    let responceData = response.data;
                    self.totalPage =  Math.ceil(( responceData.total )/self.per_page);
                    self.postLists = responceData.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },




    }
});
