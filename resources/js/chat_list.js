import axios from "axios";

const app8 = new Vue({
    el: '#mail',
    data: {
       lists:'',
       link:'',
       id:'',


    },
    computed: {
        selected() {
            return this.category;
        },
    },
    methods: {
      get_reserve(){
        console.log('click');
        
        const path = "/all_reserve_list";
        axios.get(path).then(res =>{
          this.lists = res.data['list'];
          this.link = res.data['link'];
          this.id = res.data['id'];
         
          
        })
      },
   
       
        },
        
      
    mounted() {
      this.get_reserve();
    },

});