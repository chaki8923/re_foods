<template>
<div>
  <ul class="push-message" >
    <li v-for="list in lists" :key="list.id"> <a  :href="food_link.replace('/0/','/' + list.food_id + '/')"  >
   <span v-if="list.id" >{{list.store_name}}から{{message}}</span>
  </a></li>
  </ul>
  <transition name="like-ivent">
  <div v-if="like_flg" class="like-push"> 
    <a :href="detail_link.replace('/0','/' + detail_id)">
    <i
      class="fas fa-heart fa-3x like liked"></i>
    </a>
  </div>
  </transition>
 
</div>
</template>

<script>
export default {
  props: [
    'food_link',
    'stores',
    'my_food_id',
    'detail_link'
  ],
  data: function () {
    return {
      push_flg:false,
      message:'新着メッセージがあります',
      val:'',
      store_name:'',
      link:this.food_link,
      lists:[],
      list:'',
      like_flg:false,
      detail_id:'',
      id:''
    
    };
  },
  computed: {
    },
  methods: {
    getMessage(){
       axios.get('/ajax/get_message').then(res => {
           this.lists.push(res.data[0]);
 
        

         }).catch(function(err){
           console.log(err);
           
         });
    },
    get_food_id(){
      this.detail_id = this.id;
      // console.log(this.detail_id);
      
    }
   
    
  },

  mounted() {
      Echo.channel("chat").listen("MessageCreated", (e) => {

        if(e['message']['new_flg'] == true){
          this.push_flg = true;
         
        }
        this.getMessage();
       
     });
      Echo.channel("chat").listen("LikeSignale", (e) => {
        
        this.id = e['like']['food_id'];
        this.get_food_id();
//my_food_idは自分が登録した食材のidが配列で入ってる
//いいね押した食材がそのidと同じならpush通知
        if(this.my_food_id){
          this.my_food_id.forEach(element => {
            if(element['id'] === e['like']['food_id']){
              this.like_flg = true;
              // console.log('いいね'); 
            }
          });
        }
        
        // console.log(this.my_food_id);
      
        
       
     });

    
  },
};
</script>
