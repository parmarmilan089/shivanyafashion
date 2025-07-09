import { createApp } from 'vue';
import InventoryCreate from './components/InventoryCreate.vue';

console.log('Vue app loading...');
// Helper to mount any component to a given DOM element
function mountComponent(selector, component, props = {}) {
    const el = document.querySelector(selector);
    if (el) {
        try {
            createApp(component, props).mount(el);
        } catch (error) {
            console.error('Error mounting Vue component:', error);
        }
    }
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    const element = document.querySelector('#inventory-create');
    if (element && window.inventoryProps) {
        mountComponent('#inventory-create', InventoryCreate, window.inventoryProps);
    }
});

// Also try mounting immediately in case DOM is already ready
if (document.readyState !== 'loading') {
    const element = document.querySelector('#inventory-create');
    if (element && window.inventoryProps) {
        mountComponent('#inventory-create', InventoryCreate, window.inventoryProps);
    }
}
