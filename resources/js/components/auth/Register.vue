<template>
  <div>
    <el-dialog title="ثبت نام" :visible.sync="visibleRegister">
     <div>
        <StepOne v-if="stepOne" />
      <StepTwo :username="username"  v-if="stepTwo" />
      <el-row :gutter="20" type="flex" justify="start">
        
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
     </div>
    </el-dialog>
  </div>
</template>

<script>
import EventBus from "../../EventBus";
import StepOne from "./StepOne.vue";
import StepTwo from "./StepTwoElements.vue";
export default {
  name: "Register",
  components: {
    StepTwo,
    StepOne,
  },
  data() {
    return {
      stepOne: true,
      stepTwo: false,
      loading: false,
      visibleRegister: false,
      username:""
    };
  },
  watch: {
    $route: {
      // handler: function(route) {
      //   const query = route.query;
      //   if (query) {
      //     this.redirect = query.redirect;
      //     this.otherQuery = this.getOtherQuery(query);
      //   }
      // },
      // immediate: true,
    },
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
    onVerifyStepOne(response) {
      this.registerFormStepOne.recaptcha = response;
    },
    onVerifyStepTwo(response) {
      this.registerFormStepTwoOne.recaptcha = response;
    },
    showPwd() {
      if (this.pwdType === "password") {
        this.pwdType = "";
      } else {
        this.pwdType = "password";
      }
    },
    handleRegister() {
      this.$refs.registerFormStepOne.validate((valid) => {
        if (valid) {
          this.stepOne = false;
          this.stepTwo = true;
        } else {
          return false;
        }
      });
    },
    handleStepTwo() {
      this.$refs.registerFormStepTwo.validate((valid) => {
        if (valid) {
          console.log("submit");
        }
      });
      // this.$store
      //   .dispatch("register", this.loginForm)
      //   .then((res) => {
      //     console.log(res);
      //     window.location.href = "/";
      //     this.loading = false;
      //   })
      //   .catch((error) => {
      //     // console.log(error.response)
      //     this.errorMessage =
      //       error.response.data.errors[
      //         Object.keys(error.response.data.errors)[0]
      //       ][0];
      //     this.loading = false;
      //   });
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
    //  this.$refs['registerFormStepTwo'].resetFields();

   
    EventBus.$on("show_register", () => {
      this.visibleRegister = true;
    });

      EventBus.$on("step_two", (username) => {
      this.stepOne = false;
       this.stepTwo = true;
       this.username = username
    //    this.registerForm.username = username
    });
  },
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