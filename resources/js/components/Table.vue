<template>
    <div class="w-full">
        <div v-if="columns" class="bg-white w-full min-w-full">
            <div class="flex flex-row justify-between items-baseline">
                <div class="p-3 pl-0">
                    <label class="mb-2 uppercase text-md text-blue p-3 pl-0" for="search">Search</label>
                    <input class="border py-2 px-3 text-grey-darkest rounded-lg border-grey-light" type="text"
                           id="search" v-model="searchTerm">
                </div>
                <div class="flex flex-row justify-center items-baseline">
                    <div class="p-3 flex flex-row justify-center items-baseline">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2 mr-2"
                               for="page-state">
                            Records
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"
                                    id="page-state" v-model="show">
                                <option>15</option>
                                <option>30</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <span class="font-hairline text-grey">Showing <span class="text-blue font-bold">{{ shown }}</span> of <span
                            class="font-bold">{{ source.length || 0}}</span></span>
                    <ul v-if="pagination"
                        class="pagination flex justify-between ml-4 mt-4 list-reset text-white font-bold">
                        <li><a href="#"
                               @click.prevent="(activePage != 1) ? activePage--:false"
                               :class="activePage == 1 ? 'text-grey-light cursor-not-allowed': 'text-blue-light'"
                               class="button bg-white border border-brown py-2 px-4 rounded opacity-85 no-underline">&lt;</a>
                            <a href="#"
                               @click.prevent="(activePage != pagination) ? activePage++:false"
                               :class="activePage == pagination ? 'text-grey-light cursor-not-allowed': 'text-blue-light'"
                               class="button bg-white border border-brown py-2 px-4 rounded opacity-85 no-underline">&gt;</a>
                        </li>
                    </ul>
                </div>
            </div>
            <table class="text-left w-full min-w-full border-l border-grey-light" style="border-collapse: collapse">
                <thead>
                <tr>
                    <template v-for="c in columns">
                        <th class="py-4 px-6 text-white bg-blue-dark font-sans font-medium uppercase text-sm border-b border-r border-blue-light">
                            <div class="flex justify-center items-center">
                                <a href="#" @click.prevent="setOrder(c)" class="text-white no-underline flex flex-row">{{beautify(c)}}
                                    <div class="flex flex-col w-1 ml-1"
                                         v-if="order.field == c || order.field == c.target">
                                        <i class="arrow ml-1 text-white"
                                           :class="order.direction === 'asc' ? 'down': 'up'"></i></div>

                                    <div class="flex flex-col w-1 ml-1" v-else>
                                        <i class="arrow-2  ml-1  up"></i>
                                        <i class="arrow-2  ml-1  down"></i>
                                    </div>
                                    <span v-if="c.tooltip" class="ml-4" v-tooltip="{content: c.tooltip}">&#9432;</span>
                                </a>
                            </div>
                        </th>
                    </template>
                </tr>
                </thead>
                <tbody>
                <template v-for="s in sourceFiltered">
                    <tr @click="selected(s)" :class="selectedRow == s ? highlight : 'hover:bg-blue-lightest'"
                        @dblclick="doubleClick(s)">
                        <td v-for="c in columns" class="py-4 px-6 border-b border-r border-grey-light relative">
                            <template v-if="columnImage(s, c)">
                                <div class="flex flex-col justify-center items-center">
                                    <img v-if="columnValue(s, c).hasOwnProperty('src')" :src="columnValue(s, c).src"
                                         class="w-12"/>
                                    <span v-if="columnValue(s, c).hasOwnProperty('text')"
                                          class="overlay text-xs shadow-inner text-white p-2 rounded">{{columnValue(s, c).text}}</span>
                                </div>
                            </template>
                            <template v-else>
                                <div class="flex justify-center items-center">{{columnValue(s, c)}}</div>
                            </template>

                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
        <div v-else>
            <span>You must supply a columns array in order to show the data</span>
        </div>
    </div>
</template>
<style scoped>
    .overlay {
        background-color: rgba(0, 0, 0, 0.8);
    }

    i.arrow {
        border: solid white;
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
    }

    i.arrow-2 {
        border: dashed rgba(112, 175, 255, 0.54);
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
    }

    .down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
    }

    .up {
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
    }
</style>
<script>
    export default {
        props: {
            source: {
                type: [Array, Object],
                required: true
            },
            columns: {
                type: Array,
                required: true
            },
            paginate: {
                default: true
            }
        },
        data() {
            return {
                pagination: false,
                searchTerm: '',
                activePage: 1,
                selectedRow: false,
                highlight: 'bg-blue-light text-white',
                order: {
                    field: '',
                    direction: 'asc'
                },
                show: 15
            }
        },
        mounted() {
            this.source_bkp = this.source;
        },
        computed: {
            shown() {
                let showFrom = 0;
                let showTo = 0;

                if (Object.keys(this.source).length) {
                    showFrom = 1 + (this.show * this.activePage) - this.show;
                    showTo = (this.show * this.activePage) > this.source.length ? this.source.length : this.show * this.activePage;
                }

                return showFrom + '-' + showTo;
            },
            sourceFiltered() {
                let filtered = [];

                this.pagination = false;
                let postSearch = this.search(this.searchTerm, this.source);
                let target = this.order.field;

                if (this.order.field != '') {
                    if (typeof this.order.field === 'object') {
                        target = this.order.field.target;
                    }
                    postSearch = _.orderBy(postSearch, [target], [this.order.direction]);
                }
                if ((postSearch.length > this.show) && this.paginate) {
                    this.pagination = Math.ceil(postSearch.length / this.show);

                    for (let i = this.show * (this.activePage - 1); i < (this.activePage * this.show); i++) {
                        if (i <= (postSearch.length - 1))
                            filtered.push(postSearch[i]);
                    }
                } else {
                    filtered = postSearch;
                }

                return filtered;
            }
        },
        methods: {
            search(needle, haystack) {
                // TODO: It searches in every column, but shouldn't it only search in the displayed columns instead of EVERY column ?
                let filtered = [];

                if (needle !== '') {
                    haystack.forEach((value) => {
                        let objetToArray = Object.values(value);

                        if (objetToArray.some(function (propertyVal) {
                            let str = String(propertyVal).toLocaleLowerCase();
                            return str.indexOf(needle.toLocaleLowerCase()) !== -1;
                        })) {
                            filtered.push(value);
                        }

                        objetToArray.forEach((v) => {
                            if (v !== null && typeof v === 'object') {
                                let daRecursive = this.search(needle, [v]);
                                if (daRecursive.length > 0 && !filtered.includes(value)) {
                                    filtered.push(value);
                                }
                            }
                        });
                    });
                } else {
                    filtered = haystack;
                }

                return filtered;
            },
            selected(v) {
                if (!this.selectedRow || this.selectedRow !== v) {
                    this.selectedRow = v;
                } else {
                    this.selectedRow = false;
                }

                this.$emit('selected', this.selectedRow);
            },
            doubleClick(v) {
                this.$emit('doubleClick', v);
            },
            beautify(v) {
                let beautyName = (v !== null && typeof v === 'object') ? v.name : v;
                let nodashes = beautyName.replace(/_/g, ' ');

                return nodashes.charAt(0).toUpperCase() + nodashes.slice(1);
            },
            columnValue(source, col) {
                let value;
                if (col !== null && typeof col === 'object') {
                    if (col.hasOwnProperty("targetFunction")) {
                        value = col.targetFunction(source);
                    } else {
                        value = _.get(source, col.target);
                    }
                } else {
                    value = source[col];
                }
                return value;
            },
            columnImage(source, col) {
                let value;
                if (col !== null && typeof col === 'object') {
                    if (col.hasOwnProperty("targetFunction")) {
                        value = col.targetFunction(source);
                    } else {
                        value = _.get(source, col.target);
                    }
                } else {
                    value = source[col];

                }
                if (value !== null && typeof value === 'object') {
                    return true;
                }
            },
            setOrder(col) {
                if (typeof col === 'object' && col.hasOwnProperty('target')) {
                    this.order.direction = (this.order.field == col.target) ? ((this.order.direction == 'asc') ? 'desc' : 'asc') : this.order.direction;
                    this.order.field = col.target;
                } else {
                    this.order.direction = (this.order.field == col) ? ((this.order.direction == 'asc') ? 'desc' : 'asc') : this.order.direction;
                    this.order.field = col;
                }
            }
        },
        watch: {
            searchTerm() {
                this.activePage = 1;
            },
        }
    }
</script>