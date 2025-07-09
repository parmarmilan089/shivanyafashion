import { createApp } from 'vue';
import InventoryCreate from './components/InventoryCreate.vue';
// import UserProfile from './components/UserProfile.vue';

<<<<<<< HEAD
const app = createApp({});
app.component('inventory-create', InventoryCreate);
app.mount('#app');
=======
console.log('Vue app loading...');

// Helper to mount any component to a given DOM element
function mountComponent(selector, component) {
    const el = document.querySelector(selector);
    if (el) {
        createApp(component).mount(el);
    }
}

// Mount components conditionally
mountComponent('#inventory-create', InventoryCreate);
// mountComponent('#user-profile', UserProfile);
>>>>>>> 9d23e93 (implement the vue js)
