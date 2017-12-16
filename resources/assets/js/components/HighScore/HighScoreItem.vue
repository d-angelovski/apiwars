<template>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="tile-progress tile-primary">
            <div class="tile-header">
                <span class="pull-right" v-if="image"><img :src="image" class="img-responsive" /></span>
                <h3>{{ title }}</h3>

                <span class="text-gray">{{ apiTitle }}</span><br/>
                <span class="text-pink">{{ votes }} votes</span>
            </div>
            <div class="tile-progressbar">
                <span :data-fill="{ percent }" :style="{width:  percent + '%' }"></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'Default'
            },
            apiTitle: {
                type: String,
                default: 'Message'
            },
            percent: {
                type: Number,
                default: 0,
                validator: function (value) {
                    return value < 100 && value >= 0
                }
            },
            votes: {
                type: Number,
                default: 0
            },
            image: {
                type: String,
                default: ''
            }
        },
        mounted() {
            console.log('HighScoreItem mounted.')
        }
    }
</script>

<style>

</style>