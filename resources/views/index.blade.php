
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>upqode</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
</head>

<body>
    <div class="container mt-3" id="form">
        <form>
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" id="name" name="name" class="form-control" placeholder="Alfred" required v-model="name">
            </div>

            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" name="email" class="form-control" placeholder="alfred.nobel@gmail.com" v-model="email">
            </div>

            <div class="form-group" id="country">
                <strong>Country:</strong>
                <select v-model="country" class="form-control">
                    <option v-for="country in countries" :key="country.id" v-bind:value="country" v-text="country.name"></option>
                </select>
            </div>
        </form>

        <div class="col-sm mt-3">
            <button class="btn btn-block btn-primary" @click="saveUser">SUBMIT USER</button>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script>
    let form = new Vue({
        el: "#form",
        data: function(){
            return {
                country: '',
                countries: [],
                name: '',
                email: ''
            }
        },

        methods: {
            loadCountries: function () {
                $.ajax({
                    method: "get",
                    url: "http://127.0.0.1:8000/api/countries"
                })
                    .then( data => {
                        for(var i = 0; i < data['data'].length; i++){
                            this.countries.push(data['data'][i]);
                        }

                        console.log();
                    }).
                catch( error => {
                    console.log(error);
                });
            },

            saveUser: function (){
                let formData = new FormData();
                formData.append("name", this.name);
                formData.append("email", this.email);
                formData.append("country_id", this.country.id);

                $.post( "http://127.0.0.1:8000/api/users",
                    formData,
                ).then(data => {
                    console.log(data);
                }).catch(error => {
                    console.log(error);
                });
            }
        },

        created: function() {
            this.loadCountries(this.countries);
        }
    });
</script>

</body>
</html>
