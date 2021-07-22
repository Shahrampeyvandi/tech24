<template>
  <div>
    <el-dialog title="ورود به تکوان 24" :visible.sync="visibleLogin">
      <el-form
        ref="loginForm"
        :model="loginForm"
        :rules="loginRules"
        class="login-form"
        auto-complete="on"
        label-position="left"
      >
        <el-form-item prop="username">
          <span class="svg-container">
            <i class="el-icon-user"></i>
          </span>
          <el-input
            v-model="loginForm.username"
            name="username"
            type="text"
            auto-complete="on"
            placeholder="شماره موبایل خود را وارد کنید"
          />
        </el-form-item>
        <el-form-item prop="password">
          <span class="svg-container">
            <i class="el-icon-unlock"></i>
          </span>
          <el-input
            v-model="loginForm.password"
            :type="pwdType"
            name="password"
            auto-complete="on"
            placeholder="password"
            @keyup.enter.native="handleLogin"
          />
          <span class="show-pwd" @click="showPwd"> </span>
        </el-form-item>
        <vue-recaptcha
          :loadRecaptchaScript="true"
          sitekey="6Le8Z-QaAAAAAImvSEAtV6Disqxo3f-h5ev0vKqI"
          @verify="onVerify"
        ></vue-recaptcha>
        <el-form-item>
          <el-checkbox label="مرا به خاطر بسپار" name="type"></el-checkbox>
        </el-form-item>

        <el-row :gutter="20" type="flex" justify="start">
          <el-col :span="12" :xs="24" :md="12">
            <el-form-item>
              <el-button
                :loading="loading"
                type="warning"
                style="width: 100%"
                @click.native.prevent="handleLogin"
              >
                ورود
              </el-button>
              <div v-if="errorMessage" class="el-form-item__error">
                {{ errorMessage }}
              </div>
            </el-form-item>
          </el-col>
          <el-col :span="12" :xs="24" :md="12">
            <el-link type="danger" href="/auth/google">
              <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
                data-svg="google"
              >
                <path
                  d="M17.86,9.09 C18.46,12.12 17.14,16.05 13.81,17.56 C9.45,19.53 4.13,17.68 2.47,12.87 C0.68,7.68 4.22,2.42 9.5,2.03 C11.57,1.88 13.42,2.37 15.05,3.65 C15.22,3.78 15.37,3.93 15.61,4.14 C14.9,4.81 14.23,5.45 13.5,6.14 C12.27,5.08 10.84,4.72 9.28,4.98 C8.12,5.17 7.16,5.76 6.37,6.63 C4.88,8.27 4.62,10.86 5.76,12.82 C6.95,14.87 9.17,15.8 11.57,15.25 C13.27,14.87 14.76,13.33 14.89,11.75 L10.51,11.75 L10.51,9.09 L17.86,9.09 L17.86,9.09 Z"
                ></path>
              </svg>
              ورود با حساب گوگل
            </el-link>
          </el-col>
        </el-row>

        <el-link
          type="primary"
          @click.native.prevent="visibleRegister"
          href="#"
        >
          چنانچه حساب کاربری ندارید ثبت نام کنید
        </el-link>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import { validEmail, validMoble } from "../../utils/validate";
import VueRecaptcha from "vue-recaptcha";
import axios from "axios";
import EventBus from "../../EventBus";
export default {
  name: "Login",
  components: {
    VueRecaptcha,
  },
  data() {
    const validateMobile = (rule, value, callback) => {
      if (!validMoble(value) && !validEmail(value)) {
        callback(new Error("شماره موبایل یا ایمیل وارد کنید"));
      } else {
        callback();
      }
    };
    const validatePass = (rule, value, callback) => {
      if (value.length < 6) {
        callback(new Error("رمز عبور نمیتواند کمتر از 6 کاراکتر باشد"));
      } else {
        callback();
      }
    };
    return {
      loginForm: {
        username: "",
        password: "",
        recaptcha: null,
      },
      loginRules: {
        username: [
          { required: true, trigger: "blur", validator: validateMobile },
        ],
        password: [
          { required: true, trigger: "blur", validator: validatePass },
        ],
      },
      loading: false,
      pwdType: "password",
      redirect: undefined,
      otherQuery: {},
      errorMessage: null,
      visibleLogin: false,
    };
  },
  watch: {
    // $route: {
    //   handler: function(route) {
    //     const query = route.query;
    //     if (query) {
    //       this.redirect = query.redirect;
    //       this.otherQuery = this.getOtherQuery(query);
    //     }
    //   },
    //   immediate: true,
    // },
  },
  methods: {
    visibleRegister() {
      this.visibleLogin = false;
      EventBus.$emit("show_register");
    },
    google() {
      axios
        .get("/login/google", {
          withCredentials: true,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          crossDomain: true,
        })
        .then((res) => {
          console.log(res.data);
        });
    },
    onVerify(response) {
      this.loginForm.recaptcha = response;
    },
    showPwd() {
      if (this.pwdType === "password") {
        this.pwdType = "";
      } else {
        this.pwdType = "password";
      }
    },
    handleLogin() {
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.loading = true;

          this.$store
            .dispatch("login", this.loginForm)
            .then((res) => {
              const { data } = res;
              console.log(data);
              this.loading = false;
              if (data.auth) {
                window.location.href = data.redirect;
              } else {
                this.errorMessage = "خطایی در ورود شما اتفاق افتاد";
              }
            })
            .catch((error) => {
              console.log(error.response);
              this.errorMessage =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.loading = false;
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== "redirect") {
          acc[cur] = query[cur];
        }
        return acc;
      }, {});
    },
  },
  created() {
    setTimeout(() => {
      if (window.location.search.indexOf("afterLogin") == 1) {
        this.visibleLogin = true;
      }
    }, 1200);

    EventBus.$on("show_login", () => {
      this.visibleLogin = true;
    });
  },
};
</script>

<style  >
.el-link.el-link--danger {
  color: #606266;
  background: #ff5c5c;
  color: white;
  padding: 0.6rem 1.5rem 0.6rem 1.5rem !important;
  width: 100%;
  border-radius: 5px;
}
.el-link.el-link--info {
  color: #606266;
  background: #5ccbff;
  color: white;
  padding: 0.8rem 2rem 0.8rem 1.5rem;
  width: 100%;
}
.el-link.el-link--primary:hover {
  color: #66b1ff !important;
}
.el-link--inner {
  display: flex;
}
.el-link--inner svg {
  fill: white;
  margin-left: 0.5rem;
}
.el-dialog {
  width: 40%;
}

@media (max-width: 679px) {
  .el-dialog {
    width: 95%;
  }
}
.el-form-item {
  margin-bottom: 30px;
}
.el-input__inner {
  padding: 0 40px;
}
.svg-container {
  position: absolute;
  z-index: 1;
  right: 15px;
}
.el-checkbox__label {
  padding-right: 10px;
}
.el-form-item__content {
  text-align: right;
}
.el-dialog__header {
  text-align: center;
}
.el-form-item__error {
  right: 0;
}
.el-dialog__body {
  text-align: right;
}
</style>