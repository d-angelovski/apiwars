<template>

    <div class="row">
        <high-score-item v-for="item in items" :key="item.name" :title="item.name" :api-title="item.api_title" :percent="item.percent" :votes="item.votes" :image="item.image"></high-score-item>
    </div>

</template>

<script>
    import HighScoreItem from './HighScoreItem.vue';
    export default {
        data: function () {
            return {
                items: window.items
            }
        },
        components: {
            'high-score-item': HighScoreItem
        },
        mounted() {
            console.log('HighScore mounted.')
        }
    }
</script>

<style>
</style>