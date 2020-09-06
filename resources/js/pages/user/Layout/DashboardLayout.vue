<template>
<a-layout id="components-layout-demo-fixed-sider">
    <side-bar></side-bar>
    <a-layout :style="{ marginLeft: '200px' }">
        <a-layout-header :style="{ background: '#fff', padding: 0 }">
            <a-tooltip>
                <template slot="title">
                    Đăng xuất
                </template>
                <a-icon type="logout" class="logout-btn" @click="logout()" />
            </a-tooltip>
        </a-layout-header>
        <a-layout-content :style="{ margin: '24px 16px 0', overflow: 'initial' }">
            <div :style="{ padding: '24px', background: '#fff', textAlign: 'left' }">

                <dashboard-content> </dashboard-content>

            </div>
        </a-layout-content>
        <a-layout-footer :style="{ textAlign: 'center' }">
            Vocabulary Learining ©2020 Created with <a-icon type="heart"></a-icon>
        </a-layout-footer>
    </a-layout>
</a-layout>
</template>

<script>
import SideBar from './SideBar';
import DashboardContent from './Content.vue';
import AuthenticationUtils from '../../../common/AuthenticationUtils';

export default {
    components: {
        SideBar,
        DashboardContent
    },
    methods: {
        logout() {
            AuthenticationUtils.logout();
            this.$router.push({ path: '/login' });
        }
    },
}
</script>

<style>
#components-layout-demo-fixed-sider .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}

.logout-btn {
    float: right;
    margin-top: 20px;
    margin-right: 39px;
    font-size: 26px;
    cursor: pointer;
}
</style>
