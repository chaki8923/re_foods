<template>
<div>
  <h4 class="text-center mt-5 food-label">件名:{{food.food_name}}に関して</h4>
  <section  class="chat-space">
      <div
      v-for="data in words"
      :key="data.id"
      class="message"
      :class="[data.from_store == my_id ? 'right' : 'left']"
    >
    
      <img :src="myImg" alt="" class="pic" v-if="data.from_store == my_id"  />
     
      <img
        :src="pertnerImg"
        alt=""
        class="pic"
        v-if="data.from_store !== my_id"
       
      />
    
      <p
        class="comment"
        :class="[data.from_store == my_id ? 'right-triangle' : 'left-triangle']"
      >
        {{ data.body }}
      </p>
     
      <span :class="[data.from_store == my_id ? 'time-right' : 'time-left']">{{data.created_at.slice(-8)}}</span>
    </div>
    </section>
    <div class="message-input">
      <textarea name="message"
        v-model="message"
        cols="30"
        rows="10"
        class="textarea"
      ></textarea>
      <i class="fas fa-paper-plane plane fa-2x" @click="send()"></i>
    </div>
  </div>

</template>

<script>
export default {
  props: ["food_id", "messages", "mypic", "pertner","food","axios_path"],
  data: function () {
    return {
      message: "",
      words: [],
      positionId: "",
      myImg: this.mypic["store_image"],
      my_id: this.mypic["id"],
      pertner_id: this.pertner["id"],
      pertnerImg: this.pertner["store_image"],
    };
  },
  computed: {
    renderMessage() {
      return this.words;
    },
  },
  methods: {
    send() {
      const id = this.food_id;
      const kind = this.pertner_id;
      const array = ["/item_detail/", id, "/", kind, "/chat"];
      const path = array.join("");
      const params = { message: this.message };
      axios
        .post(this.axios_path, params)
        .then((res) => {
          this.message = "";

          // console.log(res.data["body"]);
          this.words.push(res.data);
        })
        .catch(function (err) {
          // console.log(err);
        });
    },
    getMessage() {
      const id = this.food_id;
      const kind = this.pertner_id;
      const array = ["/ajax/item_detail/", id, "/", kind, "/chat"];
      const path = array.join("");
      const params = { message: this.message };
      axios
        .get(path)
        .then((res) => {
          // console.log(res.data);
          
          // console.log('送り主:' + this.my_id);
          // console.log('送り相手:' + this.pertner_id);
          this.words = res.data;
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    position() {},
  },

  mounted() {
    this.getMessage();
    
    Echo.channel("chat").listen("MessageCreated", (e) => {
      // console.log("イベント発火");

      this.getMessage(); // 全メッセージを再読込
    });
  },
};
</script>
