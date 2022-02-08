<template>
  <div class="resipe-area">
    <div class="resipi-item" v-for="param in data" :key="param.id">
      <a class="resipi-img" :href="param.recipeUrl" target="_blank">
        <img :src="param.foodImageUrl" alt="param.recipeTitle 画像" />
      </a>
      <div class="resipe-text-area">
        <h3 class="resipi-text">{{ param.recipeTitle }}</h3>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["parent", "sub"],
  data: function () {
    return {
      parent_id: this.parent.api_id,
      sub_id: this.sub.api_id,
      message: "",
      url: "",
      resipeUrl: "",
      resipeTitle: "",
      resipeImg: "",
      resipeText: "",
      data: [],
    };
  },

  computed: {},
  methods: {},

  mounted() {
    // 生成したURL
    if(this.parent_id && this.sub_id){

   
    const array = [
      "https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426?applicationId=1033025725454249216&categoryId=",
      this.parent_id,
      "-",
      this.sub_id,
    ];
    const url = array.join("");

    const updateText = (data) => {
      this.data = data;

    };
  
    // API取得
    $.getJSON(url, (data) => {
      const recipes = data.result;
      updateText(recipes);
    });
   }
  },
};
</script>
