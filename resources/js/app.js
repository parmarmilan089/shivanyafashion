import { createApp } from 'vue';
import InventoryCreate from './components/InventoryCreate.vue';
// import UserProfile from './components/UserProfile.vue';

console.log('Vue app loading...');
// Helper to mount any component to a given DOM element
function mountComponent(selector, component, props = {}) {
    const el = document.querySelector(selector);
    if (el) {
        createApp(component, props).mount(el);
    }
}

mountComponent('#inventory-create', InventoryCreate, window.inventoryProps);
