import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

// CSRFトークンの設定
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

createApp(App).use(router).mount('#app');
