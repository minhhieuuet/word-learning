<template>
<a-layout id="components-layout-demo-fixed-sider">
    <side-bar></side-bar>
    <MobileSideBar :visible="menuVisible" />
    <a-layout :style="{ marginLeft: '200px' }">
        <a-layout-header :style="{ background: '#fff', padding: 0 }">
            <div class="hamburger-icon" @click="menuVisible = !menuVisible">
                <a-icon type="menu" class="menu-btn" style="display: none;" />
            </div>
            <a-tooltip>
                <template slot="title">
                    Đăng xuất
                </template>
                <a-icon type="logout" class="logout-btn" @click="logout()" />
            </a-tooltip>
        </a-layout-header>
        <a-layout-content class="layout-content" :style="{ margin: '24px 16px 0', overflow: 'initial' }">
            <div class="dashboard-content" :style="{ padding: '24px', background: '#fff', textAlign: 'left' }">

                <dashboard-content> </dashboard-content>

            </div>
        </a-layout-content>
        <a-layout-footer :style="{ textAlign: 'center' }">
            Vocabulary Learning ©2020 Created with <a-icon type="heart"></a-icon>
        </a-layout-footer>
    </a-layout>
</a-layout>
</template>

<script>
import SideBar from './SideBar';
import MobileSideBar from './MobileSidebar';

import DashboardContent from './Content.vue';
import AuthenticationUtils from '../../../common/AuthenticationUtils';

export default {
    components: {
        SideBar,
        DashboardContent,
        MobileSideBar
    },
    data() {
        return {
            menuVisible: false,
        }
    },
    methods: {
        logout() {
            AuthenticationUtils.logout();
            this.$router.push({ path: '/login' });
        },
        showDrawer() {
            this.menuVisible = true;
        },
    },
}
</script>

<style lang="scss">
@media screen and (max-width: 900px) {
    .html {
        scroll-behavior: smooth;
    }

    .layout-content {
        margin: 0px 2px !important;
    }

    .v--modal-overlay {
        background-color: white !important;
    }

    .v--modal-box {
        /* height: 100vh !important; */
        top: 0px !important;
        bottom: 0px !important;
        padding: 20px !important;
        width: auto !important;
        right: 0px !important;
        left: 0px !important;
        overflow: scroll;
        box-shadow: none !important;

        .mobile-btn-group {
            display: block !important;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .pc-btn-group {
            display: none !important;
        }

        .close-button-mobile {
            display: block !important;
            right: 16px;
            top: 17px;
            position: fixed;
        }
    }

    .hamburger-icon {
        display: block !important;
        margin-left: -50px;
        position: absolute;
        width: 200px;
        height: 65px;

        i {
            padding: 2px;
            background-color: white;
            border-radius: 2%;
            width: 100px;
            height: 66px;
            position: absolute;
            margin-top: 0px;
            padding-top: 23px;
        }
    }

    .ant-layout {
        margin-left: 0px !important;
    }

    .ant-layout-footer {
        /* display: none; */
    }

    .login {
        position: absolute !important;
        bottom: 0px;
        top: 0px;
    }
}

.ant-popover {
    z-index: 100 !important;
}

.v--modal-box {
    .mobile-btn-group {
        display: none;
    }

    .close-button-mobile {
        display: none;
    }

}

.hamburger-icon {
    display: none;
}

.dashboard-content {
    padding: 0px !important;
}

.menu-btn {
    display: block !important;
    float: left;
    margin-top: 20px;
    margin-left: 39px;
    font-size: 26px;
    cursor: pointer;
}

.menu-btn {
    display: none;
}

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
