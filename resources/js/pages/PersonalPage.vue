<template>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <div class="frame-5">
        <!-- Кнопка "Назад" -->
        <button class="back-button">
            <a href="" @click.prevent="changePage('CategoryPage')"
                ><img
                    class="back-icon"
                    src="/icons/corner-up-left0.svg"
                    alt="back"
            /></a>
        </button>

        <!-- Блок с аватаром -->
        <div class="avatar-section">
            <img
                class="profile-image"
                :src="PUBLIC + userInfo.avatar"
                alt="profile avatar"
            />
            <div class="profile-info">
                <h2 class="profile-name">{{ userInfo.fullname }}</h2>
                <div class="profile-email-row">
                    <span class="profile-email">{{ userInfo.email }}</span>
                </div>
            </div>
        </div>
        <input type="file" name="file" id="avatar" /><br /><br />
        <button class="exit-button" @click="logout()">
            <span class="confirm-button-text">Выйти</span>
        </button>

        <!-- Правая панель с формой и услугами -->
        <div class="profile-form-panel">
            <!-- Форма редактирования данных -->
            <div class="edit-form">
                <div class="input-group">
                    <div class="form-label">
                        <span class="form-label-text">ФИО</span>
                    </div>
                    <div class="form-input-field">
                        <img
                            class="input-icon"
                            src="/icons/user0.svg"
                            alt="user"
                        />
                        <input
                            type="text"
                            class="form-input"
                            placeholder="ФИО пользователя"
                            v-model="fullname"
                        />
                    </div>
                </div>

                <div class="input-group">
                    <div class="form-label">
                        <span class="form-label-text-alt">Эл.Почта</span>
                    </div>
                    <div class="form-input-field">
                        <img
                            class="input-icon"
                            src="/icons/user0.svg"
                            alt="email"
                        />
                        <input
                            type="email"
                            class="form-input"
                            placeholder="user@mail.com"
                            v-model="email"
                        />
                    </div>
                </div>

                <div class="input-group">
                    <div class="form-label">
                        <span class="form-label-text-alt">Номер телефона</span>
                    </div>
                    <div class="form-input-field">
                        <img
                            class="input-icon"
                            src="/icons/phone0.svg"
                            alt="phone"
                        />
                        <input
                            type="tel"
                            class="form-input"
                            placeholder="+7(XXX)-XXX-XX-XX"
                            v-model="number"
                        />
                    </div>
                </div>
                <br />
                <button class="confirm-button">
                    <span class="confirm-button-text" @click="useredit"
                        >Подтвердить</span
                    >
                </button>
            </div>

            <!-- Заголовок "Полученные услуги" -->
            <h3 class="services-title">Полученные услуги:</h3>

            <!-- Выпадающий список выбора услуги -->
            <div class="custom-select">
                <div class="select-trigger">
                    <div class="select-content">
                        <span class="select-placeholder">Выберете услугу</span>
                    </div>
                    <img
                        class="chevron-icon"
                        src="/icons/chevron-down0.svg"
                        alt="dropdown"
                    />
                </div>
            </div>

            <!-- Кнопка выбора даты -->
            <button class="date-button">
                <span class="date-button-text">Выберете дату услуги</span>
            </button>

            <!-- Карточка услуги -->
            <div class="service-card-wrapper">
                <div class="service-card-horizontal">
                    <div class="card-image">
                        <img
                            class="service-img"
                            src="/icons/rectangle-1740.png"
                            alt="service"
                        />
                    </div>
                    <div class="card-content">
                        <h4 class="service-card-title">Услуга</h4>
                        <div class="service-details">
                            <p class="service-description">
                                Профессиональный ремонт и обслуживание
                            </p>
                            <span class="service-time">14:00 - 15:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'PersonalPage',
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
            userInfo: {},
            fullname: '',
            email: '',
            number: '',
            errors: {},
        };
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        useredit() {
            let formdata = new FormData();
            if (this.fullname) formdata.append('fullname', this.fullname);
            if (this.email) formdata.append('email', this.email);
            if (this.number) formdata.append('number', this.number);
            let avatar = document.querySelector("#avatar");
            if(avatar.files[0]) {
                formdata.append('avatar', avatar.files[0]);
            }

            this.datasend('useredit', 'POST', formdata).then((result) => {
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
        getUserInfo() {
            this.datasend('user')
                .then((response) => {
                    this.userInfo = response;
                    this.fullname = response.fullname || '';
                    this.email = response.email || '';
                    this.number = response.number || '';
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>
