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
import axios from "axios";
const name = "PaymentSuccess";

onMounted(async () => {
    try {
        // カートをクリアするAPIを呼び出す
        await axios.delete("/clear-cart");
        console.log("Cart cleared successfully.");
    } catch (error) {
        console.error("Failed to clear the cart:", error);
    }
});
</script>
