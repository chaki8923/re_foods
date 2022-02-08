@extends('layouts.app')
<body>
    <div id="app">
        <input type="text" v-model="firstCode">&nbsp;-&nbsp;<input type="text" v-model="lastCode">
        <button type="button" @click="onClick">郵便番号検索</button>
        <hr>
        都道府県： <input type="text" v-model="prefecture">
        市区町村名： <input type="text" v-model="city">
        それ以降： <input type="text" v-model="address">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>

        new Vue({
            el: '#app',
            data: {
                firstCode: '',
                lastCode: '',
                prefecture: '',
                city: '',
                address: ''
            },
            methods: {
                onClick: function() {

                    const url = '/ajax/postal_search?'+ [
                        'first_code='+ this.firstCode,
                        'last_code='+ this.lastCode
                    ].join('&');

                    axios.get(url).then((response) => {

                        this.prefecture = response.data.prefecture;
                        this.city = response.data.city;
                        this.address = response.data.address;

                    });

                }
            }
        });

    </script>
</body>
</html>