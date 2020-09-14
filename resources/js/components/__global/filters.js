/**
 * Created by sridhar on 21/8/20.
 */
import Vue from "vue";
Vue.filter("bindImage", (value) => {
    return value.replace("public", "storage");
});
