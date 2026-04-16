<template>
    <div class="avatar-label-group">
          <a href="" @click.prevent="changePage('PersonalPage')">
            <img class="avatar" :src="PUBLIC +userInfo.avatar" alt="avatar">
            </a>
            <div class="text-and-supporting-text">
                <div class="avatar-name">{{ userInfo.fullname }}</div>
                <div class="avatar-email">{{ userInfo.email }}</div>
            </div>
        </div>
</template>
<script>
export default {
    name: 'AvatarComponent',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage',],
        data() {
      return {
        userInfo: {},
      }
    },
    mounted(){
      this.getUserInfo();
    },
    methods: {
      getUserInfo() {
        this.datasend('user')
        .then((response) => {
          this.userInfo = response;
        })
        .catch((error) => {
          console.error(error);
        });
      }
    }

};
</script>