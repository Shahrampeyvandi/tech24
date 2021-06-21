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
    </el-form>
  </div>
</template>

<script>
import request from "../../utils/request";
import EventBus from "../../EventBus";
import {validMoble} from '../../utils/validate'
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
      errorMessage:false,
      loading: false,
      registerForm: {
        username: "",
      },
      stepOneRules: {
        username: [{ required: true, trigger: "blur", validator:validateMobile}],
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

              console.log(res.data)
              this.loading = false;
              EventBus.$emit("step_two", this.registerForm.username);
            })
            .catch((err) => {
              console.log(err.response)
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