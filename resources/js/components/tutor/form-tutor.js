/**
 * Created by sridhar on 17/8/20.
 */
import {Form} from 'laravel-form-validation';
Vue.component('form-tutor', {
    components:{},
    data(){
        return {
            form : this.getFormData(),
            isLoading : false,
            formErrors : new Form(),
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
            this.formErrors.post('/tutor-save', this.form)
                .then(response => {
                    this.$snotify.success(response.name, 'saved!');
                    this.showGrid();
                })
                .catch(reason => {
                    this.$snotify.error(reason.message);
                }).finally(response=>{
                    this.isLoading = false;
                });
        },
    }
});
