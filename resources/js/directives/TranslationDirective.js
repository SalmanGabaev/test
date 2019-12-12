import Vue from 'vue';
import { Lang } from '../config/config';

// This is our normal Vue filter. '...args' allows us to use any
// number of parameters in our strings
Vue.filter('trans', (...args) => {
    return Lang.get(...args);
});
