import { createRouter, createWebHistory } from 'vue-router'
import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import BookView from "@/views/BookView.vue";
import BaseView from "@/views/BaseView.vue";
import HomeView from "@/views/HomeView.vue";
import AuthorView from "@/views/AuthorView.vue";
import ProfileView from "@/views/ProfileView.vue";
import OrderView from "@/views/OrderView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      components: {
        main_pages: BaseView
      },
      children: [
        {
          path: '',
          components: {
            base_content: HomeView,
          }
        },
        {
          path: '/book',
          components: {
            base_content: BookView
          }
        },
        {
          path: '/author',
          components: {
            base_content: AuthorView
          }
        },
        {
          path: '/profile',
          components: {
            base_content: ProfileView
          }
        },
      ]
    },
    {
      path: '/login',
      components: {
        main_pages: LoginView
      }
    },
    {
      path: '/register',
      components: {
        main_pages: RegisterView
      }
    },
    {
      path: '/order',
      components: {
        main_pages: OrderView
      }
    }
  ]
})

export default router
