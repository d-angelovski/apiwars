<template>
    <div>
        <div class="container" v-if="fightFinished">
            <div class="row">
                <div class="col-xs-12">
                    <div class="jumbotron">
                        <h1>{{ items[0]['api_title'] }} fight</h1>
                        <p>Vote for one of the options. Winner goes further up!</p>
                    </div>
                </div>
            </div>



            <!-- Fight! -->
            <div class="row">
                <div class="col-xs-12 col-md-5">
                    <div class="tile-progress tile-primary vote-link" v-on:click="vote(items[0], items[1])">
                        <div class="tile-header">
                            <span class="pull-right" v-if="items[0].image"><img :src="items[0].image" class="img-responsive" /></span>
                            <h3>{{ items[0]['name'] }}</h3>
                            <span class="text-gray">{{ items[0]['api_title'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="text-center">
                        <h1><label class="text-pink">VS</label></h1>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="tile-progress tile-primary vote-link" v-on:click="vote(items[1], items[0])">
                        <div class="tile-header">
                            <span class="pull-right" v-if="items[1].image"><img :src="items[1].image" class="img-responsive" /></span>
                            <h3>{{ items[1]['name'] }}</h3>
                            <span class="text-gray">{{ items[1]['api_title'] }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- History -->
            <div class="row" v-if="voted">
                <div class="col-xs-12 col-md-12">
                    <div class="text-center">
                        <h1><label class="text-pink">Previous fight winner!</label></h1>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="tile-progress" v-bind:class="{ 'tile-purple': voted[0] == chosen }">
                        <div class="tile-header">
                            <span class="pull-right" v-if="voted[0].image"><img :src="voted[0].image" class="img-responsive" /></span>
                            <h3>{{ voted[0]['name'] }}</h3>
                            <span class="text-gray">{{ voted[0]['api_title'] }}</span><br/>
                            <span class="text-gray">{{ voted[0]['votes']  }} votes</span>
                        </div>
                        <div class="tile-progressbar">
                            <span :data-fill="{ firstVotedPercent }" :style="{width:  firstVotedPercent + '%' }"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="text-center">
                        <h1><label class="text-pink">VS</label></h1>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="tile-progress" v-bind:class="{ 'tile-purple': voted[1] == chosen }">
                        <div class="tile-header">
                            <span class="pull-right" v-if="voted[1].image"><img :src="voted[1].image" class="img-responsive" /></span>
                            <h3>{{ voted[1]['name'] }}</h3>
                            <span class="text-gray">{{ voted[1]['api_title'] }}</span><br/>
                            <span class="text-gray">{{ voted[1]['votes']  }} votes</span>
                        </div>
                        <div class="tile-progressbar">
                            <span :data-fill="{ secondVotedPercent }" :style="{width:  secondVotedPercent + '%' }"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" v-else>
            <div class="row">
                <div class="col-xs-12">
                    <div class="jumbotron">
                        <h1>Fight finised!</h1>
                        <p>You voted up for all api items, time to start new battle!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                items: window.items,
                voted: null,
                chosen: null
            }
        },
        methods: {
            vote: function (win, lost) {

                $('#cooking_loader').show();
                var vm = this;
                // get new fight
                axios.post('/json/play-random',{
                    endpoint: win['api_endpoint_id'],
                    win: win['name'],
                    lost: lost['name']
                }).then((response) => {
                    win['votes'] += 1;
                    lost['votes'] -= 1;
                    vm.chosen = win;
                    vm.voted = vm.items;
                    vm.items = response.data;
                    //vm.$forceUpdate();
                }).catch((response) => {
                    console.log(response);
                    alert('Error happend while voting!');
                }).then(() => {
                    $('#cooking_loader').fadeOut( 1000 );
                })
            }
        },
        computed: {
            firstVotedPercent: function () {
                var numOne = this.voted[0]['votes'] < 0 ? 0 : this.voted[0]['votes'];
                var numTwo = this.voted[1]['votes'] < 0 ? 0 : this.voted[1]['votes'];
                return numOne / (numOne + numTwo) * 100;
            },
            secondVotedPercent: function () {
                var numOne = this.voted[0]['votes'] < 0 ? 0 : this.voted[0]['votes'];
                var numTwo = this.voted[1]['votes'] < 0 ? 0 : this.voted[1]['votes'];
                return numTwo / (numOne + numTwo) * 100;
            },
            fightFinished: function () {
                console.log("fightFinished");
                return this.items[0] !== null && this.items[1] !== null;
            }
        },
        mounted() {
            console.log('ApiFight mounted.')
        }
    }
</script>

<style>

</style>