<template>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <div class="frame-1">
        <div class="rectangle-3"></div>

        <form class="frame-12" id="registration-form">
            <div class="input-form">
                <div class="label">
                    <div class="text">
                        <span class="label3">Логин</span>
                    </div>
                </div>
                <div class="input-field">
                    <img
                        class="input-icon"
                        src="/icons/user0.svg"
                        alt="login"
                    />
                    <input
                        type="text"
                        class="input-text"
                        placeholder="Логин"
                        name="login"
                        v-model="username"
                    />
                    <div class = "alert alert-danger" v-if="errors.username">
        {{ errors.username.join('. ') }}
    </div>
                </div>
            </div>

            <div class="input-form">
                <div class="label">
                    <div class="text">
                        <span class="label3">Пароль</span>
                    </div>
                </div>
                <div class="input-field">
                    <img
                        class="input-icon"
                        src="/icons/user0.svg"
                        alt="password"
                    />
                    <input
                        type="password"
                        class="input-text"
                        placeholder="Пароль"
                        name="password"
                        v-model="password"
                    />
                    <div class = "alert alert-danger" v-if="errors.password">
        {{ errors.password.join('. ') }}
    </div>
                </div>
            </div>

            <div class="helper">
                Еще не зарегистрированы?<a
                    href="#"
                    class="helper-link"
                    @click.prevent="changePage('RegPage')"
                    >Зарегистрируйтесь</a
                >
            </div>

            <button type="button" class="button" @click="auth">
                <span class="button-text">Авторизация</span>
            </button>
        </form>
    </div>
</template>
<script>
export default {
    name: 'AuthComponent',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage','changeToken'],
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
                    this.changePage('CategoryPage');
                }
            });
            // .catch((error) => console.error(error));
        },
    },
};
</script>
