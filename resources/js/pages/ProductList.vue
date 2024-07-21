<template>
    <div>
        <h1>商品一覧</h1>
        <div class="bg-white">
            <div
                class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8"
            >
                <h2 class="sr-only">商品一覧</h2>

                <div
                    class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                >
                    <router-link
                        v-for="product in products"
                        :key="product.id"
                        :to="{
                            name: 'product-detail',
                            params: { id: product.id },
                        }"
                        class="group"
                    >
                        <div
                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7"
                        >
                            <img
                                :src="product.image_path"
                                :alt="product.imageAlt"
                                class="h-full w-full object-cover object-center group-hover:opacity-75"
                            />
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">
                            {{ product.name }}
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            ¥{{ product.price }}
                        </p>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";

const products = ref([]);

// 商品取得
const fetchProducts = () => {
    fetch("/products")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            console.log("Fetched products:", data);
            products.value = data;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
};

// コンポーネントがマウントされた時に商品データを取得する
onMounted(() => {
    fetchProducts();
});
</script>

<style scoped></style>
