import { createRouter, createWebHistory } from 'vue-router'
import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import BookView from "@/views/BookView.vue";
import BaseView from "@/views/BaseView.vue";
import HomeView from "@/views/HomeView.vue";
import ProfileView from "@/views/ProfileView.vue";
import OrderView from "@/views/OrderView.vue";
import adminRoutes from './adminRoutes';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
	{
	  path: '/',
	  components: {
		main_pages: BaseView
	  },
	  redirect: 'home',
	  children: [
		{
			path: '1',
			components: {
				base_content: HomeView,
			},
			name: 'home'
		},
		{
		  path: ':page',
		  components: {
			base_content: HomeView,
		  }
		},
		{	
		  path: 'books/:page',
		  components: {
			base_content: HomeView,
		  }
		},
		{
		  path: 'book/:id',
		  components: {
			base_content: BookView
		  },
		  props: true,
		},
		{
		  path: 'profile',
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
	},
	...adminRoutes,
  ]
})

export default router
