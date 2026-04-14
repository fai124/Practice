<template>
    <div>
        <li>
            <input
                type="text"
                name="neme"
                placeholder="Username"
                v-model="username"
            /><br />
            <div class="alert alert-danger" v-if="errors.username">
                {{ errors.username.join('. ') }}
            </div>
            <input
                type="password"
                name="neme"
                placeholder="Password"
                v-model="password"
            /><br />
            <div class="alert alert-danger" v-if="errors.password">
                {{ errors.password.join('. ') }}
            </div>
            <input
                type="submit"
                class="button big fit"
                value="Log In"
                @click="auth"
            />
        </li>
    </div>
</template>
<script>
export default {
    name: 'AuthComponent',
    props: ['datasend', 'changeToken'],
    data() {
        return {
            username: null,
            password: null,
            errors: {},
        };
    },
    methods: {
        auth() {
            let formdata = new FormData();
            if (this.username) formdata.append('username', this.username);
            if (this.password) formdata.append('password', this.password);

            this.datasend('auth', 'POST', formdata).then((result) => {
                console.log(result);
                if (result.errors) {
                    this.errors = result.errors;
                }
                if (result.token) {
                    this.changeToken(result.token);
                }
            });
            // .catch((error) => console.error(error));
        },
    },
};
</script>
