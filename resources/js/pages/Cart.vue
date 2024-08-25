<template>
    <!-- <TransitionRoot as="template" :show="open"> -->
    <!-- <Dialog class="relative z-10" @close="open = false"> -->
    <!-- <TransitionChild
            as="template"
            enter="ease-in-out duration-500"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="ease-in-out duration-500"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            />
        </TransitionChild> -->

    <!-- <div class="fixed inset-0 overflow-hidden"> -->
    <!-- <div class="absolute inset-0 overflow-hidden"> -->
    <!-- <div
        class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
    > -->
    <!-- <TransitionChild
        as="template"
        enter="transform transition ease-in-out duration-500 sm:duration-700"
        enter-from="translate-x-full"
        enter-to="translate-x-0"
        leave="transform transition ease-in-out duration-500 sm:duration-700"
        leave-from="translate-x-0"
        leave-to="translate-x-full"
    > -->
    <!-- <DialogPanel class="pointer-events-auto w-screen max-w-md"> -->
    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
        <h1>ショッピングカート</h1>
        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
            <!-- <div class="flex items-start justify-between"> -->
            <!-- <DialogTitle class="text-lg font-medium text-gray-900"
                    >Shopping cart</DialogTitle
                > -->
            <!-- <div class="ml-3 flex h-7 items-center"> -->
            <!-- <button -->
            <!-- type="button" class="relative -m-2 p-2 text-gray-400
                    hover:text-gray-500" @click="open = !open" >
                    <span class="absolute -inset-0.5" />
                    <span class="sr-only">Close panel</span> -->
            <!-- <XMarkIcon class="h-6 w-6" aria-hidden="true" /> -->
            <!-- </button> -->
            <!-- </div> -->
            <!-- </div> -->

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
                                    <!-- <p class="mt-1 text-sm text-gray-500">
                                        {{ product.color }}
                                    </p> -->
                                </div>
                                <div
                                    class="flex flex-1 items-end justify-between text-sm"
                                >
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
    <!-- </DialogPanel> -->
    <!-- </TransitionChild> -->
    <!-- </div> -->
    <!-- </div> -->
    <!-- </div> -->
    <!-- </Dialog> -->
    <!-- </TransitionRoot> -->
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { loadStripe } from "@stripe/stripe-js";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import ContinueShoppingButton from "../components/ContinueShoppingButton.vue";

// const products = [
//     {
//         id: 1,
//         name: "Throwback Hip Bag",
//         href: "#",
//         color: "Salmon",
//         price: "$90.00",
//         quantity: 1,
//         imageSrc:
//             "https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-01.jpg",
//         imageAlt:
//             "Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt.",
//     },
//     {
//         id: 2,
//         name: "Medium Stuff Satchel",
//         href: "#",
//         color: "Blue",
//         price: "$32.00",
//         quantity: 1,
//         imageSrc:
//             "https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-02.jpg",
//         imageAlt:
//             "Front of satchel with blue canvas body, black straps and handle, drawstring top, and front zipper pouch.",
//     },
// ];
const open = ref(true);

// カートアイテムの配列を作成
const cartItems = ref([]);

// カートアイテムを取得する関数
const fetchCartItems = async () => {
    try {
        console.log("before if");
        const response = await axios.get("/cart"); // カート情報を取得するエンドポイント
        console.log("response.data:", JSON.stringify(response.data, null, 2));
        // if (response.data.status === "success") {
        //     console.log("success");
        //     cartItems.value = response.data.cartItems;
        //     console.log(cartItems.value);
        // }
        cartItems.value = response.data.map((item) => ({
            id: item.id,
            name: item.product.name,
            price: parseFloat(item.product.price),
            imageSrc: item.product.image_path,
            imageAlt: item.product.name,
            quantity: 1, // 必要に応じて適切な数量を設定
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
    } catch (error) {
        console.error("Error removing item from cart:", error);
    }
};

const totalPrice = computed(() => {
    return cartItems.value.reduce((total, item) => {
        return total + item.price;
    }, 0);
});

// コンポーネントがマウントされたときにカートアイテムを取得
onMounted(() => {
    fetchCartItems();
    console.log("after fetchCartItems");
});

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
