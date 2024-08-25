import { createRouter, createWebHistory } from "vue-router";
import ProductList from "./pages/ProductList.vue";
import ProductDetail from "./pages/ProductDetail.vue";
import Cart from "./pages/Cart.vue";
import PaymentSuccess from "./pages/PaymentSuccess.vue";
import PaymentCancel from "./pages/PaymentCancel.vue";

const routes = [
    { path: "/", name: "product-list", component: ProductList },
    {
        path: "/productDetail/:id",
        name: "product-detail",
        component: ProductDetail,
    },
    { path: "/cart", name: "cart", component: Cart },
    {
        path: "/payment-success",
        name: "PaymentSuccess",
        component: PaymentSuccess,
    },
    {
        path: "/payment-cancel",
        name: "PaymentCancel",
        component: PaymentCancel,
    },
    { path: "/dashboard", name: "Dashboard", component: ProductList },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
