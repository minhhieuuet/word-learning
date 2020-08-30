import Login from '@/pages/LoginPage.vue';

import AdminDashboardLayout from '@/pages/admin/Layout/DashboardLayout.vue'
import AdminDashboard from '@/pages/admin/Dashboard.vue';
import AdminStudent from '@/pages/admin/Student.vue';

import UserDashboardLayout from '@/pages/user/Layout/DashboardLayout.vue'
import UserDashboard from '@/pages/user/Dashboard.vue';
import UserProfile from '@/pages/user/UserProfile.vue';
import WordList from '@/pages/user/WordList.vue';
import Category from '@/pages/user/Category.vue';
import MemoryGame from '@/pages/user/MemoryGame.vue';
import MemoryGame2 from '@/pages/user/MemoryGame2.vue';
import Phrase from '@/pages/user/Phrase.vue';
import CategoryDetail from '@/pages/user/CategoryDetail.vue';
import GameList from '@/pages/user/GameList.vue';
import AboutMe from '@/pages/user/AboutMe.vue';

export default {
    mode: 'history',
    routes: [{
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/',
            component: UserDashboardLayout,
            redirect: '/',
            children: [{
                    path: '/',
                    name: 'Dashboard',
                    component: Category,
                },
                {
                    path: '/test',
                    name: 'Dashboard',
                    component: UserDashboard,
                },
                {
                    path: 'word-list',
                    name: 'WordList',
                    component: WordList,
                },
                {
                    path: 'games',
                    name: 'Game',
                    component: GameList,
                },
                {
                    path: 'me',
                    name: 'AboutMe',
                    component: AboutMe,
                    
                },
                {
                    path: 'category',
                    name: 'Category',
                    component: Category,
                }, {
                    path: 'category/phrase',
                    name: 'Phrase',
                    component: Phrase
                }, {
                    path: 'category/:id',
                    name: 'CategoryDetail',
                    component: CategoryDetail,
                    props: true
                },
                {
                    path: 'memory-game',
                    name: 'MemoryGame',
                    component: MemoryGame
                },
                {
                    path: 'memory-game2',
                    name: 'MemoryGame',
                    component: MemoryGame2
                }
            ]
        },
        {
            path: '/admin',
            component: AdminDashboardLayout,
            redirect: '/admin/dashboard',
            children: [{
                    path: 'dashboard',
                    name: 'Trang chủ',
                    component: AdminDashboard,
                    meta: {
                        requiresAdmin: true
                    }
                },
                {
                    path: 'student',
                    name: 'Sinh viên',
                    component: AdminStudent,
                    meta: {
                        requiresAdmin: true
                    }
                },
            ]
        }
    ]
}