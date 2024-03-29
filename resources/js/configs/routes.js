import Login from '@/pages/LoginPage.vue';
import Register from '@/pages/RegisterPage.vue';

import AdminDashboardLayout from '@/pages/admin/Layout/DashboardLayout.vue'
import AdminDashboard from '@/pages/admin/Dashboard.vue';
import AdminStudent from '@/pages/admin/Student.vue';
import AdminStore from '@/pages/admin/Store.vue';


import UserDashboardLayout from '@/pages/user/Layout/DashboardLayout.vue'
import WordList from '@/pages/user/WordList.vue';
import Category from '@/pages/user/Category.vue';
import Phrase from '@/pages/user/Phrase.vue';
import CategoryDetail from '@/pages/user/CategoryDetail.vue';
import GameList from '@/pages/user/GameList.vue';
import AboutMe from '@/pages/user/AboutMe.vue';
import Game1 from '@/pages/user/game/Game1.vue';
import Game3 from '@/pages/user/game/Game3.vue';
import Schedule from '@/pages/user/Schedule.vue';
import Store from '@/pages/user/Store.vue';

import NotFound from '@/pages/errors/404.vue';

export default {
    mode: 'history',
    routes: [{
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/register',
            name: 'Register',
            component: Register
        },
        {
            path: '/admin',
            component: AdminDashboardLayout,
            redirect: '/admin/dashboard',
            children: [{
                    path: 'dashboard',
                    name: 'AdminDashboard',
                    component: AdminStudent,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'student',
                    name: 'Student',
                    component: AdminStudent,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'store',
                    name: 'AdminStore',
                    component: AdminStore,
                    meta: {
                        requiresAdmin: true
                    }
                },
            ]
        },
        {
            path: '/',
            component: UserDashboardLayout,
            redirect: '/',
            children: [{
                    path: '/',
                    name: 'Dashboard',
                    component: Category,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'word-list',
                    name: 'WordList',
                    component: WordList,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'games',
                    name: 'Game',
                    component: GameList,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'me',
                    name: 'AboutMe',
                    component: AboutMe,
                    meta: {
                        requiresAuth: true
                    }
                    
                },
                {
                    path: 'category',
                    name: 'Category',
                    component: Category,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'category/phrase',
                    name: 'Phrase',
                    component: Phrase,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'category/:slug',
                    name: 'CategoryDetail',
                    component: CategoryDetail,
                    props: true,
                    meta: {
                        requiresAuth: true
                    }
                }, {
                    path: 'schedule',
                    name: 'Schedule',
                    component: Schedule,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'store',
                    name: 'Store',
                    component: Store,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: '*',
                    name: '404',
                    component: NotFound,
                    meta: {
                        requiresAuth: true
                    }
                }
            ]
        }
    ]
}