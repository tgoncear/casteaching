import VideosList from "./components/VideosList";

require('./bootstrap');
import Vue from 'vue';
import Alpine from 'alpinejs';
import tgoncearcasteaching_package from "tgoncearcasteaching";
window.Alpine = Alpine;
window.tgoncearcasteaching = tgoncearcasteaching_package;
window.Vue = Vue;

window.Vue.component('videos-list', VideosList)
Alpine.start();

const app = new window.Vue({
   el: '#app'
});
