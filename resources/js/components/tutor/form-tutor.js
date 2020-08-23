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
            adminMode : false,
            formTitle : "Edit"
        }
    },
    created(){


    },
    mounted() {
        this.adminMode = false;
        //#admin approval
        if( this.$parent.currentRecord  != undefined && this.$parent.currentRecord != null ){
            this.adminMode = true;
            let currentRecord =  this.$parent.currentRecord;
            this.form.id = currentRecord.id;
            this.form.name = currentRecord.name;
            this.form.email = currentRecord.email;
            this.form.phone_number = currentRecord.phone_number;
            this.form.razorpay_id = currentRecord.razorpay_id;
        }

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
                razorpay_id   :   null,
            };
        },
        showGrid(){
            this.form = this.getFormData();
            if( this.adminMode ){
                this.$parent.showGrid();
            }
        },
        submit() {
            this.isLoading = true;
            let method = (this.form.id == null )? axios.post('/tutor-save', this.form) : axios.put('/tutor/'+this.form.id, this.form);
            method
                .then(response => {
                    this.errors = [];
                    this.$snotify.success(response.data, 'saved!');
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
