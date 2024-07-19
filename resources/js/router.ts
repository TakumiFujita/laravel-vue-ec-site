import { createRouter, createWebHistory } from 'vue-router';
import ProductList from './pages/ProductList.vue';
import Cart from './pages/Cart.vue';

const routes = [
  { path: '/', name: 'product-list', component: ProductList },
  { path: '/cart', name: 'cart', component: Cart },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
