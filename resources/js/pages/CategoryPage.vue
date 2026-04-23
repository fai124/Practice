<template>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <div class="frame-3">
        <!-- Аватар и информация пользователя -->
         <AvatarComponent :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
         <button class="create" @click.prevent="changePage('ServAddPage')"><span class="card-button-text">Создать</span></button>

        <!-- Заголовок "Категории" -->
        <h1 class="categories-title">Категории</h1>

        <!-- Линия-разделитель -->
        <div class="line-1"></div>

        <!-- Сетка карточек услуг -->
        <div class="cards-grid">
            <!-- Карточка 1 -->
             <ServComponent v-for="serv in servs.data" :serv="serv" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
        </div>

        <!-- Пагинация -->
        <div class="pagination">
            <button class="pagination-button" @click.prevent="getServ(page-1)" :class="{disabled: page === 1}">
                <img
                    class="arrow-icon"
                    src="/icons/arrow-left0.svg"
                    alt="back"
                />
                <span class="pagination-text">Назад</span>
            </button>
            <button class="pagination-button" @click.prevent="getServ(servs.current_page+1)" :class="{disabled: servs.current_page===servs.last_page}">
                <span class="pagination-text">Вперед</span>
                <img
                    class="arrow-icon"
                    src="/icons/arrow-right0.svg"
                    alt="forward"
                />
            </button>
        </div>
    </div>
</template>
<script>
import AvatarComponent from '@/components/AvatarComponent.vue';
import ServComponent from '@/components/ServComponent.vue';

export default {
    name: 'CategoryPage',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage'],
    components:{
      AvatarComponent,
      ServComponent,
    },
    data() {
        return {
            servs: [],
            page: 1,
            populars:[],
        };
    },
    mounted() {
            this.getServ();
    },
    methods: {
        getServ(page = 1) {
            this.datasend('servs?page=' + page)
            .then((result) => {
                this.servs = result.servs;
                this.page = result.current_page;
                this.populars = result.populars;
                console.log(result);
            });
        },
    },
};
</script>
