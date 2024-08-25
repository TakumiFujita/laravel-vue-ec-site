<template>
    <div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your purchase.</p>
    </div>
    <ContinueShoppingButton />
</template>

<script setup>
import ContinueShoppingButton from "../components/ContinueShoppingButton.vue";
const name = "PaymentSuccess";
</script>
