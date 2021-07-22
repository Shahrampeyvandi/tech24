<template>
  <div>
    <el-form
      ref="registerFormStepOne"
      :model="registerForm"
      :rules="stepOneRules"
      class="login-form"
      auto-complete="off"
      label-position="left"
    >
      <el-form-item prop="username">
        <span class="svg-container">
          <i class="el-icon-user"></i>
        </span>
        <el-input
          v-model="registerForm.username"
          name="username"
          type="text"
          auto-complete="off"
          placeholder="شماره موبایل خود را وارد کنید"
        />
      </el-form-item>

      <el-row :gutter="20" type="flex" justify="start">
        <el-col :span="12" :xs="24" :md="12">
          <el-form-item>
            <el-button
              :loading="loading"
              type="success"
              style="width: 100%"
              @click.native.prevent="handleRegister"
            >
              ارسال کد تایید
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
            ثبت نام با حساب گوگل
          </el-link>
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import request from "../../utils/request";
import EventBus from "../../EventBus";
import { validMoble } from "../../utils/validate";
export default {
  data() {
    const validateMobile = (rule, value, callback) => {
      if (!validMoble(value)) {
        callback(new Error("شماره موبایل خود را وارد کنید"));
      } else {
        callback();
      }
    };
    return {
      errorMessage: false,
      loading: false,
      registerForm: {
        username: "",
      },
      stepOneRules: {
        username: [
          { required: true, trigger: "blur", validator: validateMobile },
        ],
      },
    };
  },
  methods: {
    handleRegister() {
      this.$refs.registerFormStepOne.validate((valid) => {
        if (valid) {
          this.loading = true;

          request({
            url: "/check-mobile",
            method: "post",
            data: {
              mobile: this.registerForm.username,
            },
          })
            .then((res) => {
              console.log(res.data);
              this.loading = false;
              EventBus.$emit("step_two", this.registerForm.username);
            })
            .catch((err) => {
              console.log(err.response);
              this.errorMessage =
                err.response.data.errors[
                  Object.keys(err.response.data.errors)[0]
                ][0];
              this.loading = false;
            });
        } else {
          return false;
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>