<template>
    <div id="main">
    <PostComponent v-for="post in posts" :post="post" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
    </div>
</template>
<script>
import PostComponent from '../components/PostComponent.vue';
export default {
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage'],
    name: 'UserPage',
    components: {
        PostComponent,
    },
    data() {
        return {
            posts: [],
        };
    },
    mounted() {
        if (this.pageId) {
            this.getPost();
        }
    },
    methods: {
        getPost() {
            this.datasend('user/' + this.pageId).then((result) => {
                this.posts = result;
                console.log(result);
            });
        },
    },
};
</script>
