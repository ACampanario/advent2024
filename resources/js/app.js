// resources/js/app.js

import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import store from './store';

createApp(ExampleComponent).use(store).mount('#app');
