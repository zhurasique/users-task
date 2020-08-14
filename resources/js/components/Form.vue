<template>
<!--    <div id="target" class="preloader"><img src="https://i.pinimg.com/originals/45/12/4d/45124d126d0f0b6d8f5c4d635d466246.gif" class="css-class" alt="alt text"></div>-->
    <div :class="{'loading': loading}">
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

        <div class="col-sm mt-3" id="subBtn">
            <button class="btn btn-block btn-success" @click="saveUser">SUBMIT USER</button>
        </div>

        <table class="table mt-4">
            <thead>
            <tr>
                <th scope="col" class="borderless">Name</th>
                <th scope="col" class="borderless">Email</th>
                <th scope="col" class="borderless">Country</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <th v-text="user.name"></th>
                <td v-text="user.email"></td>
                <td v-for="country in countries" :key="country.id" v-if="user.country_id === country.id" v-text="country.name"></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary" @click="editUser(user)">Edit</button>
                    <button class="btn btn-sm btn-danger" @click="deleteUser(user)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="row justify-content-center" id="pageBtn">
            <div class="col-sm-6 text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" v-if="current_page !== 1" @click="decCurrentPage">Previous</button>
                    <button class="btn btn-outline-secondary" v-text="current_page"></button>
                    <button type="button" class="btn btn-secondary" v-if="current_page !== last_page" @click="incCurrentPage">Next</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function(){
            return {
                country: '',
                countries: [],
                name: '',
                email: '',
                users: [],
                user_id: '',
                current_page: 1,
                last_page: '',
                loading: true
            }
        },
        mounted(){
            this.loadCountries();
            this.displayUser()
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

                if(this.user_id){
                    formData.append("_method", "PUT");

                    $.ajax({
                        url: "http://127.0.0.1:8000/api/users/" + this.user_id,
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(){
                            self.name = '';
                            self.email = '';
                            self.country = '';
                        }
                    });
                }else{
                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/users',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(){
                            self.name = '';
                            self.email = '';
                            self.country = '';
                        }
                    });
                }
            },

            displayUser: function (){
                this.users = [];
                $.ajax({
                    method: "get",
                    url: "http://127.0.0.1:8000/api/users?page=" + this.current_page
                })
                    .then( data => {
                        for(var i = 0; i < data['data'].length; i++){
                            this.users.push(data['data'][i]);
                        }

                        this.current_page = data['current_page'];
                        this.last_page = data['last_page'];
                        this.pageLoading();
                    }).
                catch( error => {
                    console.log(error);
                });
            },

            deleteUser: function (user){
                $.ajax({
                    method: "delete",
                    url: "http://127.0.0.1:8000/api/users/" + user.id
                })
                    .then( data => {
                        this.displayUser();
                    }).
                catch( error => {
                    console.log(error);
                });
            },

            editUser: function (user){
                this.user_id = user.id;
                this.name = user.name;
                this.email = user.email;
                for(let i = 0; i < this.countries.length; i++){
                    if(user.country_id === this.countries[i].id){
                        this.country = this.countries[i];
                    }
                }
            },

            incCurrentPage: function (){
                this.current_page++;
                this.displayUser()
            },

            decCurrentPage: function (){
                this.current_page--;
                this.displayUser();
            },

            pageLoading: function (){
                this.loading = false;
                document.getElementById("subBtn").style.display = "unset";
                document.getElementById("pageBtn").style.display = "flex";
            }
        }
    }
</script>
