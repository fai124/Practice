<template>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap" rel="stylesheet" />
<button class="back-button">
            <a href="" @click.prevent="changePage('CategoryPage')"><img class="back-icon"
                    src="/icons/corner-up-left0.svg" alt="back" /></a>
        </button>
    <div class="frame-4" v-if="serv">

        <div class="service-block">
            <h1 class="service-title">{{ serv.name }}</h1>
            <div class="service-content">
                <div class="service-image-placeholder">
                    <img class="service-main-img" :src="PUBLIC + serv.photo" alt="service image" />
                </div>
                <div class="service-description-bg">
                    <p class="service-description-text">{{ serv.content }}</p>
                </div>
            </div>
        </div>

        <div class="reviews-section">
            <div class="review-form-container">
                <div class="form-label">
                    <span class="form-label-text">Оставьте отзыв</span>
                    <span class="required-star">*</span>
                </div>
                <div class="input-with-button">
                    <div class="comment-input-field">
                        <img class="input-icon" src="/icons/user0.svg" alt="user" />
                        <input type="text" class="comment-input" placeholder="Комментарий" name="comment"
                            v-model="comment" />
                        
                        <div class="file-upload-wrapper">
                            <label class="file-upload-button">
                                <input type="file" name="images" multiple @change="addImages" style="display: none;" />
                                {{ images.length > 0 ? `📎 ${images.length} файл(а)` : ' Прикрепить фото' }}
                            </label>
                            <span v-if="images.length > 0" class="file-name">
                                ({{ images.length }}/3)
                            </span>
                        </div>
                        
                        <img class="close-icon" src="/icons/close0.svg" alt="clear" @click="comment = ''; images = [];" />
                    </div>
                    <button class="submit-button" type="button" @click="addComment">
                        <span class="submit-button-text">Отправить</span>
                    </button>
                </div>
                <div class="alert alert-danger" v-if="errors.comment">
                    {{ errors.comment.join('. ') }}
                </div>
            </div>

            <div class="user-comment" v-for="value in comments" :key="value.id">
                <div class="comment-avatar-group">
                    <img class="comment-avatar" :src="PUBLIC +
                        (value.user?.avatar || 'avatars/default.png')
                        " alt="avatar" />
                    <div class="comment-user-info">
                        <div class="comment-user-name">
                            {{ value.user?.fullname || 'Пользователь' }}
                        </div>
                        <div class="comment-user-email">
                            {{ value.user?.email || '' }}
                        </div>
                    </div>
                </div>
                
                <div v-if="value.photos && value.photos.length" class="photo-bubble">
                    <img v-for="(photo, index) in value.photos" :key="index"
                        :src="PUBLIC + photo.photo" alt="фото"
                        @click="openModal(PUBLIC + photo.photo)" />
                </div>
                
                <div class="comment-bubble">
                    {{ value.comment }}
                </div>
                
                <!-- Кнопки с иконками -->
                <div class="comment-actions-group">
                    <button class="comment-action-btn like-btn" @click.prevent="likeClick(value.id)">
                        <img class="heart-icon" src="/icons/heart0.svg" alt="like" />
                        <span>{{ value.likes_count }}</span>
                    </button>
                    
                    <button v-if="isAdmin || (userInfo && value.user_id === userInfo.id)" 
                        class="comment-action-btn delete-btn" @click.prevent="deleteComment(value.id)">
                        <span class="delete-icon"></span>
                        <span>Удалить</span>
                    </button>
                    
                    <button v-if="userInfo && value.user_id === userInfo.id"
                        class="comment-action-btn edit-btn" @click="editComment(value.id, value.comment)">
                        <img class="pencil-icon" src="/icons/pencil.png" alt="edit" />
                        <span>Редактировать</span>
                    </button>
                </div>
                
                <div v-if="isAdmin" class="admin-reply-section">
                    <div class="comment-input-field admin-reply-input">
                        <img class="input-icon" src="/icons/user0.svg" alt="user" />
                        <input type="text" class="comment-input" placeholder="Напишите ответ..."
                            v-model="replyTexts[value.id]" @keydown.enter="sendReply(value.id)" />
                        <img class="close-icon" src="/icons/close0.svg" alt="clear" @click="replyTexts[value.id] = ''" />
                    </div>
                    <button v-if="replyTexts[value.id]?.trim()" class="reply-button"
                        @click="sendReply(value.id)">
                        <span class="reply-button-text">Ответить</span>
                    </button>
                </div>
                
                <div class="admin-comment" v-for="reply in value.replies" :key="reply.id">
                    <div class="comment-avatar-group">
                        <img class="comment-avatar" :src="PUBLIC +
                            (reply.user?.avatar || 'avatars/default.png')
                            " alt="avatar" />
                        <div class="comment-user-info">
                            <div class="comment-user-name">
                                {{ reply.user?.fullname || 'Администратор' }}
                            </div>
                            <div class="comment-user-email">
                                {{ reply.user?.email || '' }}
                            </div>
                        </div>
                    </div>
                    <div class="comment-bubble reply-bubble">
                        {{ reply.comment }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для фото -->
    <div v-if="fullScreenImage" class="fullscreen-modal" @click="fullScreenImage = null">
        <img :src="fullScreenImage" class="fullscreen-image" @click.stop />
    </div>

    <!-- Модальное окно для редактирования -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="showEditModal = false">
        <div class="modal-container">
            <h3 class="modal-title">Редактировать комментарий</h3>
            <textarea v-model="editText" class="modal-textarea" rows="4"></textarea>
            <div class="modal-buttons">
                <button class="modal-cancel-btn" @click="showEditModal = false">Отмена</button>
                <button class="modal-save-btn" @click="saveEdit">Сохранить</button>
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
            userInfo: null,
            serv: null,
            comments: [],
            isAdmin: false,
            isLike: false,
            isAuth: localStorage.getItem('token') ? true : false,
            errors: {},
            comment: '',
            replyTexts: {},
            showEditModal: false,
            editId: null,
            editText: '',
            images: [],
            fullScreenImage: null
        };
    },
    mounted() {
        this.getServ();
        this.getUser();
    },
    methods: {
        openModal(src) {
            this.fullScreenImage = src;
        },
        addImages(e) {
            this.images = Array.from(e.target.files).slice(0, 3);
        },
        editComment(id, text) {
            this.editId = id;
            this.editText = text;
            this.showEditModal = true;
        },
        saveEdit() {
            let form = new FormData();
            form.append('comment', this.editText);

            this.datasend('comment/update/' + this.editId, 'POST', form).then(
                () => {
                    this.showEditModal = false;
                    this.getServ();
                },
            );
        },
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
        getUser() {
            this.datasend('user').then((res) => {
                this.userInfo = res;
            });
        },
        getServ() {
            this.datasend((this.isAuth ? 'servAuth/' : 'serv/') + this.pageId)
                .then((result) => {
                    this.serv = result.serv;
                    this.comments = result.comments || [];
                    this.isAdmin = result.isAdmin || false;
                    this.isLike = result.isLike || false;

                    this.replyTexts = {};
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

            this.images.forEach((image, index) => {
                formData.append(`photos[]`, image);
            });

            this.datasend('comment/' + this.pageId, 'POST', formData)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.comment = '';
                        this.images = [];
                        const fileInput = document.querySelector('input[type="file"]');
                        if (fileInput) fileInput.value = '';
                        this.errors = {};
                        this.getServ();
                    }
                })
                .catch((err) => {
                    console.error('Ошибка:', err);
                });
        },

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
                        this.replyTexts[parentId] = '';
                        this.getServ();
                    }
                })
                .catch((err) => {
                    console.error('Ошибка при отправке ответа:', err);
                });
        },

        deleteComment(commentId) {
            this.datasend('destroy/' + commentId, 'DELETE').then((result) => {
                console.log(result);
                this.getServ();
            });
        },
    },
};
</script>