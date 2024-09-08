<template>
    <div v-if="loading" class="text-center">Loading...</div>
    <div v-else-if="product" class="bg-white">
        <div class="pt-6">
            <!-- Image gallery -->
            <div
                class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8"
            >
                <div
                    class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block"
                >
                    <img
                        :src="product.image_path"
                        :alt="product.name"
                        class="h-full w-full object-cover object-center"
                    />
                </div>
                <div class="hidden lg:grid lg:grid-cols-1 lg:gap-y-8">
                    <div
                        class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg"
                    >
                        <img
                            :src="product.image_path"
                            :alt="product.name"
                            class="h-full w-full object-cover object-center"
                        />
                    </div>
                    <div
                        class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg"
                    >
                        <img
                            :src="product.image_path"
                            :alt="product.name"
                            class="h-full w-full object-cover object-center"
                        />
                    </div>
                </div>
                <div
                    class="aspect-h-5 aspect-w-4 lg:aspect-h-4 lg:aspect-w-3 sm:overflow-hidden sm:rounded-lg"
                >
                    <img
                        :src="product.image_path"
                        :alt="product.name"
                        class="h-full w-full object-cover object-center"
                    />
                </div>
            </div>

            <!-- Product info -->
            <div
                class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16"
            >
                <div
                    class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8"
                >
                    <h1
                        class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"
                    >
                        {{ product.name }}
                    </h1>
                </div>
                <!-- Options -->
                <div class="mt-4 lg:row-span-3 lg:mt-0">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl tracking-tight text-gray-900">
                        ¥{{ product.price }}
                    </p>

                    <!-- Reviews -->
                    <div class="mt-6">
                        <h3 class="sr-only">Reviews</h3>
                        <div class="flex items-center"></div>
                    </div>

                    <form class="mt-10" @submit.prevent="addToCart">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    数量: {{ selectedQuantity }}
                                    <ChevronDownIcon
                                        class="-mr-1 h-5 w-5 text-gray-400"
                                        aria-hidden="true"
                                    />
                                </MenuButton>
                            </div>

                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="py-1">
                                        <div class="py-1">
                                            <!-- Loop through quantity options -->
                                            <MenuItem
                                                v-for="number in quantities"
                                                :key="number"
                                            >
                                                <button
                                                    type="button"
                                                    @click="setQuantity(number)"
                                                    :class="[
                                                        selectedQuantity ===
                                                        number
                                                            ? 'bg-gray-100 text-gray-900'
                                                            : 'text-gray-700',
                                                        'block w-full px-4 py-2 text-left text-sm',
                                                    ]"
                                                >
                                                    {{ number }}
                                                </button>
                                            </MenuItem>
                                        </div>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                        <!-- Sizes -->
                        <div class="mt-10">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900">
                                    <ul>
                                        <li
                                            v-for="category in product.categories"
                                            :key="category.id"
                                        >
                                            {{ category.name }}
                                        </li>
                                    </ul>
                                </h3>
                                <a
                                    href="#"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                                    >Size guide</a
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            カートに入れる
                        </button>
                    </form>
                </div>

                <div
                    class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6"
                >
                    <!-- Description and details -->
                    <div>
                        <h3 class="sr-only">Description</h3>

                        <div class="space-y-6">
                            <p class="text-base text-gray-900">
                                {{ product.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useStore } from "vuex";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import router from "../router";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";

// Product 型の定義（例）
interface Product {
    id: number;
    name: string;
    price: string;
    stock_quantity: number;
    description: string;
    image_path: string; // Optional
    created_at: string;
    updated_at: string;
}

const reviews = { href: "#", average: 4, totalCount: 117 };
const product = ref<Product | null>(null);
const loading = ref(true);
const store = useStore();
const route = useRoute();
const quantities = [1, 2, 3];
const selectedQuantity = ref(1);

// APIからデータを取得
onMounted(async () => {
    console.log("onMounted");
    try {
        const id = route.params.id as string;
        const response = await fetch(`/productDetail/${id}`); // 修正: URLをAPIエンドポイントに合わせる
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        product.value = data; // 適切なプロダクトデータに変更
    } catch (error) {
        console.error("Failed to fetch product data:", error);
    } finally {
        loading.value = false; // データ取得が完了したらローディングを終了
    }
});

function setQuantity(quantity: number) {
    selectedQuantity.value = quantity;
}

const addToCart = async () => {
    if (!product.value) return;

    const quantity = selectedQuantity.value;
    try {
        await store.dispatch("addToCart", quantity);

        // カート情報をデータベースに保存するリクエストを送信
        console.log(`product.value.id:${product.value.id}`);
        await axios
            .post(`/cart/${product.value.id}`, { quantity })
            .then((response) => {
                router.push({ name: "cart" });
            })
            .catch((error) => {});

        // カートの数を再取得して更新
        const response = await fetch("/cart/count");
        const data = await response.json();
        console.log("Updated Cart Count from API:", data.count);
        store.commit("SET_CART_COUNT", data.count);
    } catch (error) {
        console.log("error内");
        console.error("Failed to add product to cart:", error);
    }
};
</script>
