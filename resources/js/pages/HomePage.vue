<template>
    <!-- Main -->
    <div id="main">
        <!-- Post -->
        <PostComponent v-for="post in posts.data" :post="post" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>

        <!-- Pagination -->
        <ul class="actions pagination">
            <li>
                <a href="" @click.prevent="getPost(page-1)" :class="{disabled: page === 1}" class="button big previous"
                    >Previous Page</a
                >
            </li>
            <li><a href="#" @click.prevent="getPost(page+1)" :class="{disabled: posts.current_page===posts.last_page}" class="button big next">Next Page</a></li>
        </ul>
    </div>

    <!-- Sidebar -->
    <SideBarComponent :populars="populars" :changePage="changePage" :datasend="datasend" :PUBLIC="PUBLIC"/>
</template>
<script>
import { disable } from '@/routes/two-factor';
import PostComponent from '../components/PostComponent.vue';
import SideBarComponent from '../components/SideBarComponent.vue';

export default {
    name: 'HomePage',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage'],
    components: {
        PostComponent,
        SideBarComponent,
    },
    data() {
        return {
            posts: [],
            page: 1,
            populars:[],
        };
    },
    mounted() {
            this.getPost();
    },
    methods: {
        getPost(page = 1) {
            this.datasend('posts?page=' + page)
            .then((result) => {
                this.posts = result.posts;
                this.page = result.current_page;
                this.populars = result.populars;
                console.log(result);
            });
        },
    },
};
</script>
