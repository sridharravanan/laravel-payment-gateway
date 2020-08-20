/**
 * Created by sridhar on 17/8/20.
 */
import axios from 'axios';
Vue.component('form-tutor', {
    components:{
        axios
    },
    data(){
        return {
            form : this.getFormData(),
            isLoading : false,
            errors: [],
        }
    },
    created(){


    },
    mounted() {


    },
    methods : {
        getFormData(){
            return {
                id                      :   null,
                name                    :   '',
                email                   :   '',
                phone_number            :   '',
                password                :   '',
                password_confirmation   :   '',
            };
        },
        showGrid(){
            this.form = this.getFormData();
        },
        submit() {
            this.isLoading = true;
            axios.post('/tutor-save', {})
                .then(response => {
                    this.errors = [];
                    this.$snotify.success(response.name, 'saved!');
                    this.showGrid();
                })
                .catch(error => {
                    this.$snotify.error(error.message);
                    this.errors = error.response.data.errors;
                }).finally(response=>{
                    this.isLoading = false;
                });
        },
    }
});
