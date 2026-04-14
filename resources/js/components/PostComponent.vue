<template>
<article class="post">
        <header>
            <div class="title">
                <h2><a href="#" @click.prevent="changePage('SinglePage', post.id)">{{ post.name }}</a></h2>
                <p>{{ post.subtitle }}</p>
            </div>
            <div class="meta">
                <time class="published" datetime="2015-11-01"
                    >1 Ноября 2015</time
                >
                <a href="#" class="author"
                    ><span class="name">{{ post.user.username }}</span
                    ><img src="images/avatar.jpg" alt=""
                /></a>
            </div>
        </header>
        <a href="#" class="image featured"
            ><img :src="PUBLIC + post.photo" alt=""
        /></a>
        <p>
            {{ post.content }}
        </p>
        <footer>
            <ul class="actions">
                <li><a href="#" @click.prevent="changePage('SinglePage', post.id)" class="button big">Continue Reading</a></li>
            </ul>
            <ul class="stats">
                <li><a href="#" @click.prevent="changePage('SinglePage', post.id)" class="icon fa-heart">{{ post.likes_count }}</a></li>
                <li><a href="#" class="icon fa-comment">{{ post.comments_count }}</a></li>
            </ul>
        </footer>
    </article>
</template>
<script>
export default {
    name: 'PostComponent',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage', 'post'],

};
</script>