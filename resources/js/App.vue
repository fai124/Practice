<template>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Header -->
        <HeaderComponent
            :userInfo="userInfo"
            :PUBLIC="PUBLIC"
            :changePage="changePage"
        />

        <!-- Menu -->
        <MenuComponent
            :logout="logout"
            :datasend="datasend"
            :user="user"
            :changeToken="changeToken"
            :changePage="changePage"
        />
        <HomePage v-if="page == 'HomePage'" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
        <PostAdd v-if="page == 'PostAdd'" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
        <SinglePage v-if="page == 'SinglePage'" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
        <UserPage v-if="page == 'UserPage'" :datasend="datasend" :changePage="changePage" :pageId="pageId" :PUBLIC="PUBLIC"/>
    </div>
    <FooterComponent />
</template>

<script>
import MenuComponent from './components/MenuComponent.vue';
import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import HomePage from './pages/HomePage.vue';
import PostAdd from './pages/PostAdd.vue';
import SinglePage from './pages/SinglePage.vue';
import UserPage from './pages/UserPage.vue';

export default {
    name: 'App',
    data() {
        return {
            page: localStorage.getItem('page')||'HomePage',
            pageId: localStorage.getItem('pageId')||null,
            API: 'http://127.0.0.1:8000/api/',
            PUBLIC: 'http://127.0.0.1:8000/storage/',
            user: false,
            userInfo: {},
        };
    },
    components: {
        MenuComponent,
        HeaderComponent,
        FooterComponent,
        HomePage,
        PostAdd,
        SinglePage,
        UserPage,
    },
    mounted() {
        if (localStorage.getItem('token')) {
            this.getUser();
        }
    },
    methods: {
        logout() {
            this.datasend('logout')
                .then((result) => {
                    if (result) {
                        localStorage.removeItem('token');
                        this.changePage('HomePage');
                        this.user = false;
                        this.userInfo = {};
                        console.log(result);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        changePage(page, pageId = null) {
            this.page = page;
           this.pageId = pageId;
           localStorage.setItem("page", page);
           localStorage.setItem("pageId", pageId);
           if(this.page == 'null'){
            localStorage.remove("pageId");
           }
        },
        getUser() {
            this.datasend('user')
                .then((response) => {
                    this.user = true;
                    this.userInfo = response;
                })
                .catch((error) => {
                    console.error(error);
                    localStorage.removeItem('token');
                });
        },
        async datasend(route, method = 'GET', formdata = null) {
            let myHeaders = new Headers();
            myHeaders.append('Accept', 'application/json');
            if (localStorage.getItem('token')) {
                myHeaders.append(
                    'Authorization',
                    'Bearer ' + localStorage.getItem('token'),
                );
            }

            //let formdata = new FormData();
            //formdata.append('email', 'asd@student.com');

            let requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: 'follow',
            };

            if (method != 'GET') {
                requestOptions.body = formdata;
            }
            return await fetch(this.API + route, requestOptions).then(
                (response) => {
                    if(response.status == 401){
                         localStorage.removeItem('token');
                         this.changePage('HomePage');
                        this.user = false;
                        this.userInfo = {};
                    }
               return response.json();
                }
            );
        },
        changeToken(token) {
            localStorage.setItem('token', token);
            this.user = true;
            this.getUser();
        },
    },
};
//.then((result) => console.log(result))
//.catch((error) => console.error(error));
</script>
