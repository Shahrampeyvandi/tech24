<template>
  <div>
    <el-dialog title="ثبت نام" :visible.sync="visibleRegister">
     <div>
        <StepOne v-if="stepOne" />
      <StepTwo :username="username"  v-if="stepTwo" />
     
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