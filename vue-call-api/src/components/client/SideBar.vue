<template>
    <div id="sidebar">
        <h3>CATEGORIES</h3>
        <div class="checklist categories">
            <ul v-for="cate in categories" :key="cate.id">
                <li><router-link :to="{ name: 'category', params: { slug: cate.slug } }">{{ cate.name }}</router-link></li>
            </ul>
        </div>

        <h3>COLORS</h3>
        <div class="checklist colors">
            <!-- <router-link :to="{ name: 'ProductDetail', params: { slug: product.slug } }"
              class="detail">Detail</router-link> -->
            <ul>
                <li v-for="color in leftColumnColors" :key="color.id">
                    <router-link :to="{ name: 'color', params: { slug: color.slug } }"><span
                            :style="{ background: color.name }"></span>{{
                                color.name }}
                    </router-link>
                </li>
            </ul>
            <ul>
                <li v-for="color in rightColumnColors" :key="color.id">
                    <router-link :to="{ name: 'color', params: { slug: color.slug } }"><span
                            :style="{ background: color.name }"></span>{{ color.name }}
                    </router-link>
                </li>
            </ul>
        </div>

        <h3>SIZES</h3>
        <div class="checklist sizes">
            <ul>
                <li v-for="size in leftColumnSizes" :key="size.id">
                    <router-link :to="{ name: 'size', params: { slug: size.slug } }"><span></span>{{
                        size.name }}</router-link>
                </li>
            </ul>

            <ul>
                <li v-for="size in rightColumnSizes" :key="size.id">
                    <router-link :to="{ name: 'size', params: { slug: size.slug } }"><span></span>{{
                        size.name }}</router-link>
                </li>
            </ul>
        </div>


    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: [],
            colors: [],
            sizes: [],
        };
    },
    methods: {
        fetchCategories() {
            axios.get('http://127.0.0.1:8000/api')
                .then(response => {
                    this.categories = response.data.categories.original.data.data;
                    // console.log(this.categories);
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });
        },
        fetchColors() {
            axios.get('http://127.0.0.1:8000/api')
                .then(response => {
                    this.colors = response.data.colors.original.data;

                })
        },
        featchSizes() {
            axios.get('http://127.0.0.1:8000/api')
                .then(response => {
                    this.sizes = response.data.sizes.original.data;
                    // console.log(this.sizes);
                })
        }
    },
    computed: {
        leftColumnColors() {
            return this.colors.filter((_, index) => index % 2 == 0);
        },
        rightColumnColors() {
            return this.colors.filter((_, index) => index % 2 !== 0)

        },
        // sizes
        leftColumnSizes() {
            return this.sizes.filter((_, index) => index % 2 == 0);
        },
        rightColumnSizes() {
            return this.sizes.filter((_, index) => index % 2 !== 0)

        },
    },
    mounted() {
        this.fetchCategories();
        this.fetchColors();
        this.featchSizes()
    },

}


</script>