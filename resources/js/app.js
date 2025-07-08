import { createApp } from 'vue';
import InventoryCreate from './components/InventoryCreate.vue';
import InventoryEdit from './components/InventoryEdit.vue';

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
// Only mount once, on DOMContentLoaded
// (Remove the immediate mount block to avoid double-mounting)
document.addEventListener('DOMContentLoaded', function() {
    const createElement = document.querySelector('#inventory-create');
    if (createElement && window.inventoryProps) {
        mountComponent('#inventory-create', InventoryCreate, window.inventoryProps);
    }
    const editElement = document.querySelector('#inventory-edit');
    if (editElement && window.inventoryEditProps) {
        mountComponent('#inventory-edit', InventoryEdit, window.inventoryEditProps);
    }
});