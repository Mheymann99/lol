<template>
    <div id="wrapper" class="flex h-screen bg-grey-lightest sm:flex-col md:flex-row font-light w-full">
        <div id="sidebar" class="bg-blue-darker md:w-64 overflow-y-auto sm:w-screen">
            <header class="flex justify-between items-center border-b border-blue-darkest pt-8 pb-8 pl-6 pr-6">
                <div id="logo">
                    <a href="#" class="no-underline text-white md:text-2xl sm:text-4xl font-bold">
                        <img src="#" width="120" alt="">
                        Webcard
                    </a>
                </div>
                <div id="collapse" class="text-white border border-white p-2 h-8 rounded">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
            </header>
            <ul id="menu" class="flex flex-col list-reset sm:hidden md:block">
                <li class="block">
                    <span class="no-underline text-white block h-full w-full border-b border-blue-darkest px-8 py-4">
                        Editor Dashboard
                    </span>
                </li>
                <li class="flex justify-between block bg-blue-darkest">
                    <a href="#"
                       class="no-underline text-white block h-full w-full border-b border-blue-darkest px-8 py-4 hover:shadow"
                       @mouseover="showAddress = !showAddress" @mouseout="showAddress = !showAddress">
                        <i class="fa fa-user mr-2" aria-hidden="true"></i>
                        Address
                        <transition name="fade">
                            <i class="far  float-right fa-plus-square" v-show="showAddress" aria-hidden="true"></i>
                        </transition>
                    </a>
                </li>
                <li class="flex justify-between block">
                    <a href="#"
                       class="no-underline text-white block h-full w-full border-b border-blue-darkest px-8 py-4 hover:shadow"
                       @mouseover="showMap = !showMap" @mouseout="showMap = !showMap">
                        <i class="fa fa-user mr-2" aria-hidden="true"></i>
                        Map
                        <transition name="fade">
                            <i class="far  float-right fa-plus-square" v-show="showMap" aria-hidden="true"></i>
                        </transition>
                    </a>
                </li>
            </ul>
        </div>
        <div id="right-pane" class="px-8 bg-transparent flex-grow flex-shrink flex-auto overflow-y-auto">
            <div id="info" class="border-b border-grey-light h-24">
                <div class="flex justify-between flex-grow items-center border-b h-24">
                    <div class="flex">
                        <ul class="flex list-reset text-black">
                            <li class="py-4 px-4">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            </li>
                            <li class="py-4 px-4">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </li>
                            <li class="flex items-center w-8 h-8 ml-8">
                                <a href="#" class="relative no-underline text-black">
                                    <i class="fa fa-list absolute pin-t pin-r" aria-hidden="true"></i>
                                    <span class="absolute rounded-full h-4 w-4 bg-blue text-xs text-center leading-tight text-white pin-b pin-l">2</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex">
                        <ul class="flex list-reset text-black">
                            <li class="px-4">
                                <span class="text-sm">
                                    <i class="fa fa-comments" aria-hidden="true"></i>
                                    Chat
                                </span>
                            </li>
                            <li class="border-l px-4">
                                <span class="text-sm">
                                    Log Out
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="content" class="px-8 bg-transparent flex-grow flex-shrink flex-auto">
                <div class="max-w-lg rounded overflow-hidden shadow-lg m-auto mt-8 ">
                    <div class="w-full bg-blue-darker text-white text-3xl p-6">
                        Add Address
                    </div>
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">Content here</div>
                        <p class="text-grey-darker text-base">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                        </p>
                    </div>
                    <div class="p-6">
                        <span class="float-right p-6"> footer actions here</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Application",
        data() {
            return {
                summoner: null,
                champion: null,
                show: false,
                load: false,
                background: null,
                splash: '',
                showAddress: false,
                showMap: false

            }
        },
        mounted() {
            if (this.$route.params.champion) {
                this.champion = this.$route.params.champion;
            } else {
                if (this.$route.params.summoner) {
                    this.changeSummoner(this.$route.params.summoner);
                }
            }
        },
        methods: {
            changeSummoner(val) {
                this.summoner = val;
                this.getSplash();
                this.$router.push('/summoner/' + this.summoner);
            },
            getData: function () {
                axios.get('/' + this.ranked + '/' + this.type + '/' + this.summoner).then((data) => {
                    console.log(data.data);
                    this.source = data.data.data;
                    this.fields = Object.keys(this.source[0]);
                });

            },
            getSplash: function () {
                if (this.$route.params.champion) {
                    axios.get('/champsplash/' + this.champion).then((data) => {
                        this.splash = data.data;
                    });
                } else {
                    if (this.$route.params.summoner) {
                        axios.get('/splash/' + this.summoner).then((data) => {
                            this.splash = data.data;
                        });
                    }
                }
            },
            loaded() {
                this.load = true;
                this.background = this.backgroundo;
            }
        },
        watch: {
            '$route.params.champion'() {
                this.champion = this.$route.params.champion;

            },
            $route(to, from) {
                this.getSplash();
            },
            champion: function () {
                this.getSplash();
            },
            splash: function () {
                this.load = false;
            }
        },
        computed: {
            backgroundo() {
                if (this.splash == '') {
                    return {backgroundImage: 'none'}
                } else {
                    return {backgroundImage: "url('" + this.splash + "')"}
                }
            }
        }
    }
</script>

<style scoped>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600");
    /* VARS */
    /* MIXINS */
    /* STYLE THE HTML ELEMENTS (INCLUDES RESETS FOR THE DEFAULT FIELDSET AND LEGEND STYLES) */
    body, html {
        margin: 0;
        padding: 1rem;
        box-sizing: border-box;
        width: 100%;
        height: 100%;
        font-size: 16px;
        font-family: "Open Sans", "Helvetica", sans-serif;
        -webkit-font-smoothing: antialiased;
        background-color: #EEE;
    }

    .backgroundo {
        background-image: none;
        background-position: center;
        background-size: cover;
        height: 100%;
        transition: background-image .4s ease-in-out;
    }

    fieldset {
        margin: 0;
        padding: 2rem;
        box-sizing: border-box;
        display: block;
        border: none;
        border: solid 1px #CCC;
        min-width: 0;
        background-color: #FFF;
    }

    fieldset legend {
        margin: 0 0 1.5rem;
        padding: 0;
        width: 100%;
        float: left;
        display: table;
        font-size: 1.5rem;
        line-height: 140%;
        font-weight: 600;
        color: #333;
    }

    fieldset legend + * {
        clear: both;
    }

    body:not(:-moz-handler-blocked) fieldset {
        display: table-cell;
    }

    /* TOGGLE STYLING */
    .toggle {
        margin: 0 0 1.5rem;
        box-sizing: border-box;
        font-size: 0;
        display: flex;
        flex-flow: row nowrap;
        justify-content: flex-start;
        align-items: stretch;
    }

    .toggle input {
        width: 0;
        height: 0;
        position: absolute;
        left: -9999px;
    }

    .toggle input + label {
        margin: 0;
        padding: .75rem 2rem;
        box-sizing: border-box;
        position: relative;
        display: inline-block;
        border: solid 1px #DDD;
        background-color: #FFF;
        font-size: 1rem;
        line-height: 140%;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 0 0 rgba(255, 255, 255, 0);
        transition: border-color .15s ease-out, color .25s ease-out, background-color .15s ease-out, box-shadow .15s ease-out;
        /* ADD THESE PROPERTIES TO SWITCH FROM AUTO WIDTH TO FULL WIDTH */
        /*flex: 0 0 50%; display: flex; justify-content: center; align-items: center;*/
        /* ----- */
    }

    .toggle input + label:first-of-type {
        border-radius: 6px 0 0 6px;
        border-right: none;
    }

    .toggle input + label:last-of-type {
        border-radius: 0 6px 6px 0;
        border-left: none;
    }

    .toggle input:hover + label {
        border-color: #b9b8c0;
    }

    .toggle input:checked + label {
        background-color: #4B9DEA;
        color: #FFF;
        box-shadow: 0 0 10px rgba(102, 179, 251, 0.5);
        border-color: #4B9DEA;
        z-index: 1;
    }

    .toggle input:focus + label {
        outline: dotted 1px #CCC;
        outline-offset: .45rem;
    }

    @media (max-width: 800px) {
        .toggle input + label {
            padding: .75rem .25rem;
            flex: 0 0 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

    /* STYLING FOR THE STATUS HELPER TEXT FOR THE DEMO */
    .status {
        margin: 0;
        font-size: 1rem;
        font-weight: 400;
    }

    .status span {
        font-weight: 600;
        color: #B6985A;
    }

    .status span:first-of-type {
        display: inline;
    }

    .status span:last-of-type {
        display: none;
    }

    @media (max-width: 800px) {
        .status span:first-of-type {
            display: none;
        }

        .status span:last-of-type {
            display: inline;
        }
    }
</style>