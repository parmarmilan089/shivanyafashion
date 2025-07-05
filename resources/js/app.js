import { createApp } from 'vue';
import InventoryCreate from './components/InventoryCreate.vue';
// import UserProfile from './components/UserProfile.vue';

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