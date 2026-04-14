<template>
    <!-- Main -->
    <div id="main">
        <!-- Post -->

        <article class="post" v-if="post">
            <header>
                <div class="title">
                    <h2>
                        <a href="#">{{ post.name }}</a>
                    </h2>
                    <p>{{ post.subtitle }}</p>
                </div>
                <div class="meta">
                    <time class="published" datetime="2015-11-01"
                        >1 ноября 2015</time
                    >
                    <a href="#" @click.prevent="changePage('UserPage', post.user.id)" class="author"
                        ><span class="name">{{ post.user.username }}</span
                        ><img :src="PUBLIC + post.user.avatar" alt=""
                    /></a>
                </div>
            </header>
            <span class="image featured"
                ><img :src="PUBLIC + post.photo" alt=""
            /></span>
            <p></p>
            <p>
                {{ post.content }}
            </p>
            <footer>
                <ul class="stats">
                    <li v-if="isAdmin"><a href="#" @click.prevent="changePage('PostAdd', pageId)">Edit</a></li>
                    <li v-if="isAdmin"><a href="#" class="red" @click="deletePost">Delete</a></li>
                    <li v-if="isAdmin"><a href="#" class="red">Blocked</a></li>
                    <li><a href="#" @click.prevent="likeClick" class="icon fa-heart heart" :class="{liked: isLike}">{{ post.likes_count }}</a></li>
                    <li><a href="#commentblock" class="icon fa-comment">{{ post.comments_count }}</a></li>
                </ul>
            </footer>
        </article>

        <!-- Comments -->
        <div class="post" id="commentblock">
            <section class="comments">
                <h3>Comments</h3>
                <div v-if="isAuth">
                    <textarea v-model="comment"></textarea><br />
                    <div class="alert alert-danger" v-if="errors.comment">
                        {{ errors.comment.join('. ') }}
                    </div>
                    <button type="button" class="button big fit" @click="addComment">
                        Add Comment
                    </button>
                </div>
            </section>
            <article class="comment" v-for="value in comments">
                <div class="comment-autor">
                    <a href="#" @click.prevent="changePage('UserPage', value.user.id)"><img :src="PUBLIC + value.user.avatar" alt=""/></a>
                    <a href="#" @click.prevent="changePage('UserPage', value.user.id)">{{ value.user.username }}</a>
                </div>
                <p>
                    {{ value.comment }}
                </p>
            </article>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SinglePage',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage' ],
    data() {
        return {
            post: null,
            comments: [],
            isAdmin: false,
            isLike: false,
            isAuth: localStorage.getItem("token")?true:false,
            errors: {},
        };
    },
    mounted() {
        this.getPost();
    },
    methods: {
        likeClick(){
            if(!this.isAuth){
                alert("Авторизуйтесь");
            }
            this.datasend('like/'+ this.pageId).then((result) => {
                console.log(result.like_count);
                this.post.likes_count =result.like_count;
                this.post.isLike =result.isLike;
                this.isLike = !this.isLike;
            });
        },
        getPost() {
            this.datasend((this.isAuth?'postAuth/': 'post/') + this.pageId).then((result) => {
                this.post = result.post;
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
                        this.getPost();
                    }
                },
            );
        },
        deletePost() {
            this.datasend("destroy/" + this.pageId).then((result) => {
                console.log(result);
                this.changePage("HomePage");
            });
    },
}
};
</script>
