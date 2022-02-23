<template>
  <div class="like-component" v-show="!food.decision_flg">
  <div class="like-area"> 
    <i
      class="fas fa-heart fa-2x like"
      :class="{ liked: this.click_flg }"
      @click="add_like"
    ></i>
    <span class="like-num" :class="{ liked: this.click_flg }">{{ like_number }}</span>
  </div>
  <div>
  <a v-show="likes.length > 0 && likes[0].to_store == user_id" :href="root" class="like-list" :class="{ liked: this.click_flg }" @click="go_list">気になるリスト</a>
  </div>
</div>
</template>

<script>
export default {
  props: ["food_id", "like_flg_check", "like_num", "like_one","root",'likes','user_id','food','like_list_link','axios_path'],
  data: function () {
    return {
      status: false,
      like_number: this.like_num,
      click_flg: false,
    };
  },
  computed: {
 
  },
  created() {
    if(this.like_one){
      this.click_flg = true;
    }
    
  },
  methods: {
    go_list() {
   
      axios.get(this.like_list_link).then(res => {
        
      }).catch(function(err){
        console.log(err);
        
      })
      

    },
    created() {
      this.like_check();
    },
   
    add_like() {
      this.click_flg = !this.click_flg;
      if (this.click_flg) {
        ++ this.like_number;
      } else {
        -- this.like_number;
      }
   
     
      axios
        .post(this.axios_path)
        .then((response) => {
          // this.like_check();
        })
        .catch(function (err) {
          console.log(err);
        });
    },
  },
  mounted() {
    // console.log(this.food_id);
    
     //イベントは発火した
       Echo.channel("chat").listen("LikeSignale", (e) => {
      // console.log("Likeイベント発火");
      // this.like_check();
    });

  },
};
</script>
