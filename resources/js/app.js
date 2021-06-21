require("./bootstrap");

window.Vue = require("vue");
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import locale from "element-ui/lib/locale/lang/en";
import request from "./utils/request";

Vue.use(ElementUI, { locale });

Vue.prototype.$baseUrl = process.env.APP_URL;

export const EventBus = new Vue();

import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        showLogin: false,
        showRegister: false
    },
    mutations: {
        'SHOW_LOGIN'(state) {
            state.showLogin = true;
        },
        'SHOW_REGISTER'(state) {
            state.showRegister = true;
        }
    },
    actions: {
        showLogin({ commit }) {
            commit("SHOW_LOGIN");
        },
        showRegister({ commit }) {
            commit("SHOW_REGISTER");
        },
        login({ commit }, userInfo) {
            //  console.log(userInfo)
            const { username, password, recaptcha } = userInfo;
            const Params = new URLSearchParams(window.location.search);
            if(Params.get('afterLogin')) {
                var url = "/login?afterLogin=" + Params.get('afterLogin')
            }else{
                var url = "/login"
            }
            return request({
                url,
                method: "post",
                data: {
                    username: username,
                    password: password,
                    "g-recaptcha-response": recaptcha
                }
            });
        },
        register({ commit }, userInfo) {
          //  console.log(userInfo)
          const { firstName,lastName,uniqueName,activationCode,mobile, password, recaptcha } = userInfo;
          return request({
              url: "/register",
              method: "post",
              data: {
                firstName,
                lastName,
                activationCode,
                mobile,
                password,
                uniqueName,
                "g-recaptcha-response": recaptcha
              }
          });
      }
    }
});

Vue.component(
    "search-component",
    require("./components/SearchComponent.vue").default
);
Vue.component("pagination", require("laravel-vue-pagination"));
Vue.component("login-component", require("./components/auth/Login.vue").default);
Vue.component("register-component", require("./components/auth/Register.vue").default);

Vue.component(
    "button-component",
    require("./components/auth/Buttons.vue").default
);

const app = new Vue({
    el: "#app",
    store
});
