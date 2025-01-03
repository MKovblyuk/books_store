import AuthorsView from "@/views/admin/AuthorsView.vue";
import BooksView from "@/views/admin/BooksView.vue";
import CategoriesView from "@/views/admin/CategoriesView.vue";
import PublishersView from "@/views/admin/PublishersView.vue";
import ReviewsView from "@/views/admin/ReviewsView.vue";
import EditorView from "@/views/editor/EditorView.vue";

export default [
{
    path: '/editor',
    components: {
            managment_pages: EditorView
    },
    redirect: '/editor/books',
    children: [
        {
            path: 'books',
            components: {
                editor_content: BooksView
            }
        },
        {
            path: 'authors',
            components: {
                editor_content: AuthorsView
            }
        },
        {
            path: 'publishers',
            components: {
                editor_content: PublishersView
            }
        },
        {
            path: 'categories',
            components: {
                editor_content: CategoriesView
            }
        },
        {
            path: 'reviews',
            components: {
                editor_content: ReviewsView
            }
        },
    ]
}
];