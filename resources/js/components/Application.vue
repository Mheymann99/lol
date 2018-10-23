<template>
    <div style="height: 100%">
        <nav class="bg-white h-12 shadow mb-8 px-6 md:px-0 fixed pin-t w-full z-50">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-center h-12">

                    <button class="inline-block select-none" @click="">
                        <span class="appearance-none flex items-center inline-block font-medium px-4 py-2 rounded"
                              :class="'bg-white text-blue'">
                                            <span class="mr-1">Lol Stats</span>
                                        </span>
                    </button>
                    <!-- Links Start -->
                    <div class="flex">
                        <ul class="list-reset flex border-l-2 border-grey-light ml-8 pl-4">


                            <!-- <li class="flex list-reset mx-6"  v-if="user.is_admin == true">
                                 <div class="relative">
                                     <button class="inline-block select-none" @click="dropdownClicked('administration')" v-on-clickaway="awayAdministration">
                                        <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-6 py-2 rounded" :class="dropdown.administration ? 'bg-blue text-white':'bg-white text-blue'">
                                             <span class="mr-1">Administration</span>
                                             <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                 <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                             </svg>
                                        </span>
                                     </button>
                                     <div class="absolute pin-l mt-px mx-1" v-show="dropdown.administration">
                                         <div class="bg-white shadow rounded border overflow-hidden w-32" @click="dropdownClicked('administration')">
                                             <router-link :to="{ name: 'blues' }" class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-blue whitespace-no-wrap">blues</router-link>
                                             <router-link :to="{ name: 'products' }" class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-blue whitespace-no-wrap">Products</router-link>
                                             <router-link :to="{ name: 'channels' }" class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-blue whitespace-no-wrap">Channels</router-link>
                                         </div>
                                     </div>
                                 </div>
                             </li>-->
                            <li class="flex list-reset mx-6">
                                <button class="inline-block select-none" @click="summoner =201418787">
                                       <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-4 py-2 rounded"
                                             :class="'bg-white text-blue'">
                                            <span class="mr-1">Alex</span>
                                        </span>
                                </button>
                            </li>
                            <li class="flex list-reset mx-6">
                                <button class="inline-block select-none" @click="summoner = 204615907">
                                       <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-4 py-2 rounded"
                                             :class="'bg-white text-blue'">
                                            <span class="mr-1">Tano</span>
                                        </span>
                                </button>
                            </li>
                            <li class="flex list-reset mx-6">
                                <button class="inline-block select-none" @click="summoner = 201423283">
                                       <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-4 py-2 rounded"
                                             :class="'bg-white text-blue'">
                                            <span class="mr-1">Bruno</span>
                                        </span>
                                </button>
                            </li>
                            <li class="flex list-reset mx-6">
                                <button class="inline-block select-none" @click="summoner = 204353170">
                                       <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-4 py-2 rounded"
                                             :class="'bg-white text-blue'">
                                            <span class="mr-1">Martin</span>
                                        </span>
                                </button>
                            </li>
                            <li class="flex list-reset mx-6">
                                <button class="inline-block select-none" @click="summoner = 200912346">
                                       <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-4 py-2 rounded"
                                             :class="'bg-white text-blue'">
                                            <span class="mr-1">Pabli</span>
                                        </span>
                                </button>
                            </li>
                            <li class="flex list-reset mx-6">
                                <button class="inline-block select-none" @click="summoner = 340840">
                                       <span class="appearance-none flex items-center inline-block font-medium hover:text-white hover:bg-blue px-4 py-2 rounded"
                                             :class="'bg-white text-blue'">
                                            <span class="mr-1">Leo</span>
                                        </span>
                                </button>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </nav>

        <div class="backgroundo" :style="backgroundo">
            <div class="pt-20 px-6 md:px-0 w-full" style="height: 100%; overflow-y: auto">
                <div class="p-4 w-full m-auto xxl:w-4/5 flex flex-col " v-if="source.length > 0">
                    <div class="flex flex-row justify-around">
                        <div class="toggle p-2 m-auto w-1/2">
                            <input type="radio" name="type" value="summoner" id="sizeWeight2" checked="checked"
                                   v-model="type"/>
                            <label for="sizeWeight2" class="text-grey-dark">Personal</label>
                            <input type="radio" name="type" value="opponent" id="sizeDimensions2" v-model="type"/>
                            <label for="sizeDimensions2" class="text-grey-dark">Opponent</label>
                        </div>
                        <div class="toggle p-2">
                            <input type="radio" name="sizeBy" value="normal" id="sizeWeight" checked="checked"
                                   v-model="ranked"/>
                            <label for="sizeWeight" class="text-grey-dark">Normal</label>
                            <input type="radio" name="sizeBy" value="ranked" id="sizeDimensions" v-model="ranked"/>
                            <label for="sizeDimensions" class="text-grey-dark">Ranked</label>
                        </div>
                    </div>
                    <div class="bg-white rounded border border-grey p-3">
                        <data-table :source="source" :columns="fields"></data-table>
                    </div>
                </div>
                <div class="p-4 w-3/4 m-auto flex flex-col" v-else>
                    <div class="p-3 text-3xl text-blue m-auto">
                        Select A Summoner!
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
                ranked: 'normal',
                source: [],
                fields: [],
                type: 'summoner',
                splash: ''

            }
        },
        methods: {
            getData: function () {
                axios.get('/' + this.ranked + '/' + this.type + '/' + this.summoner).then((data) => {
                    console.log(data.data);
                    this.source = data.data.data;
                    this.fields = Object.keys(this.source[0]);
                });

            },
            getSplash: function () {
                axios.get('/splash/' + this.summoner).then((data) => {
                    this.splash = data.data;
                });
            }
        },
        watch: {
            summoner: function () {
                this.getData();
                this.getSplash();
            },
            ranked: function () {
                this.getData();
            },
            type: function () {
                this.getData();
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