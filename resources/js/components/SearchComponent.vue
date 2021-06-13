
<script>
import request from "../utils/request";

export default {
  data() {
    return {
      word: "",
      btnClass: {
        disabled: false,
      },
      data: {},
      totalResults: "",
      tab: {
          index:1,type:'all'
      },
      loading: false,
    };
  },
  mounted() {},
  methods: {
    activeTab(index, type) {
      this.data = {};
      this.loading = true;
      this.tab = {index,type};
      return request({
        url: "/search",
        method: "post",
        data: {
          word:this.word,
          q: type,
          page: 1,
        },
      })
        .then((res) => {
        //   const { data } = res.data;
          this.data = res.data
          this.loading = false
        })
        .catch((err) => {
         
        });
    },

    search(page = 1, q = null) {
      if (this.word == "") return false;
      this.data = {};
      this.loading = true;
      this.btnClass.disabled = true;
       return request({
        url: "/search",
        method: "post",
        data: {
          word:this.word,
          q: this.tab.type,
          page:1,
        },
      })
        .then((res) => {
          this.data = res.data
          this.loading = false
          this.btnClass.disabled = false;
        })
        .catch((err) => {
         
        });
    },
  },
};
</script>
<style scoped>
.search-wrap {
  display: flex;
  gap: 2rem;
  margin: 4rem 0;
}
.search-content {
  min-height: 200px;
  position: relative;
}
.loading {
  position: absolute;
  text-align: right;
}

.search-tabs {
  display: flex;
  gap: 2rem;
}
.search-item-type{
    font-size: .7rem;
    background: #f2f2f2;
    padding: .2rem .5rem;
    margin-top: 1rem;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #dbdbdb;
}
.search-tabs::before {
  content: "";
  position: absolute;
  bottom: 0;
  right: 0;
  left: 0;
  margin: 0 15px;
  border-bottom: 1px solid #e5e5e5;
}
.search-tabs li a {
  color: var(--text-secondary);
  padding-bottom: 1rem;
  display: block;
  position: relative;
}
.search-tabs li a.active {
  color: var(--blue);
}
.search-tabs li a::before {
  content: "";
  border-bottom: none;
  position: absolute;
  width: 100%;
  bottom: 0;
}
.search-tabs li a.active::before {
  border-bottom: 2px solid var(--blue);
}
.search-item {
  text-align: right;
     margin: 1rem 0 2rem 0;
}
.search-item p {
  color: var(--text-secondary);
}
.disabled {
  background: #dbdbdb;
}
</style>