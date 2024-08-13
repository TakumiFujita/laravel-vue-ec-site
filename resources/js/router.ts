import { createRouter, createWebHistory } from "vue-router";
import ProductList from "./pages/ProductList.vue";
import ProductDetail from "./pages/ProductDetail.vue";
import Cart from "./pages/Cart.vue";

const routes = [
    { path: "/", name: "product-list", component: ProductList },
    {
        path: "/productDetail/:id",
        name: "product-detail",
        component: ProductDetail,
    },
    { path: "/cart/:id", name: "cart", component: Cart },
    { path: "/dashboard", name: "Dashboard", component: ProductList },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
