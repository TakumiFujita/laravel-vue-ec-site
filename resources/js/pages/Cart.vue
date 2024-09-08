<template>
    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
        <h1>ショッピングカート</h1>
        <div class="flex-1 px-4 py-6 sm:px-6">
            <div class="mt-8">
                <div class="flow-root">
                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                        <li
                            v-for="product in cartItems"
                            :key="product.id"
                            class="flex py-6"
                        >
                            <div
                                class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200"
                            >
                                <img
                                    :src="product.imageSrc"
                                    :alt="product.imageAlt"
                                    class="h-full w-full object-cover object-center"
                                />
                            </div>

                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div
                                        class="flex justify-between text-base font-medium text-gray-900"
                                    >
                                        <h3>
                                            <a :href="product.href">{{
                                                product.name
                                            }}</a>
                                        </h3>
                                        <p class="ml-4">¥{{ product.price }}</p>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-1 items-end justify-between text-sm"
                                >
                                    <Menu
                                        as="div"
                                        class="relative inline-block text-left"
                                    >
                                        <div>
                                            <MenuButton
                                                class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                            >
                                                数量: {{ product.quantity }}
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
                                                    <!-- Loop through quantity options -->
                                                    <MenuItem
                                                        v-for="number in quantities"
                                                        :key="number"
                                                    >
                                                        <button
                                                            type="button"
                                                            @click="
                                                                updateQuantity(
                                                                    product.id,
                                                                    number
                                                                );
                                                                console.log(
                                                                    'Selected quantity:',
                                                                    number
                                                                ); // デバッグ用
                                                            "
                                                            :class="[
                                                                product.quantity ===
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
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                    <p class="text-gray-500">
                                        Qty
                                        {{ product.quantity }}
                                    </p>

                                    <div class="flex">
                                        <button
                                            type="button"
                                            class="font-medium text-indigo-600 hover:text-indigo-500"
                                            @click="removeItem(product.id)"
                                        >
                                            削除
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
            <div
                class="flex justify-between text-base font-medium text-gray-900"
            >
                <p>小計</p>
                <p>¥{{ totalPrice }}</p>
            </div>
            <p class="mt-0.5 text-sm text-gray-500">
                Shipping and taxes calculated at checkout.
            </p>
            <div class="mt-6">
                <button
                    @click="checkout"
                    class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700"
                >
                    購入手続きへ
                </button>
            </div>
            <ContinueShoppingButton />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import axios from "axios";
import { loadStripe } from "@stripe/stripe-js";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import ContinueShoppingButton from "../components/ContinueShoppingButton.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";

const open = ref(true);

// カートアイテムの配列を作成
const cartItems = ref([]);

// 数量選択用のオプション（1〜10までの数量）
const quantities = ref([...Array(3).keys()].map((i) => i + 1));

const store = useStore();

// カートアイテムを取得する関数
const fetchCartItems = async () => {
    try {
        const response = await axios.get("/cart"); // カート情報を取得するエンドポイント
        // console.log("response.data:", JSON.stringify(response.data, null, 2));
        cartItems.value = response.data.map((item) => ({
            id: item.id,
            name: item.product.name,
            price: parseFloat(item.product.price),
            imageSrc: item.product.image_path,
            imageAlt: item.product.name,
            quantity: item.quantity, // 必要に応じて適切な数量を設定
        }));
    } catch (error) {
        console.error("Error fetching cart items:", error);
    }
};

// 商品削除処理
const removeItem = async (productId) => {
    try {
        await axios.delete(`/cart/${productId}`);
        // 削除後にcartItemsから削除された商品を取り除く
        cartItems.value = cartItems.value.filter(
            (item) => item.id !== productId
        );

        await store.dispatch("removeFromCart", 1);
    } catch (error) {
        console.error("Error removing item from cart:", error);
    }
};

// 数量更新処理
const updateQuantity = async (productId, quantity) => {
    try {
        await axios.put(`/cart/${productId}`, { quantity });
        const product = cartItems.value.find((item) => item.id === productId);
        if (product) {
            product.quantity = quantity;
        }
    } catch (error) {
        console.error("Error updating quantity:", error);
    }
};

const totalPrice = computed(() => {
    return cartItems.value.reduce((total, item) => {
        return total + item.price * item.quantity;
    }, 0);
});

// コンポーネントがマウントされたときにカートアイテムを取得
onMounted(fetchCartItems);

// 環境変数から公開キーを取得
const stripePublicKey = import.meta.env.VITE_STRIPE_PUBLIC_KEY;

// チェックアウト処理を定義
const checkout = async () => {
    try {
        // Stripeの公開キーを使ってインスタンスを作成
        const stripe = await loadStripe(stripePublicKey);

        // バックエンドのチェックアウトエンドポイントにリクエストを送信
        const response = await axios.post("/checkout");

        // バックエンドから返されたセッションIDを使ってStripeの決済ページにリダイレクト
        const { id } = response.data;
        const { error } = await stripe.redirectToCheckout({
            sessionId: id,
        });

        if (error) {
            console.error("Error redirecting to checkout:", error);
        }
    } catch (error) {
        console.error("Error creating checkout session:", error);
    }
};

// 確認用に Vue インスタンスの存在をコンソールに出力
// console.log("Vue instance:", Vue);
console.log("open:", open.value);
</script>
