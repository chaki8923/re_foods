
<template>
  <div>
    <div class="search-form">
      <select name="" id="" @change="search" class="search-select">
        <option :value="0">全て表示</option>
        <option v-for="sub in sub_cat" :key="sub.id" :value="sub.api_id">
          {{ sub.food_name }}
        </option>
      </select>
      <i class="fas fa-search"></i>
    </div>
    <div class="row">
      <div
        class="sp col-xl-3 col-lg-5 col-md-5 mb-5 mt-5 p-0 col-xs-1"
        v-for="store in getItems"
        :key="store.id"
      >
        <div class="card text-decoration-none item-card">
          <div class="card-header d-flex justify-content-between">
            {{ store.food_name }}
          </div>
          <img
            :src="'/storage/images/' + store.pic1"
            alt="画像"
            class="card-img-top store-image"
            width="100%"
            height="200px"
          />
           <img :src="'/images/decision.gif'" alt="" class="decision-icon" v-show="store.decision_flg">
          <div class="card-body" style="height: 215px">
            <h4 class="card-title w-100">投稿者:{{ store.store_name }}</h4>
            <p class="">価格:{{ store.plice.toLocaleString() }}</p>
            <p class="">期限:{{ store.loss_limit }}</p>
            <a :href="detail_link.replace('/0', '/' + store.id)">
              <button class="btn btn-primary">詳しく見る</button>
            </a>

            <a
              :href="edit_link.replace('/0', '/' + store.id)"
              v-if="u_id == store.store_id"
            >
              <button class="btn btn-success">編集</button>
            </a>
          </div>
        </div>
      </div>
      <h3 v-if="hit_flg" class="no-hit">検索結果はありません</h3>
      <footer class="footer">
        <ul class="footer-list">
          <li class="footer-item">
            <a :href="about" class="footer-link">RE:FOOD'sとは？</a>
          </li>
          <li class="footer-item">
            <a :href="privacy" class="footer-link">プライバシーポリシー</a>
          </li>
          <li class="footer-item">
            <a :href="rule" class="footer-link">利用規約</a>
          </li>
          <li class="footer-item">
            <a :href="legal" class="footer-link">特定商法取引法</a>
          </li>
          <li class="footer-item">
            <a :href="contact" class="footer-link">お問い合わせ</a>
          </li>
        </ul>
      </footer>
      <paginate
        :page-count="getPageCount"
        :page-range="3"
        :margin-pages="4"
        :click-handler="clickCallback"
        :prev-text="'＜'"
        :next-text="'＞'"
        :container-class="'pagination'"
        :page-class="'page-item'"
        v-if="lists.length > parPage"
      >
      </paginate>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      category: "",
      lists: this.stores,
      my_flg: false,
      modal_flg: false,
      parPage: 6,
      currentPage: 1,
      hit_flg: false,
    };
  },
  props: [
    "stores",
    "edit_link",
    "detail_link",
    "u_id",
    "sub_cat",
    "cat_id",
    "about",
    "rule",
    "legal",
    "privacy",
    "contact",
  ],

  methods: {
    clickCallback: function (pageNum) {
      this.currentPage = Number(pageNum);
    },
    search(val) {
      const array = ["/item_list/search/", this.cat_id, "/", val.target.value];
      const path = array.join("");
      axios
        .get(path)
        .then((res) => {
          // console.log(res.data);

          this.lists = res.data;
        })
        .catch(function (err) {
          console.log(err);
        });
    },
  },
  mounted() {

  },
  computed: {
    getItems: function () {
      
      let current = this.currentPage * this.parPage;
      let start = current - this.parPage;
      return this.lists.slice(start, current);
    },
    getPageCount: function () {
      return Math.ceil(this.lists.length / this.parPage);
    },
  },
};
</script>
