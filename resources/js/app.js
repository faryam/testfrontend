
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('header-dropdown', require('./components/HeaderDropdownsComponent.vue'));
Vue.component('image-gallary', require('./components/ImagesComponent.vue'));

const app = new Vue({
    el: '#app',
    data: {
    	images: [],
        selected_test:default_test,
    	selected_bro:default_bro
    },
    mounted() {
        this.getImages();
    },
    methods:{
    	newBrowser(value){
            this.selected_bro=value;
            this.getImages();
    	},
    	newTest(value){
    		this.selected_test=value;
            this.getImages();
    	},
        getImages(){
            var path=this.selected_bro+'/'+this.selected_test;
            axios
            .get(base_url+'/api/images?path='+path)
            .then(response => {
                resultArray = Object.keys(response.data.Images).map(function(key) {
                    return response.data.Images[key];
                });
                this.images= resultArray;
            })
        }

    }
});
