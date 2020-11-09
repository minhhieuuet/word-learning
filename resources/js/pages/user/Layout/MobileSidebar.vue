<template>
<a-drawer class="mobile-menu" title="Vocabulary Learning" placement="left" :closable="false" :visible="visible" :after-visible-change="afterVisibleChange" @close="onClose">
    <a-menu theme="light" :inline-collapsed="collapsed" @click="handleClick">
          <a-menu-item key="1" :class="{'ant-menu-item-selected': currentRouteName == 'Dashboard' }">
            <a-icon type="book" />
            <span class="nav-text">Quản lý từ</span>
        </a-menu-item>
        <!-- <a-menu-item key="2" :class="{'ant-menu-item-selected': currentRouteName == 'Game' }">
            <a-icon type="sketch" />
            <span class="nav-text">Trò chơi</span>
        </a-menu-item> -->
        <a-menu-item key="3" :class="{'ant-menu-item-selected': currentRouteName == 'Schedule' }">
            <a-icon type="schedule" />
            <span class="nav-text">Nhắc từ</span>
        </a-menu-item>
        <a-menu-item key="4" :class="{'ant-menu-item-selected': currentRouteName == 'Store' }">
            <a-icon type="shop" />
            <span class="nav-text">Cửa hàng</span>
        </a-menu-item>
        <!-- <a-menu-item key="5" :class="{'ant-menu-item-selected': currentRouteName == 'AboutMe' }">
            <a-icon type="user" />
            <span class="nav-text">Tôi</span>
        </a-menu-item> -->
    </a-menu>
</a-drawer>
</template>

<script>
export default {
    props: {
        visible: Boolean
    },
    data() {
        return {
            items: [{
                    key: 1,
                    routerName: 'Dashboard'
                },
                {
                    key: 2,
                    routerName: 'Game'
                },
                {
                    key: 3,
                    routerName: 'Schedule'
                },
                {
                    key: 4,
                    routerName: 'Store'
                },
                {
                    key: 5,
                    routerName: 'AboutMe'
                }
            ]
        }
    },
    methods: {
        handleClick(e) {
            this.$router.push({
                name: this.items[e.key - 1].routerName
            });
        },
        onClose() {
            this.visible = false;
        },
    },
}
</script>

<style lang="scss">
.mobile-menu {
    .ant-drawer-body {
        padding: 0px !important;
    }
}
</style>
<style lang="scss" scoped>
@media screen and (max-width: 900px) {
    .sidebar-pc {
        display: none;
    }
}
</style>
