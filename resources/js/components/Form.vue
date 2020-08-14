<template>
    <div :class="{'loading': loading}">
        <div class="alert alert-success text-center" id="alert-success" role="alert">
            <p v-text="alert_text"></p>
        </div>
        <div class="alert alert-danger text-center" id="alert-danger" role="alert">
            <p v-text="alert_text"></p>
        </div>

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

    import axios from "axios"

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
                loading: true,
                alert_text: ''
            }
        },

        mounted(){
            this.loadCountries();
            this.displayUser()
        },

        methods: {
            loadCountries: function () {
                axios({
                    method: "get",
                    url: "http://127.0.0.1:8000/api/countries"
                })
                    .then( response => {
                        for(var i = 0; i < response.data['data'].length; i++){
                            this.countries.push(response.data['data'][i]);
                        }
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

                    axios({
                        url: "http://127.0.0.1:8000/api/users/" + this.user_id,
                        data: formData,
                        method: 'POST', // here must be PUT method, but my server can't make it, so we send name "_method" and value "PUT" in parameters
                    }).then( response => {
                        this.name = '';
                        this.email = '';
                        this.country = '';
                        this.displayUser();
                        this.showSuccessAlert("User has been edited!");
                    });
                }else{
                    axios({
                        url: 'http://127.0.0.1:8000/api/users',
                        data: formData,
                        method: 'POST',
                    }).then( response => {
                            this.name = '';
                            this.email = '';
                            this.country = '';
                            this.displayUser();
                            this.showSuccessAlert("User has been saved!");
                    });
                }
            },

            displayUser: function (){
                this.users = [];
                axios({
                    method: "get",
                    url: "http://127.0.0.1:8000/api/users?page=" + this.current_page
                })
                    .then( response => {
                        for(var i = 0; i < response.data['data'].length; i++){
                            this.users.push(response.data['data'][i]);
                        }

                        this.current_page = response.data['current_page'];
                        this.last_page = response.data['last_page'];
                        this.pageLoading();
                    }).
                catch( error => {
                    console.log(error);
                });
            },

            deleteUser: function (user){
                axios({
                    method: "delete",
                    url: "http://127.0.0.1:8000/api/users/" + user.id
                })
                    .then( response => {
                        this.displayUser();
                        this.showDangerAlert("User has been deleted!");
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
            },

            showDangerAlert: function (text){
                let alert = document.getElementById("alert-danger");
                alert.style.display = "unset";
                this.alert_text = text;

                setTimeout(function (){
                    alert.style.display = "none";
                },2000);
            },

            showSuccessAlert: function (text){
                let alert = document.getElementById("alert-success");
                alert.style.display = "unset";
                this.alert_text = text;

                setTimeout(function (){
                    alert.style.display = "none";
                },2000);
            },
        }
    }
</script>
