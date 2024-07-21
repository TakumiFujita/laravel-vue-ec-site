import { createRouter, createWebHistory } from 'vue-router';
import ProductList from './pages/ProductList.vue';
import ProductDetail from './pages/ProductDetail.vue';
import Cart from './pages/Cart.vue';

const routes = [
  { path: '/', name: 'product-list', component: ProductList },
  { path: '/cart', name: 'cart', component: Cart },
  { path: '/productDetail/:id', name: 'product-detail', component: ProductDetail },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
