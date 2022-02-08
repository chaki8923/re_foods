require('./bootstrap');
window.Vue = require('vue');

$(function () {

    $('#pic1').on('click',function(){
        console.log('aaaa');
        
    })
    for (let i = 1; i <= 3; i++) {

        $(`.pic-preview${i}`).on('click', function () {
            
            $(`.input-file${i}`).click();

        });
        $(`.input-file${i}`).on('change', function (e) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $(`.js-preview${i}`).attr('src', e.target.result);
                $(`.js-preview${i}`).css('opacity', 1);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    }

    $('.image-clear').on('click', function (e) {
        e.stopPropagation();
        $(this).closest('.preview-area').prev('.file-area').val('');
        $(this).next().attr('src', '');
        $(this).next().css('opacity', 0);

    });


})


const app3 = new Vue({
    el: '#app',
    data: {
        all:[],
        beji: [],
        sub:this.beji,
        meet: [],
        fish: [],
        spice: [],
        egg: [],
        fruite: [],
        pan: [],
        drink: [],
        tool: [],
        sweet: [],
        soupe: [],
        cats: [],
        cat_id: "",
        category: [],
        word: "",
        message: "",
        messageClass: "",

    },
    computed: {
        selected() {
            return this.category;
        },
    },
    methods: {

        getCategory() {
            
            const array = ["/ajax/", "food_register"];
            const path = array.join("");
            axios
                .get(path)
                .then((res) => {

                    this.all = res.data['sub_categories'];
                    this.category = res.data['sub_categories'];
                    this.category = res.data['sub_categories'];
                    this.cats = res.data['categories'];
                    this.beji = res.data['beji'];
                    this.meet = res.data['meet'];
                    this.tool = res.data['tool'];
                    this.sweet = res.data['sweet'];
                    this.fish = res.data['fish'];
                    this.drink = res.data['drink'];
                    this.pan = res.data['pan'];
                    this.spice = res.data['spice'];
                    this.egg = res.data['egg'];
                    this.fruite = res.data['fruite'];
                    this.soupe = res.data['soupe'];            
                    const val = $('#category').val();
                    id = val;
        
            
                    switch (id) {
                        case "0":
                            console.log('0');
                            
                            this.category = this.all;
                            break;
                        case "1":
                            this.category = this.beji;
                            break;
                        case "2":
                            this.category = this.meet;
                            break;
                        case "3":
                            this.category = this.fish;
                            break;
                        case "4":
                            this.category = this.spice;
                            break;
                        case "5":
                            this.category = this.egg;
                            break;
                        case "6":
                            this.category = this.fruite;
                            break;
                        case "7":
                            this.category = this.pan;
                            break;
                        case "8":
                            this.category = this.drink;
                            break;
                        case "9":
                            this.category = '';
                            break;
                        case "10":
                            this.category = '';
                            break;
                        case "11":
                            this.category = this.sweet;
                            break;
                        case "12":
                            this.category = this.soupe;
                            break;
                        case "13":
                            this.category = this.tool;
                            break;
                        default: {
                            this.category = this.category;
                        }
                    }
            
            
                    return this.category;        
                })
                .catch(function (err) {
                    console.log(err);
                });
        },
        change(val) {//親セレクトBOX変えたら
            
            id = val.target.value;

            switch (id) {
                case "0":
                    console.log('0');
                    
                    this.category = this.all;
                    break;
                case "1":
                    this.category = this.beji;
                    break;
                    case "2":
                        
                    this.category = this.meet;
                    break;
                case "3":
                    this.category = this.fish;
                    break;
                case "4":
                    this.category = this.spice;
                    break;
                case "5":
                    this.category = this.egg;
                    break;
                case "6":
                    this.category = this.fruite;
                    break;
                case "7":
                    this.category = this.pan;
                    break;
                case "8":
                    this.category = this.drink;
                    break;
                case "9":
                    this.category = '';
                    break;
                case "10":
                    this.category = '';
                    break;
                case "11":
                    this.category = this.sweet;
                    break;
                case "12":
                    this.category = this.soupe;
                    break;
                case "13":
                    this.category = this.tool;
                    break;
                default: {
                    this.category = this.category;
                }
            }



            return this.category;
        },


        clearMessage() {
            this.message = "";
        },
    },
    mounted() {
        this.getCategory();
       
    },

});