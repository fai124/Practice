<template>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <div class="frame-4" v-if="serv">
        <!-- Шапка с аватаром пользователя -->
        <AvatarComponent
            :datasend="datasend"
            :changePage="changePage"
            :pageId="pageId"
            :PUBLIC="PUBLIC"
        />

        <!-- Основной блок с услугой -->
        <div class="service-block">
            <h1 class="service-title">{{ serv.name }}</h1>
            <div class="service-content">
                <div class="service-image-placeholder"></div>
                <img
                    class="service-main-img"
                    :src="PUBLIC + serv.photo"
                    alt="service image"
                />
                <div class="service-description-bg"></div>
                <p class="service-description-text">{{ serv.content }}</p>
            </div>
        </div>


        <!-- Блок с отзывами и формой -->
        <div class="reviews-section">
            <!-- Форма отправки отзыва -->
            <div class="review-form-container">
                <div class="form-label">
                    <span class="form-label-text">Оставьте отзыв</span>
                    <span class="required-star">*</span>
                </div>
                <div class="input-with-button">
                    <div class="comment-input-field">
                        <img
                            class="input-icon"
                            src="/icons/user0.svg"
                            alt="user"
                        />
                        <input
                            type="text"
                            class="comment-input"
                            placeholder="Комментарий"
                            name="comment"
                            v-model="comment"
                        />
                        <img
                            class="close-icon"
                            src="/icons/close0.svg"
                            alt="clear"
                        />
                        <div class="alert alert-danger" v-if="errors.comment">
                            {{ errors.comment.join('. ') }}
                        </div>
                    </div>
                    <button
                        class="submit-button"
                        type="button"
                        @click="addComment"
                    >
                        <span class="submit-button-text">отправить</span>
                    </button>
                </div>
            </div>

            <!-- Комментарий пользователя -->
            <div class="user-comment" v-for="value in comments" :key="value.id">
                <div class="comment-avatar-group">
                    <img
                        class="comment-avatar"
                        :src="
                            PUBLIC +
                            (value.user?.avatar || 'avatars/default.png')
                        "
                        alt="avatar"
                    />
                    <div class="comment-user-info">
                        <div class="comment-user-name">
                            {{ value.user?.fullname || 'Пользователь' }}
                        </div>
                        <div class="comment-user-email">
                            {{ value.user?.email || '' }}
                        </div>
                    </div>
                </div>
                <div class="comment-bubble">
                    {{ value.comment }}
                </div>
                 <!-- Блок лайков и ответа -->

            <div class="comment-actions">
                <button class="like-button" @click.prevent="likeClick">
                    <img
                        class="heart-icon"
                        src="/icons/heart0.svg"
                        alt="like"
                    />
                </button>
                <span class="likes-count">{{ serv.likes_count }}</span>

                <div class="comment-input-field" v-if="isAdmin">
                    <img class="input-icon" src="/icons/user0.svg" alt="user" />
                    <input
                        type="text"
                        class="comment-input"
                        placeholder="Ответ"
                        name=""
                    />
                    <img
                        class="close-icon"
                        src="/icons/close0.svg"
                        alt="clear"
                    />
                </div>

                <button class="reply-button" v-if="isAdmin">
                    <span class="reply-button-text">Ответить</span>
                </button>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
import AvatarComponent from '@/components/AvatarComponent.vue';

export default {
    name: 'SinglePage',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage'],
    components: {
        AvatarComponent,
    },
    data() {
        return {
            serv: null,
            comments: [],
            isAdmin: false,
            isLike: false,
            isAuth: localStorage.getItem('token') ? true : false,
            errors: {},
            comment: '',
        };
    },
    mounted() {
        this.getServ();
    },
    methods: {
        likeClick() {
            if (!this.isAuth) {
                alert('Авторизуйтесь');
            }
            this.datasend('like/' + this.pageId).then((result) => {
                console.log(result.like_count);
                this.serv.likes_count = result.like_count;
                this.serv.isLike = result.isLike;
                this.isLike = !this.isLike;
            });
        },
        getServ() {
            this.datasend(
                (this.isAuth ? 'servAuth/' : 'serv/') + this.pageId,
            ).then((result) => {
                this.serv = result.serv;
                this.comments = result.comments;
                this.isAdmin = result.isAdmin;
                this.isLike = result.isLike;
                console.log(result);
            });
        },
        addComment() {
            let formdata = new FormData();
            if (this.comment) formdata.append('comment', this.comment);
            this.datasend('comment/' + this.pageId, 'POST', formdata).then(
                (result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.comment = '';
                        this.getServ();
                    }
                },
            );
        },
        deletePost() {
            this.datasend('destroy/' + this.pageId).then((result) => {
                console.log(result);
                this.changePage('CategoryPage');
            });
        },
    },
};
</script>
