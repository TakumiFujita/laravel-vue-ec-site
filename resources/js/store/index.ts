import { createStore } from "vuex";

interface State {
    cartCount: number;
}

const store = createStore<State>({
    state: {
        cartCount: 0,
    },
    mutations: {
        INCREMENT_CART_COUNT(state, quantity: number) {
            state.cartCount += quantity;
        },
        DECREMENT_CART_COUNT(state, quantity: number) {
            state.cartCount = Math.max(0, state.cartCount - quantity);
        },
        SET_CART_COUNT(state, count: number) {
            state.cartCount = count;
        },
    },
    actions: {
        addToCart({ commit }, quantity: number) {
            // API 呼び出しなどの処理があればここに追加
            commit("INCREMENT_CART_COUNT", quantity);
        },
        removeFromCart({ commit }, quantity: number) {
            // API 呼び出しなどの処理があればここに追加
            commit("DECREMENT_CART_COUNT", quantity);
        },
        setCartCount({ commit }, count: number) {
            commit("SET_CART_COUNT", count);
        },
    },
    getters: {
        cartCount: (state) => state.cartCount,
    },
});

export default store;
