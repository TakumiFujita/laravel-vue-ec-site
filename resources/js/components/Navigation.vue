<template>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <router-link to="/dashboard">
                            <!-- <img
                                src="/logo.png"
                                alt="Logo"
                                class="block h-9 w-auto fill-current text-gray-800"
                            /> -->
                        </router-link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <router-link
                            to="/dashboard"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            Dashboard
                        </router-link>
                    </div>
                </div>
                <!-- <span class="material-symbols-outlined"> shopping_cart </span> -->
                <!-- アイコンの部分 -->
                <router-link to="/cart" class="cart-icon">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>
                    <span class="cart-badge">{{ cartCount }}</span>
                    <!-- 商品数を表示するバッジ -->
                </router-link>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="relative">
                        <button
                            @click="open = !open"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                            <span v-if="user">{{ user.name }}</span>
                            <span v-else>Guest</span>
                            <svg
                                class="ml-1 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                        <div
                            v-if="open"
                            class="absolute right-0 mt-2 px-4 bg-white border border-gray-200 rounded-md shadow-lg py-2"
                        >
                            <router-link
                                to="/profile/edit"
                                class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 text-center"
                            >
                                Profile
                            </router-link>
                            <form @submit.prevent="logout">
                                <button
                                    type="submit"
                                    class="block w-auto text-center px-2 py-2 text-gray-700 hover:bg-gray-100 whitespace-nowrap"
                                >
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                v-if="!open"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                v-else
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div v-if="open" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <router-link
                    to="/dashboard"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                >
                    Dashboard
                </router-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div v-if="user" class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ user.name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ user.email }}
                    </div>
                </div>
                <div v-else class="px-4">
                    <div class="font-medium text-base text-gray-800">Guest</div>
                </div>
                <div class="mt-3 space-y-1">
                    <router-link
                        to="/profile/edit"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    >
                        Profile
                    </router-link>
                    <form @submit.prevent="logout">
                        <button
                            type="submit"
                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                        >
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</template>

<script lang="ts">
import { computed, defineComponent, onMounted, ref, watch } from "vue";
import { useStore } from "vuex";

export default defineComponent({
    name: "Navigation",
    setup() {
        const open = ref(false);
        const user = ref(window.authUser || null);
        // const cartCount = ref(0);
        const store = useStore();
        const cartCount = computed(() => store.getters.cartCount);

        onMounted(async () => {
            try {
                const response = await fetch("/cart/count");
                const data = await response.json();

                // cartCount.value = data.count;
                // console.log(`Updated Cart Count: ${cartCount.value}`);
            } catch (error) {
                console.error("Error fetching cart count:", error);
            }
        });

        const logout = async () => {
            try {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content");

                if (!csrfToken) {
                    throw new Error("CSRF token not found");
                }
                await fetch("/logout", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                window.location.href = "/login";
            } catch (error) {
                console.error("Error logging out:", error);
            }
        };

        // onMounted(fetchUser);

        return {
            open,
            user,
            cartCount,
            logout,
        };
    },
});
</script>

<style scoped>
.cart-icon {
    display: flex;
    align-items: center;
    position: relative;
    margin-right: 20px; /* 右側に余白を追加 */
}
</style>
