require('./bootstrap')
import Vue from 'vue'
import vuetify from '../plugins/vuetify' // path to vuetify export
import axios from "../plugins/Axios" //? Do I need it?
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
/**
 * Enable Axios Settings.
 */
axios.enableSettings();
window.Vue = require('vue')

Vue.component('my-app', require('./myApp.vue').default);
Vue.component('table-contents', require('./components/TableContents.vue').default);

new Vue({
    vuetify,
}).$mount('#app')