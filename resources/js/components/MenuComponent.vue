<template>
    <section id="menu">
        <!-- Actions -->
        <section>
            <ul class="actions vertical" v-if="!user">
                <li><h3>Login</h3></li>
                <AuthComponent :datasend="datasend" :changeToken="changeToken"/>

                <li><h3>Registration</h3></li>
                <li>
                    <RegisterComponent :datasend="datasend" :changeToken="changeToken"/>
                </li>
            </ul>
            <ul v-else>
                <li><a href="#" @click="changePage('PostAdd')">Добавить пост</a></li>
                <li><a href="#" @click="logout()">Выход</a></li>
            </ul>
        </section>
    </section>
</template>
<script>
import AuthComponent from './AuthComponent.vue';
import RegisterComponent from './RegisterComponent.vue'

export default {
    name: 'MenuComponent',
    components: {
        RegisterComponent,
        AuthComponent,
    },
    props: ["datasend", "changeToken", "user" , "changePage", "logout"]
};
</script>
