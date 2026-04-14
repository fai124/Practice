<template>
    <header id="header">
        <h1><a href="#" @click.prevent="changePage('HomePage')">Blog</a></h1>
        <nav class="main">
            <ul>
                <li class="menu user" v-if="userInfo.avatar">
                    <a href="#menu"
                        ><img :src="PUBLIC + userInfo.avatar" alt=""
                    /></a>
                </li>
                <li class="menu" v-else="userInfo.avatar">
                    <a class="fa-user" href="#menu"></a>
                </li>
            </ul>
        </nav>
    </header>
</template>
<script>
export default {
    name: 'HeaderComponent',
    props: ['userInfo', 'PUBLIC', "changePage"],
};
</script>
