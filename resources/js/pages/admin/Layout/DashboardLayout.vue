<template>
<div class="wrapper">
    <notifications></notifications>

    <side-bar>
        <mobile-menu slot="content"></mobile-menu>
        <sidebar-link to="/admin/dashboard">
            <md-icon>dashboard</md-icon>
            <p>Trang chủ</p>
        </sidebar-link>
        <sidebar-link to="/admin/student">
            <md-icon>content_paste</md-icon>
            <p>người học</p>
        </sidebar-link>
        <sidebar-link to="/admin/store">
            <md-icon>store</md-icon>
            <p>Cửa hàng</p>
        </sidebar-link>
    </side-bar>

    <div class="main-panel">
        <top-navbar></top-navbar>

        <dashboard-content>

        </dashboard-content>

        <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
</div>
</template>

<style lang="scss">

</style>

<script>
import TopNavbar from './TopNavbar.vue'
import ContentFooter from './ContentFooter.vue'
import DashboardContent from './Content.vue'
import MobileMenu from '@/pages/admin/Layout/MobileMenu.vue'

export default {
    components: {
        TopNavbar,
        DashboardContent,
        ContentFooter,
        MobileMenu
    }
}
</script>
