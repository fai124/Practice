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
        <div class="rectangle-2"></div>

        <form class="frame-12" id="registration-form">
            <div class="input-form">
                <div class="label">
                    <div class="text">
                        <span class="label3">ФИО</span>
                    </div>
                </div>
                <div class="input-field">
                    <img class="input-icon" src="/icons/user0.svg" alt="user" />
                    <input
                        type="text"
                        class="input-text"
                        placeholder="ФИО пользователя"
                        name="fullname"
                        v-model="fullname"
                    />
                    <div class="alert alert-danger" v-if="errors.fullname">
                        {{ errors.fullname.join('. ') }}
                    </div>
                </div>
            </div>

            <div class="input-form">
                <div class="label">
                    <div class="text">
                        <span class="label3">Эл.Почта</span>
                    </div>
                </div>
                <div class="input-field">
                    <img
                        class="input-icon"
                        src="/icons/user0.svg"
                        alt="email"
                    />
                    <input
                        type="email"
                        class="input-text"
                        placeholder="user@mail.com"
                        name="email"
                        v-model="email"
                    />
                    <div class="alert alert-danger" v-if="errors.email">
                        {{ errors.email.join('. ') }}
                    </div>
                </div>
            </div>

            <div class="input-form">
                <div class="label">
                    <div class="text">
                        <span class="label3">Номер телефона</span>
                    </div>
                </div>
                <div class="input-field">
                    <img
                        class="input-icon"
                        src="/icons/phone0.svg"
                        alt="phone"
                    />
                    <input
                        type="tel"
                        class="input-text"
                        placeholder="+7(XXX)-XXX-XX-XX"
                        name="phone"
                        v-model="number"
                    />
                    <div class="alert alert-danger" v-if="errors.number">
                        {{ errors.number.join('. ') }}
                    </div>
                </div>
            </div>

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
                    <div class="alert alert-danger" v-if="errors.username">
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
                    <div class="alert alert-danger" v-if="errors.password">
                        {{ errors.password.join('. ') }}
                    </div>
                </div>
            </div>

            <div class="helper">
                Уже зарегистрированы?
                <a
                    href="#"
                    class="helper-link"
                    @click.prevent="changePage('AuthPage')"
                    >Авторизуйтесь</a
                >
            </div>

            <button type="button" class="button" @click="register">
                <span class="button-text">Регистрация</span>
            </button>
        </form>
    </div>
</template>
<script>
name: 'RegPage';
export default {
    props: [
        'datasend',
        'PUBLIC',
        'pageId',
        'changePage',
        'changeToken',
        'logout',
    ],
    data() {
        return {
            username: null,
            password: null,
            fullname: null,
            email: null,
            number: null,
            errors: {},
        };
    },
    methods: {
        register() {
            let formdata = new FormData();
            if (this.username) formdata.append('username', this.username);
            if (this.fullname) formdata.append('fullname', this.fullname);
            if (this.password) formdata.append('password', this.password);
            if (this.email) formdata.append('email', this.email);
            if (this.number) formdata.append('number', this.number);

            this.datasend('register', 'POST', formdata).then((result) => {
                console.log(result);
                if (result.errors) {
                    this.errors = result.errors;
                }
                if (result.token) {
                    this.changeToken(result.token);
                    this.changePage('CategoryPage');
                }
            });
        },
    },
};
</script>
