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
         <a href="" @click.prevent="changePage('ServAddPage')">Создать</a>

        <!-- Заголовок "Категории" -->
        <h1 class="categories-title">Категории</h1>

        <!-- Линия-разделитель -->
        <div class="line-1"></div>

        <!-- Сетка карточек услуг -->
        <div class="cards-grid">
            <!-- Карточка 1 -->
            <div class="card">
                <div class="card-image"></div>
                <div class="card-body">
                    <div class="heading-badge">
                        <h3 class="card-heading">Услуга</h3>
                    </div>
                    <div class="card-buttons">
                        <button class="card-button">
                            <span class="card-button-text">Подробнее</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Карточка 2 -->
            <div class="card">
                <div class="card-image"></div>
                <div class="card-body">
                    <div class="heading-badge">
                        <h3 class="card-heading">Услуга</h3>
                    </div>
                    <div class="card-buttons">
                        <button class="card-button">
                            <span class="card-button-text">Подробнее</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Карточка 3 -->
            <div class="card">
                <div class="card-image"></div>
                <div class="card-body">
                    <div class="heading-badge">
                        <h3 class="card-heading">Услуга</h3>
                    </div>
                    <div class="card-buttons">
                        <button class="card-button">
                            <span class="card-button-text">Подробнее</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Карточка 4 -->
            <div class="card">
                <div class="card-image"></div>
                <div class="card-body">
                    <div class="heading-badge">
                        <h3 class="card-heading">Услуга</h3>
                    </div>
                    <div class="card-buttons">
                        <button class="card-button">
                            <span class="card-button-text">Подробнее</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Пагинация -->
        <div class="pagination">
            <button class="pagination-button">
                <img
                    class="arrow-icon"
                    src="/icons/arrow-left0.svg"
                    alt="back"
                />
                <span class="pagination-text">Назад</span>
            </button>
            <button class="pagination-button">
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

export default {
    name: 'CategoryPage',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage'],
    components:{
      AvatarComponent,
    },
};
</script>
