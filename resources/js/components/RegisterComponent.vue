<template>
    <input
        type="text"
        name="neme"
        placeholder="Username"
        v-model="username"
    /><br />
        <div class = "alert alert-danger" v-if="errors.username">
        {{ errors.username.join('. ') }}
    </div>
    <input
        type="text"
        name="neme"
        placeholder="Fullname"
        v-model="fullname"
    /><br />
        <div class = "alert alert-danger" v-if="errors.fullname">
        {{ errors.fullname.join('. ') }}
    </div>
    <input
        type="password"
        name="neme"
        placeholder="Password"
        v-model="password"
    /><br />
    <div class = "alert alert-danger" v-if="errors.password">
        {{ errors.password.join('. ') }}
    </div>
    <input type="file" name="file" id="avatar" /><br /><br />
        <div class = "alert alert-danger" v-if="errors.avatar">
        {{ errors.avatar.join('. ') }}
    </div>
    <button type="button" class="button big fit" @click="register">Зарегистрироваться</button>
</template>
<script>
import { register } from '@/routes';
import password from '@/routes/password';

export default {
    props: ['datasend', 'changeToken'],
    data() {
        return {
            username: null,
            password: null,
            fullname: null,
            errors: {},
        };
        
    },
    name: 'RegisterComponent',
    methods: {
        register() {

            let formdata = new FormData();
            if(this.username) formdata.append('username', this.username);
            if(this.fullname) formdata.append('fullname', this.fullname);
            if(this.password) formdata.append('password', this.password);
            let avatar = document.querySelector("#avatar");
            if(avatar.files[0]) {
                formdata.append('avatar', avatar.files[0]);
            }

            this.datasend("register", "POST", formdata)
                .then((result) =>  {
                    console.log(result);
                    if(result.errors) {
                        this.errors = result.errors;
                    }
                    if(result.token) {
                        this.changeToken(result.token);
                    }
                })
                // .catch((error) => console.error(error));
        },
    },
    
};
</script>
