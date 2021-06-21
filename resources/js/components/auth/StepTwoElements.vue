<template>
  <div>
    <el-form
      ref="registerForm"
      :model="registerForm"
      :rules="stepTwoRules"
      class="login-form"
      auto-complete="off"
      label-position="left"
    >
      <el-form-item prop="activationCode">
        <el-input
          v-model="registerForm.activationCode"
          name="activationCode"
          type="text"
          auto-complete="off"
          placeholder="کد تایید ارسال شده را وارد کنید"
        />
      </el-form-item>
      <el-form-item>
        <el-row :gutter="10">
          <el-col :span="12">
            <el-form-item prop="firstName">
              <el-input
                v-model="registerForm.firstName"
                name="firstName"
                type="text"
                auto-complete="off"
                placeholder="نام"
              />
            </el-form-item>
          </el-col>

          <el-col :span="12">
            <el-form-item prop="lastName">
              <el-input
                v-model="registerForm.lastName"
                name="lastName"
                type="text"
                auto-complete="off"
                placeholder="نام خانوادگی"
              />
            </el-form-item>
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item>
        <el-row :gutter="10">
          <el-col :span="12">
            <el-form-item prop="uniqueName">
              <el-input
                v-model="registerForm.uniqueName"
                name="uniqueName"
                type="text"
                auto-complete="off"
                placeholder="نام کاربری"
              />
            </el-form-item>
          </el-col>

          <el-col :span="12">
            <el-form-item prop="password">
              <el-input
                v-model="registerForm.password"
                :type="pwdType"
                name="password"
                auto-complete="off"
                placeholder="password"
                @keyup.enter.native="handleRegister"
              />
              <span class="show-pwd" @click="showPwd"> </span>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form-item>

      <vue-recaptcha
        :loadRecaptchaScript="true"
        sitekey="6Le8Z-QaAAAAAImvSEAtV6Disqxo3f-h5ev0vKqI"
        @verify="onVerify"
      ></vue-recaptcha>

      <el-form-item>
        <el-button
          :loading="loading"
          type="success"
          style="width: 100%"
          @click.native.prevent="handleStepTwo"
        >
          تکمیل ثبت نام
        </el-button>
        <div v-if="errorMessage" class="el-form-item__error">
          {{ errorMessage }}
        </div>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { validEmail, validMoble, validAlphabets,validUserName } from "../../utils/validate";
import VueRecaptcha from "vue-recaptcha";
import axios from "axios";
import EventBus from "../../EventBus";
import StepOne from "./StepOne.vue";
export default {
  name: "Register",
  components: {
    VueRecaptcha,
    StepOne,
  },
  props: ["username"],

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
    const validateCode = (rule, value, callback) => {
      if (!value) {
        callback(new Error("کد تایید ارسال شده را وارد کنید"));
      } else {
        callback();
      }
    };
    const validateName = (rule, value, callback) => {
      console.log(value);
      if (!value && !validAlphabets(value)) {
        callback(new Error("نام بایستی تنها شامل حروف لاتین باشد"));
      } else {
        callback();
      }
    };

    const validateUserName = (rule, value, callback) => {
      if (!value && !validUserName(value)) {
        callback(
          new Error(
            "نام کاربری باید شامل حروف کوچک , بزرگ و کاراکترهای خاص باشد"
          )
        );
      } else {
        callback();
      }
    };

    return {
      stepTwo: false,
      registerForm: {
        uniqueName: "",
        username: this.username,
        password: "",
        firstName: "",
        lastName: "",
        activationCode: "",
        recaptcha: null,
      },

      stepTwoRules: {
        password: [
          { required: true, trigger: "blur", validator: validatePass },
        ],
        activationCode: [
          {
            required: true,
            trigger: "blur",
            message: "کد فعال سازی را وارد کنید",
          },
        ],
        firstName: [
          { required: true, trigger: "blur", validator: validateName },
        ],
        lastName: [
          {
            required: true,
            trigger: "blur",
            validator: validateName,
          },
        ],
        uniqueName: [
          {
            required: true,
            trigger: "blur",
            validator: validateUserName,
          },
        ],
      },
      loading: false,
      pwdType: "password",
      redirect: undefined,
      otherQuery: {},
      errorMessage: null,
      visibleRegister: false,
    };
  },

  methods: {
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
      this.registerForm.recaptcha = response;
    },

    showPwd() {
      if (this.pwdType === "password") {
        this.pwdType = "";
      } else {
        this.pwdType = "password";
      }
    },

    handleStepTwo() {
      this.$refs.registerForm.validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$store
            .dispatch("register", this.registerForm)
            .then((res) => {
              // console.log(res.data);
                window.location.href = res.data.redirect;
              this.loading = false;
            })
            .catch((error) => {
              this.errorMessage =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.loading = false;
            });
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
  created() {},
  mounted() {},
  destroyed() {
    console.log(this.$refs["registerFormStepTwo"]);
  },
};
</script>

<style  >
.el-link.el-link--danger {
  color: #606266;
  background: #ff5c5c;
  color: white;
  padding: 0.8rem 2rem 0.8rem 1.5rem;
  width: 100%;
}
.el-link.el-link--info {
  color: #606266;
  background: #5ccbff;
  color: white;
  padding: 0.8rem 2rem 0.8rem 1.5rem;
  width: 100%;
}
.el-link:hover {
  color: white !important;
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