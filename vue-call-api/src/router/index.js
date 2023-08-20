import { createRouter, createWebHistory } from 'vue-router'
import LayoutClient from '../layout/LayoutClient.vue'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: LayoutClient,
      children: [
        {
          path: '',
          name: 'home',
          component: HomeView // Trang home
        },
        {
          //category products
          path: 'san-pham/category/:slug',
          name: 'category',
          component: () => import('../views/product/byCategory.vue')
        },
        {
          //color products
          path: 'san-pham/color/:slug',
          name: 'color',
          component: () => import('../views/product/byColors.vue')
        },
        {
          //color products
          path: 'san-pham/size/:slug',
          name: 'size',
          component: () => import('../views/product/bySize.vue')
        },
        {
          // detail product
          path: '/san-pham/:slug',
          // path: '/:slug.html',
          name: 'ProductDetail',
          component: () => import('../views/product/detail.vue')
        }
      ]
    }
  ]
})

export default router
