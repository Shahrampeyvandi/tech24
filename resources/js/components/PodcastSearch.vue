<template>
  <section class="podcasts-header">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="flex-column-center text-white py-8">
            <h3 class="mb-3">آموزش بشنوید</h3>
            <h2 class="mb-5">پادکست های تکوان ۲۴</h2>
            <div class="row col-12">
              <div class="col-12 col-md-10 mx-auto">
                <input
                  @keyup="search"
                  v-model="searchWord"
                  type="text"
                  style="border:none"
                  class="p-2 w-100 rounded"
                  placeholder="میخوای چی گوش کنی؟"
                />
                <div class="podcast-search-results" v-if="showResults">
                  <ul>
                    <li v-for="result in results" :key="result.id">
                      <a :href="result.slug">{{ result.title }}</a>
                    </li>
                   
                  </ul>
                </div>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import request from "../utils/request";

export default {
  components: {},
  data() {
    return {
      showResults: false,
      results: [],
      searchWord: "",
      // auth:this.auth
    };
  },
  computed: {
    searchUrl() {
      return "/search";
    },
    logoutUrl() {
      return "/logout";
    },
    panelUrl() {
      return "/panel/" + this.auth.username;
    },
  },
  methods: {
    search() {
      this.results = [];
      this.showResults = false;
      setTimeout(() => {
        if (this.searchWord.length > 2) {
          request({
            url: "/search",
            method: "post",
            data: {
              word: this.searchWord,
              q: "podcast",
            },
          })
            .then((res) => {
              if (res.data.data.total) {
                this.showResults = true;
                this.results = res.data.data.data;
              } else {
                this.showResults = false;
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }
      }, 300);
    },
  },
  created() {
    this.searchWord = "";
  },
};
</script>

<style lang="scss" scoped>
</style>