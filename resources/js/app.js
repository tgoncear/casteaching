import VideosList from "./components/VideosList";

require('./bootstrap');
import Vue from 'vue';
import Alpine from 'alpinejs';
import tgoncearcasteaching_package from "tgoncearcasteaching";
import VideoForm from "./components/VideoForm";
import VideoStatus from "./components/VideoStatus";
window.Alpine = Alpine;
window.tgoncearcasteaching = tgoncearcasteaching_package;
window.Vue = Vue;

window.Vue.component('videos-list', VideosList);
window.Vue.component('video-form', VideoForm);
window.Vue.component('video-status', VideoStatus);
Alpine.start();

const app = new window.Vue({
   el: '#app'
});
