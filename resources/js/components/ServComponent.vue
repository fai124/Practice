<template>
    <div class="card">
        <div class="card-image">
            <img :src="PUBLIC + serv.photo" alt="">
        </div>
        <div class="card-body">
            <div class="heading-badge">
                <h3 class="card-heading" @click.prevent="changePage('ServPage', serv.id)">{{ serv.name }}</h3>
            </div>
            <div class="card-buttons">
                <button class="card-button" @click.prevent="changePage('ServPage', serv.id)">
                    <span class="card-button-text" >Подробнее</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ServComponent',
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage', 'serv'],
};
</script>
