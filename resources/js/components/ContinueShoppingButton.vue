<!-- resources/js/components/ContinueShoppingButton.vue -->
<template>
    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
        <p>
            or{{ " " }}
            <router-link
                :to="link"
                class="font-medium text-indigo-600 hover:text-indigo-500"
            >
                {{ text }}
                <span aria-hidden="true"> &rarr;</span>
            </router-link>
        </p>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

// プロパティを定義
const props = defineProps({
    text: {
        type: String,
        default: "買い物を続ける",
    },
    link: {
        type: String,
        default: "/",
    },
});
</script>
