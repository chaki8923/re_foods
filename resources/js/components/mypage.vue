

<template>
  <div>
    <div class="tab-area">
      <ul class="tab-list">
        <li class="tab-item" @click="all">全て</li>
        <li class="tab-item" @click="like">自分が気になってる食材</li>
        <li class="tab-item" @click="re_like">相手が気になってる食材</li>
        <li class="tab-item" @click="decision">成約済みの食材</li>
      </ul>
    </div>
    <div class="row justify-content-center m-0" style="position: relative">
      <div
        class="sp col-xl-3 col-lg-5 col-md-5 mb-5 mt-5 p-0 col-xs-1"
        v-for="list in lists"
        :key="list.id"
      >
        <div class="card text-decoration-none item-card">
          <div class="card-header d-flex justify-content-between">
            {{ list.food_name }}
          </div>
          <img
            :src="'/storage/images/' + list.pic1"
            alt="画像"
            class="card-img-top store-image"
            width="100%"
            height="200px"
          />
          <img
            :src="'/images/decision.gif'"
            alt=""
            class="decision-icon"
            v-show="list.decision_flg"
          />
          <div class="card-body" style="height: 215px">
            <h4 class="card-title w-100">
              価格:{{ list.plice.toLocaleString() }}
            </h4>
            <p class="">賞味期限:{{ list.loss_limit }}</p>
            <a :href="detail_link.replace('/0', '/' + list.id)">
              <button class="btn btn-primary">詳細</button>
            </a>

            <a
              :href="edit_link.replace('/0', '/' + list.id)"
              v-if="list.store_id == u_id"
            >
              <button class="btn btn-success">編集</button>
            </a>

            <button
              class="btn btn-danger"
              @click="modal_show(list.id)"
              v-if="list.store_id == u_id"
            >
              削除
            </button>
          </div>
          <transition name="modal">
            <div class="modal-decision" v-if="modal_flg">
              <h3>削除しますか？</h3>
              <img :src="'/images/hatena.png'" alt="" class="hatena" />
              <div class="modal-btn">
                <button class="btn btn-primary" @click="closeModal">
                  close
                </button>
                <button @click="delete_food(delete_id)" class="btn btn-success">
                  YES
                </button>
              </div>
            </div>
          </transition>
        </div>
      </div>
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
    </div>

    <ul class="pagenation dec" v-if="decision_flg">
       <li @click="prev" v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-left arrow"></i></li>
      <li
        v-for="(page, index) in pageNum"
        :key="page.index"
        class="page-list"
        @click="decision_paging(index + 1)"
        :class="{ active: page.click_flg }"
        v-show="index + 1 <= Math.ceil(pageNum.length / parPage)"
      >
        {{ index + 1 }}
      </li>
       <li @click="next"  v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-right arrow"></i></li>
    </ul>
    <ul class="pagenation" v-if="like_flg">
       <li @click="prev" v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-left arrow"></i></li>
      <li
        v-for="(page, index) in pageNum"
        class="page-list"
        :class="{ active: page.click_flg }"
        :key="page.id"
        @click="like_paging(index + 1)"
        v-show="index + 1 <= Math.ceil(pageNum.length / parPage)"
      >
        {{ index+ 1 }}
      </li>
       <li @click="next"  v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-right arrow"></i></li>
    </ul>
    <ul class="pagenation" v-if="relike_flg">
      <li @click="prev" v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-left arrow"></i></li>
      <li
        v-for="(page, index) in pageNum"
        class="page-list"
        :class="{ active: page.click_flg }"
        :key="page.id"
        @click="relike_paging(index + 1)"
        v-show="index + 1 <= Math.ceil(pageNum.length / parPage)"
      >
        {{ index + 1 }}
      </li>
       <li @click="next"  v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-right arrow"></i></li>
    </ul>
    <ul class="pagenation all" v-if="!decision_flg && !like_flg && !relike_flg">
      <li @click="prev" v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-left arrow"></i></li>
      <li
        v-for="(page, index) in pageNum"
        class="page-list"
        :class="{ active: page.click_flg }"
        :key="page.id"
        @click="all_paging(index + 1)"
        v-show="index + 1 <= Math.ceil(pageNum.length / parPage)"
      >
        {{ index + 1 }}
      </li>
      <li @click="next"  v-show="parPage <  pageNum.length" ><i class="fas fa-chevron-right arrow"></i></li>
    </ul>
  </div>
</template>




<script>
export default {
  data: function () {
    return {
      lists: [],
      my_flg: false,
      modal_flg: false,
      parPage: 4,
      pageNum: "",
      delete_id: "",
      category: this.categories,
      like_flg: false,
      relike_flg: false,
      decision_flg: false,
      all_pageNum: 1,
      like_pageNum: 1,
      relike_pageNum: 1,
      decision_pageNum: 1,
      
    };
  },
  props: [
    "detail_link",
    "edit_link",
    "delete_link",
    "u_id",
    "about",
    "rule",
    "legal",
    "privacy",
    "contact",
    "categories",
  ],

  methods: {
    axios(page,path){
       axios
        .get(path)
        .then((res) => {
          this.lists = res.data["page"];
          this.pageNum = res.data["all"];
          console.log(res.data['all']);
          
          this.pageNum.map((item, i) => {
            item["page_id"] = i + 1;
            item["click_flg"] = false;
            this.pageNum.push();
            if (item.page_id === page) {
              item.click_flg = true;
            }
          });
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    all() {
      //初期値。全て表示

      this.decision_flg = false;
      this.like_flg = false;
      this.relike_flg = false;

      const path = "/ajax/get_all/" + this.all_pageNum;
      this.axios(this.all_pageNum,path);
    },
    like() {
      //いいねした食材を表示

      this.relike_flg = false;
      this.like_flg = true;
      this.decision_flg = true;
      const path = "/ajax/get_like/" + this.like_pageNum;
     this.axios(this.like_pageNum,path);
    },
    re_like() {
      //いいねした食材を表示

      this.relike_flg = true;
      this.like_flg = false;
      this.decision_flg = false;
      const path = "/ajax/re_like/" + this.relike_pageNum;
      this.axios(this.relike_pageNum,path);
    },
    decision() {
      this.relike_flg = false;
      this.like_flg = false;
      this.decision_flg = true;
      const path = "/ajax/get_decision/" + this.decision_pageNum;
      this.axios(this.decision_pageNum,path);
    },
    modal_show(id) {
      //modal表示
      this.modal_flg = true;
      this.delete_id = id;
    },
    closeModal() {
      //modal閉じる
      this.modal_flg = false;
    },
    delete_food(id) {
      //削除する
      const path = "/ajax/delete_food/" + id;
      axios
        .post(path)
        .then((res) => {
          location.reload();
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    //ここから下ページング処理
    all_paging(id) {
      this.all_pageNum = id;
      this.all(this.all_pageNum);
      this.pageNum.map((item) => {
        if (item.page_id === this.all_pageNum) {
          item.click_flg = true;
          this.pageNum.push();
        } else {
          item.click_flg = false;
        }
      });
    },
    //paging触った時の処理
    like_paging(id) {
      this.like_pageNum = id;
      this.like();
    },
    relike_paging(id) {
      this.relike_pageNum = id;
      this.re_like();
    },
    decision_paging(id) {
      this.decision_pageNum = id;

      this.decision();
    },
    prev(){
      if(this.like_flg){
          if(this.like_pageNum === 1){
          return;
        }
        this.like_pageNum --;
        this.like();
      }else if(this.relike_flg){
          if(this.relike_pageNum === 1){
          return;
        }
        this.relike_pageNum --;
        this.re_like();
      }else if(this.decision_flg){
          if(this.decision_pageNum === 1){
          return;
        }
        this.decision_pageNum ++;
        this.like();
      }else{
        if(this.all_pageNum === 1){
          return;
        }
        this.all_pageNum --;
        this.all();

      }
      
    },
    next(){
       if(this.like_flg){
         if(this.like_pageNum === Math.ceil(this.pageNum.length / this.parPage)){
          return;
        }
        this.like_pageNum ++;
        this.like();
      }else if(this.relike_flg){
        if(this.relike_pageNum === Math.ceil(this.pageNum.length / this.parPage)){
          return;
        }
        this.relike_pageNum ++;
        this.re_like();
      }else if(this.decision_flg){
        if(this.decision_pageNum === Math.ceil(this.pageNum.length / this.parPage)){
          return;
        }
        this.decision_pageNum ++;
        this.decision();
      }else{
        if(this.all_pageNum === Math.ceil(this.pageNum.length / this.parPage)){
          return;
        }
        this.all_pageNum ++;
        this.all();
   
      }
      

    }
  },
  created() {},
  mounted() {
    this.all(this.all_pageNum);
  },
  computed: {
    getPage: function () {
      // console.log(this.pageNum);

      return this.pageNum.filter((item) => item.index <= this.getPage);
    },
    getPageCount: function () {
      return Math.ceil(this.lists.length / this.parPage);
    },
  },
};
</script>

