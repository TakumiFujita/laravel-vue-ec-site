import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "axios";

// CSRFトークンの設定
axios.defaults.headers.common["X-CSRF-TOKEN"] =
    document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content") || "";

const app = createApp(App);

app.use(router); // ルーターの追加
app.use(store); // ストアの追加
app.mount("#app"); // アプリケーションのマウント
