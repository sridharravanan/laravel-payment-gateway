/**
 * Created by sridhar on 19/8/20.
 */
import { VueEditor } from "vue2-editor";
import VueSelect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import {Form} from 'laravel-form-validation';

import vueFilePond from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);
let filePondOptions = {
    url: '/upload',
    process: {
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    revert: {
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    load: {
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    restore: {
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    fetch:null
};
Vue.component('form-post', {
    components:{
        VueEditor,
        'v-select':VueSelect,
        FilePond,
    },
    data(){
        return {
            filePondOptions:filePondOptions,
            form: this.getFormData(),
            isLoading: false,
            tutor_options: [],
            category_options: [],
            category: null,
            sub_category_options: [],
            sub_category: null,
            formErrors : new Form(),
        }
    },
    created(){


    },
    mounted() {
        this.getReferenceData();

    },
    methods : {
        getReferenceData(){
            this.isLoading = true;
            axios.post('/post/get-reference', {})
                .then(response => {

                    let referenceData       =   response.data;
                    this.tutor_options      =   referenceData.tutors;
                    this.category_options      =   referenceData.category;
                }).catch(reason => {
                    this.$snotify.error(reason.message);
                }).finally(response=>{
                    this.isLoading = false;
                });
        },
        bindSubCategory(){
            this.sub_category = null;
            this.sub_category_options = this.category.sub_category;
        },
        getFormData(){
            return {
                id                      :   null,
                name                    :   '',
                description             :   '',
                sub_category_id         :   null,
                front_image_id          :   null,
                front_image             :   null,
                post_tutors             :   []
            };
        },
        onFileUploadComplete(error, fileObject){
            let file_details = JSON.parse(fileObject.serverId);
            this.form.front_image_id = file_details['id'];
            this.form.front_image = file_details;
        },
        showGrid(){
            this.$parent.showGrid();
        },
        submit() {
            this.isLoading = true;
            this.assignForm();
            this.formErrors.post('/post', this.form)
                .then(response => {
                    this.$snotify.success(response.name, 'saved!');
                    this.showGrid();
                })
                .catch(error => {
                    this.$snotify.error(error.message);
                }).finally(response=>{
                    this.isLoading = false;
                });
        },
        assignForm(){
            this.form.sub_category_id = null;
            if( this.sub_category != null ){
              this.form.sub_category_id = this.sub_category.id;
            }
            this.form.front_image_id = null;
            if( this.form.front_image != null ){
                this.form.front_image_id = this.form.front_image.id;
            }
            let post_tutors = this.form.post_tutors;
            if( post_tutors.length > 0 ){
                for( var index in post_tutors ){
                    post_tutors[index].tutor_id = null;
                    if( post_tutors[index].tutor != null){
                        post_tutors[index].tutor_id = post_tutors[index].tutor.id;
                    }
                }
            }
        },
        addTutor(){
            this.form.post_tutors.push({
                post_id :   null,
                tutor_id:   null,
                tutor   :   null,
                amount  :   0,
                id      :   null
            });
        },
        checkDuplicateTutor(index){
            let post_tutors = this.form.post_tutors;
            let select_tutor = post_tutors[index].tutor;
            if( select_tutor != null ){
                if( post_tutors.length > 0 ){
                    for( var post_tutor_index in post_tutors ){
                        let loopTutor = post_tutors[post_tutor_index].tutor;
                        if( post_tutor_index != index ){
                            if( loopTutor != null && loopTutor.id == select_tutor.id){
                                this.form.post_tutors[index].tutor = null;
                                swal("Tutor already present!");
                            }
                        }
                    }
                }
            }
        },
        onDeleteTutorBlock(index){
            swal({
                title: "Are you sure?",
                text: "Do you want to delete this tutor...!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                if (willDelete) {
                    let removeFromArray = ()=>{
                        this.form.post_tutors.splice(index, 1);
                        swal("Tutor removed from this tutor!", 'Deleted');
                    };
                    let id = this.form.post_tutors[index].id;
                    if(id != null || id != undefined){
                        this.isLoading = true;
                        //existing record, so we have to delete it from server!
                        axios.delete('/standard/standard-section/'+id)
                            .then((reason)=>{
                            removeFromArray();
                        }).catch((reason)=>{
                            this.$snotify.error(reason.message, 'Error!');
                        }).finally(()=>{
                            this.isLoading = false;
                        })
                    }else{
                        removeFromArray();
                    }
                }
            });
        }
    }
});
