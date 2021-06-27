<template>
  <div class="topbar_right">
    <div
      v-if="auth"
      class="dropdown"
      style="cursor: pointer; margin-left: 1rem"
    >
    
      <a
        class="dropdown-toggle"
        type="button"
        id="dropdownMenuButton"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
      >
        {{auth.username}}
        <i class="icon-user"></i>
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" :href="panelUrl">پنل کاربری</a>
        <a class="dropdown-item" :href="logoutUrl">خروج</a>
      </div>
    </div>

      <a v-if="auth == null"
        href="#"
        @click.prevent="showLogin"
        class="topbar_rigester"
      >
        <i class="icon-lock ml-1"></i>
        ورود
      </a>
      <a v-if="auth == null" @click.prevent="showRegister" href="#" class="topbar_rigester">
        <i class="icon-user ml-1"></i>
        ثبت نام</a
      >

    |
    <a :href="searchUrl" class="searchbox_toggle mx-3" style="cursor: pointer">
      <i class="icon-search"></i>
    </a>
    <Login />
    <Register />
  </div>
  
</template>

<script>
import EventBus from '../../EventBus'
  import Login from './Login.vue';
  import Register from './Register.vue';

export default {
  props: ["auth"],
  components: {
    Login,Register
  },
  data() {
    return {
      // auth:this.auth
    };
  },
  computed: {
      searchUrl() {
          return '/search' 
      },logoutUrl() {
        return '/logout' 
      },panelUrl(){
        return '/panel/'+this.auth.username
      }
  },
  methods: {
      showLogin() {
          // this.$store.dispatch('showLogin')
          EventBus.$emit('show_login')
      },
       showRegister() {
          // this.$store.dispatch('showRegister')
            EventBus.$emit('show_register')
      }
  },
  created() {
    console.log(this.$baseUrl);
  },
};
</script>

<style lang="scss" scoped>
</style>