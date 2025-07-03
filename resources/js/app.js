import { createApp } from 'vue';
import InventoryCreate from './components/InventoryCreate.vue';

const app = createApp({});
app.component('inventory-create', InventoryCreate);
app.mount('#app');