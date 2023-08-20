<template>
  <SideBar />
  <div id="grid">

    <div class="product" v-for="(product, index) in products" :key="product.id" :data-index="index">
      <div class="make3D" @mouseover="handleMouseOver(index)" @mouseleave="handleMouseLeave(index)">
        <div class="product-front">
          <div class="shadow"></div>
          <img :src="product.image" :alt="product.name" />
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" />
          <div class="image_overlay"></div>
          <div class="add_to_cart">
            <router-link :to="{ name: 'ProductDetail', params: { slug: product.slug } }"
              class="detail">Detail</router-link>
          </div>
          <div class="view_gallery">View gallery</div>
          <div class="stats">
            <div class="stats-container">
              <span class="product_price">${{ product.price }}</span>
              <span class="product_name">{{ product.name }}</span>
              <!-- <p>{{ product.desc }}</p> -->
              <div class="product-options">
                <strong>SIZES</strong>
                <span class="" v-for="size in product.sizes" :key="size.id"> {{ size.name }}</span>
                <strong>COLORS</strong>
                <div class="colors">
                  <div v-for="color in product.colors" :key="color.id" :class="getColorClass(color)">
                    <span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="product-back">
          <div class="shadow"></div>
          <div class="carousel">
            <ul class="carousel-container">
              <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" /></li>
              <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2.jpg" alt="" /></li>

            </ul>
            <div class="arrows-perspective">
              <div class="carouselPrev">
                <div class="y"></div>
                <div class="x"></div>
              </div>
              <div class="carouselNext">
                <div class="y"></div>
                <div class="x"></div>
              </div>
            </div>
          </div>
          <div class="flip-back">
            <div class="cy"></div>
            <div class="cx"></div>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>


<script>

import axios from 'axios';
import SideBar from "../components/client/SideBar.vue"
export default {
  name: 'home',
  components: {
    SideBar
  },
  data() {
    return {
      products: [],

    };
  },

  methods: {
    handleMouseOver(index) {
      const $product = $('.product').eq(index);
      $product.find('.make3D').addClass('animate');
      $product.find('div.carouselNext, div.carouselPrev').addClass('visible');
      $product.find('.view_gallery').click(function () {
        $product.find('div.carouselNext, div.carouselPrev').removeClass('visible')
        $product.find('.make3D').addClass('flip-10')
        setTimeout(function () {
          $product
            .find('.make3D')
            .removeClass('flip-10')
            .addClass('flip90')
            .find('div.shadow')
            .show()
            .fadeTo(80, 1, function () {
              $product.find('.product-front, .product-front div.shadow').hide()
            })
        }, 50)
      })
      $product
        .find('.flip-back')
        .click(function () {
          $product.find('.make3D').removeClass('flip180').addClass('flip190')
          setTimeout(function () {
            $product.find('.make3D').removeClass('flip190').addClass('flip90')

            $product
              .find('.product-back div.shadow')
              .css('opacity', 0)
              .fadeTo(100, 1, function () {
                $product.find('.product-back, .product-back div.shadow').hide()
                $product.find('.product-front, .product-front div.shadow').show()
              })
          }, 50)

          setTimeout(function () {
            $product.find('.make3D').removeClass('flip90').addClass('flip-10')
            $product.find('.product-front div.shadow').show().fadeTo(100, 0)
            setTimeout(function () {
              $product.find('.product-front div.shadow').hide()
              $product.find('.make3D').removeClass('flip-10').css('transition', '100ms ease-out')
              $product.find('.cx, .cy').removeClass('s1 s2 s3')
            }, 100)
          }, 150)
        })
    },
    handleMouseLeave(index) {

      const $product = $('.product').eq(index);
 
      $product.find('.make3D').removeClass('animate');
      $product.find('div.carouselNext, div.carouselPrev').removeClass('visible');


    },
    getColorClass(color) {
      return `c-${color.name.toLowerCase()}`;
    },
    fetchProducts() {
      axios.get('http://127.0.0.1:8000/api')
        .then(response => {
          this.products = response.data.products.original.data;
          // console.log(this.products);
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        });
    }
  },
  mounted() {
    this.fetchProducts();
  },
};
</script>


<style >
.detail {
  color: white;
  text-decoration: none;
}

.detail:hover {
  color: #5ff7d2;

}

.sizes {
  display: inline-block;
}
</style>