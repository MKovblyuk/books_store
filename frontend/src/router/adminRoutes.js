import AdminView from "@/views/admin/AdminView.vue";
import AuthorsView from "@/views/admin/AuthorsView.vue";
import BooksView from "@/views/admin/BooksView.vue";
import CategoriesView from "@/views/admin/CategoriesView.vue";
import OrdersView from "@/views/admin/OrdersView.vue";
import PublishersView from "@/views/admin/PublishersView.vue";
import ReviewsView from "@/views/admin/ReviewsView.vue";
import UsersView from "@/views/admin/UsersView.vue";

export default [
{
    path: '/admin',
    components: {
            managment_pages: AdminView
    },
    children: [
        {
            path: 'users',
            components: {
                admin_content: UsersView
            }
        },
        {
            path: 'orders',
            components: {
                admin_content: OrdersView
            }
        },
        {
            path: 'books',
            components: {
                admin_content: BooksView
            }
        },
        {
            path: 'authors',
            components: {
                admin_content: AuthorsView
            }
        },
        {
            path: 'publishers',
            components: {
                admin_content: PublishersView
            }
        },
        {
            path: 'categories',
            components: {
                admin_content: CategoriesView
            }
        },
        {
            path: 'reviews',
            components: {
                admin_content: ReviewsView
            }
        },
    ]
}
];