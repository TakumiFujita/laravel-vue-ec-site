<template>
    <div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your purchase.</p>
    </div>
    <ContinueShoppingButton />
</template>

<script setup>
import ContinueShoppingButton from "../components/ContinueShoppingButton.vue";
import { onMounted } from "vue";
import { useStore } from "vuex";
import axios from "axios";
const name = "PaymentSuccess";
const store = useStore();

onMounted(async () => {
    try {
        // カートをクリアするAPIを呼び出す
        await axios.delete("/clear-cart");
        console.log("Cart cleared successfully.");
        store.dispatch("setCartCount", 0);
    } catch (error) {
        console.error("Failed to clear the cart:", error);
    }
});
</script>
