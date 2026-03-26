import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');
if (csrfTokenMeta?.content) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfTokenMeta.content;
}

const baseUrlMeta = document.head.querySelector('meta[name="app-base-url"]');
if (baseUrlMeta?.content) {
    window.axios.defaults.baseURL = baseUrlMeta.content.replace(/\/$/, '');
}
