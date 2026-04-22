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
            <!-- Форма отправки основного отзыва -->
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
                            @click="comment = ''"
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

            <!-- Список комментариев -->
            <div class="user-comment" v-for="value in comments" :key="value.id">
                <!-- Аватар и информация автора -->
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

                <!-- Текст комментария -->
                <div class="comment-bubble">
                    {{ value.comment }}
                </div>

                <!-- Лайки -->
                <div class="comment-actions">
                    <button
                        class="like-button"
                        @click.prevent="likeClick(value.id)"
                    >
                        <img
                            class="heart-icon"
                            src="/icons/heart0.svg"
                            alt="like"
                        />
                    </button>
                    <span class="likes-count">{{ value.likes_count }}</span>
                </div>

                <!-- Всегда видимое поле для ответа (только для админа) -->
                <div
                    class="comment-input-field admin-reply-input mt-2"
                    v-if="isAdmin"
                >
                    <img class="input-icon" src="/icons/user0.svg" alt="user" />
                    <input
                        type="text"
                        class="comment-input"
                        placeholder="Напишите ответ..."
                        v-model="replyTexts[value.id]"
                        @keydown.enter="sendReply(value.id)"
                    />
                    <img
                        class="close-icon"
                        src="/icons/close0.svg"
                        alt="clear"
                        @click="replyTexts[value.id] = ''"
                    />
                </div>

                <!-- Кнопка "Отправить ответ" (всегда видима, если админ) -->
                <button
                    v-if="isAdmin && replyTexts[value.id]?.trim()"
                    class="reply-button ml-2"
                    @click="sendReply(value.id)"
                >
                    <span class="reply-button-text">Отправить ответ</span>
                </button>

                <!-- Ответы (вложенные комментарии) -->
                <div
                    class="admin-comment mt-3"
                    v-for="reply in value.replies"
                    :key="reply.id"
                >
                    <div class="comment-avatar-group">
                        <img
                            class="comment-avatar"
                            :src="
                                PUBLIC +
                                (reply.user?.avatar || 'avatars/default.png')
                            "
                            alt="avatar"
                        />
                        <div class="comment-user-info">
                            <div class="comment-user-name">
                                {{ reply.user?.fullname || 'Пользователь' }}
                            </div>
                            <div class="comment-user-email">
                                {{ reply.user?.email || '' }}
                            </div>
                        </div>
                    </div>
                    <div class="comment-bubble">
                        {{ reply.comment }}
                    </div>
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
            // Теперь replyText — объект: { commentId: "текст" }
            replyTexts: {}, // Например: { 5: "Спасибо!", 7: "Принято" }
        };
    },
    mounted() {
        this.getServ();
    },
    methods: {
        likeClick(commentId) {
            if (!this.isAuth) {
                alert('Авторизуйтесь');
                return;
            }
            this.datasend('like/' + commentId, 'POST').then((result) => {
                const comment = this.comments.find((c) => c.id === commentId);
                if (comment) {
                    comment.likes_count = result.like_count;
                    comment.isLike = result.isLike;
                }
            });
        },

        getServ() {
            this.datasend((this.isAuth ? 'servAuth/' : 'serv/') + this.pageId)
                .then((result) => {
                    this.serv = result.serv;
                    this.comments = result.comments || [];
                    this.isAdmin = result.isAdmin || false;
                    this.isLike = result.isLike || false;

                    // Инициализируем replyTexts для каждого комментария
                    this.replyTexts = {}; // сбросим
                    this.comments.forEach((comment) => {
                        this.replyTexts[comment.id] = '';
                    });

                    console.log('[getServ] Результат:', result);
                })
                .catch((err) => {
                    console.error('Ошибка загрузки услуги:', err);
                });
        },

        addComment() {
            const text = this.comment?.trim();
            if (!text) {
                this.errors = { comment: ['Введите текст комментария'] };
                return;
            }

            let formData = new FormData();
            formData.append('comment', text);

            this.datasend('comment/' + this.pageId, 'POST', formData)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.comment = '';
                        this.errors = {};
                        this.getServ();
                    }
                })
                .catch((err) => {
                    console.error('Ошибка при отправке комментария:', err);
                });
        },

        // Отправка ответа
        sendReply(parentId) {
            const text = this.replyTexts[parentId]?.trim();
            if (!text) return;

            let formData = new FormData();
            formData.append('comment', text);
            formData.append('parent_id', parentId);

            this.datasend('comment/' + this.pageId, 'POST', formData)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.replyTexts[parentId] = ''; // Очищаем поле
                        this.getServ(); // Перезагружаем комментарии
                    }
                })
                .catch((err) => {
                    console.error('Ошибка при отправке ответа:', err);
                });
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

<style scoped>
.mt-2 {
    margin-top: 8px;
}

.ml-2 {
    margin-left: 8px;
}

.admin-reply-input {
    margin-top: 8px;
    margin-bottom: 8px;
}

.reply-button {
    font-size: 14px;
    padding: 6px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.reply-button:hover {
    background-color: #0056b3;
}
</style>
