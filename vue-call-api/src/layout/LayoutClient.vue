


<template>
    <!-- partial:index.partial.html -->
    <div id="wrapper">
        <!-- <div class="cart-icon-top">
        </div>
        <div class="cart-icon-bottom">
        </div> -->
        <TheHeader />
        <router-view></router-view>

    </div>
    <TheFooter />
</template>
<script>

import TheFooter from '../components/client/Footer.vue'
import TheHeader from '../components/client/Header.vue'


export default {

    components: {
        TheHeader,
        TheFooter
    }
}
</script>