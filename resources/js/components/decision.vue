<template>
  <div>
    <button
      type="button"
      class="decision-btn w-50"
      @click="openModal"
      :class="{ decisioned: decision_flg }"
    >
      <span v-show="!decision_flg">成約済みにする</span>
      <span v-show="decision_flg">キャンセル</span>
    </button>
    <transition name="modal">
      <div class="modal-decision" v-if="modal_flg">
        <h3 v-if="!decision_flg">成約済みにしますか？</h3>
        <h3 v-if="decision_flg">決定を解除しますか？</h3>
          <img :src="'/images/hatena.png'" alt="" class="hatena">
        <div class="modal-btn">
          <button class="btn btn-primary" @click="closeModal">close</button>
          <button class="btn btn-success" @click="setDecision(food.id)">YES</button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: ["store", "food"],
  data: function () {
    return {
      decision_flg: this.food.decision_flg,
      modal_flg:false,
    };
  },
  computed: {},

  methods: {
    openModal(){
      this.modal_flg = true;
    },
    closeModal(){
      
      this.modal_flg = false;
    },
    setDecision: function (u_id, f_id) {
      this.decision_flg = !this.decision_flg;
      this.modal_flg = false;
      const id = u_id;
      const food_id = f_id;
      const array = ["/push_decision/", id, "/", food_id];
      const path = array.join("");
      axios
        .post(path)
        .then((res) => {
          console.log(res.data);
        })
        .catch(function (err) {
          console.log(err);
        });
    },
  },

  mounted() {
    console.log(this.store);
    console.log(this.food);
  },
};
</script>
