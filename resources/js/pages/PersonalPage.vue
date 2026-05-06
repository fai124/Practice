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
                @click="trigger"
                style="cursor: pointer;"
                
            />
            <div class="profile-info">
                <h2 class="profile-name">{{ userInfo.fullname }}</h2>
                <div class="profile-email-row">
                    <span class="profile-email">{{ userInfo.email }}</span>
                </div>
            </div>
        </div>
        <input type="file" name="file" id="avatar" style="display: none;" @change="useredit"/>
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

            <!-- Блок добавления услуги -->
            <div class="add-service-section">
                <h3 class="services-title">Добавить полученную услугу:</h3>

                <div class="input-group">
                    <div class="form-label">
                        <span class="form-label-text">Выберите услугу</span>
                    </div>
                    <div class="form-input-field">
                        <select v-model="selectedServiceId" class="form-input">
                            <option :value="null" disabled>
                                Выберите услугу
                            </option>
                            <option
                                v-for="service in availableServices"
                                :key="service.id"
                                :value="service.id"
                            >
                                {{ service.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <div class="form-label">
                        <span class="form-label-text">Дата получения</span>
                    </div>
                    <div class="form-input-field">
                        <input
                            type="date"
                            class="form-input"
                            v-model="serviceDate"
                        />
                    </div>
                </div>
                <br>
                <button class="confirm-button" @click="addServiceToUser">
                    <span class="confirm-button-text">Добавить услугу</span>
                </button>
            </div>

            <!-- Список услуг пользователя -->
            <h3 class="services-title" style="margin-top: 30px">
                Мои полученные услуги:
            </h3>

            <div v-if="myServices.length === 0" class="no-services">
                У вас пока нет добавленных услуг
            </div>

            <div
                v-for="service in myServices"
                :key="service.id"
                class="service-card-wrapper"
            >
                <div class="service-card-horizontal">
                    <div class="card-image">
                        <img
                            class="service-img"
                            :src="PUBLIC + service.photo"
                            alt="service"
                        />
                    </div>
                    <div class="card-content">
                        <h4 class="service-card-title">{{ service.name }}</h4>
                        <div class="service-details">
                            <p class="service-description">
                                {{ service.content }}
                            </p>
                            <p class="service-date">
                                <strong>Дата получения:</strong>
                                {{ formatDate(service.pivot.service_date) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { triggerRef } from 'vue';

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
            availableServices: [],
            selectedServiceId: null,
            serviceDate: '',
            myServices: [],
        };
    },
    mounted() {
        this.getUserInfo();
        this.loadAvailableServices();
        this.loadUserServices();
    },
    methods: {
        trigger(){
            document.querySelector('#avatar').click();
        },
        useredit() {
            let formdata = new FormData();
            if (this.fullname) formdata.append('fullname', this.fullname);
            if (this.email) formdata.append('email', this.email);
            if (this.number) formdata.append('number', this.number);
            let avatar = document.querySelector('#avatar');
            if (avatar.files[0]) {
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
        loadAvailableServices() {
            this.datasend('available-services')
                .then((response) => {
                    this.availableServices = response;
                })
        },

        loadUserServices() {
            this.datasend('my-services')
                .then((response) => {
                    this.myServices = response;
                })
        },

        addServiceToUser() {
            let formdata = new FormData();
            formdata.append('serv_id', this.selectedServiceId);
            formdata.append('service_date', this.serviceDate);

            this.datasend('add-service', 'POST', formdata)
                .then(() => {
                    this.selectedServiceId = null;
                    this.serviceDate = '';
                    this.loadUserServices();
                })
        },

        formatDate(date) {
            if (!date) return 'Не указана';
            try {
                return new Date(date).toLocaleDateString('ru-RU');
            } catch (e) {
                return 'Ошибка даты';
            }
        },
    },
};
</script>
