<template>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <div class="create-service-page">
        <div class="service-card">
            <!-- ИЗМЕНЕНО 1: AvatarComponent обёрнут в card-header -->
            <div class="card-header">
                <button class="back-button" aria-label="Назад">
                    <img src="/icons/corner-up-left0.svg" alt="" />
                </button>
            </div>
            <!-- ИЗМЕНЕНИЕ 1 КОНЧИЛОСЬ -->

            <h1 class="form-title">Создание услуги</h1>

            <form class="service-form">
                <div class="input-group">
                    <label class="form-label">Название</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Название услуги"
                        v-model="name"
                    />
                </div>
                <div class="alert alert-danger" v-if="errors.name">
                    {{ errors.name.join('. ') }}
                </div>

                <div class="input-group">
                    <label class="form-label">Описание</label>
                    <textarea
                        class="form-textarea"
                        placeholder="Описание услуги"
                        rows="3"
                        v-model="content"
                    ></textarea>
                </div>
                <div class="alert alert-danger" v-if="errors.content">
                {{ errors.content.join('. ') }}
            </div>

                <div class="input-group">
                    <label class="form-label">Фотография</label>
                    <input type="file" class="file-input" accept="image/*" id="photo"/>
                </div>
                <div class="alert alert-danger" v-if="errors.photo">
                {{ errors.photo.join('. ') }}
            </div>
            <div v-if = "pageId ">
            <img :src="PUBLIC + photo" alt=""/>
        </div>

                <button type="button" class="submit-btn" @click="servadd">Создать услугу</button>
            </form>

            <!-- ИЗМЕНЕНО 2: добавлены недостающие закрывающие div'ы -->
        </div>
    </div>
    <!-- ИЗМЕНЕНИЕ 2 КОНЧИЛОСЬ -->
</template>

<script>
export default {
    name: 'ServAddPage',
    props: ['datasend', 'changePage', 'pageId', 'PUBLIC'],
    data() {
        return {
            name: null,
            content: null,
            photo: null,
            errors: {},
        };
    },
    methods: {
        servadd() {
            let formdata = new FormData();
            if (this.name) formdata.append('name', this.name);
            if (this.content) formdata.append('content', this.content);
            let photo = document.querySelector('#photo');
            if (photo.files[0]) {
                formdata.append('photo', photo.files[0]);
            };
            this.datasend('servadd', 'POST', formdata).then((result) => {
                console.log(result);
                if (result.errors) {
                    this.errors = result.errors;
                }
                console.log(result);
                if (result.id) {
                    this.changePage('CategoryPage', result.id);
                }
            });
            //.catch((error) => console.error(error));
        },
        getServ() {
            this.datasend('serv/' + this.pageId).then((result) => {
                this.name = result.serv.name;
                this.content = result.serv.content;
                this.photo = result.serv.photo;
                console.log(result);
            });
        },
    },
    mounted() {
        if (this.pageId && this.pageId !== 'null') {
            this.getServ();
        }
    },
};
</script>
