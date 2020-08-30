<template>
<a-layout-sider :style="{ overflow: 'auto', height: '100vh', position: 'fixed', left: 0 }">
    <div class="logo" />
    <a-menu theme="dark" mode="vertical" @click="handleClick">

        <a-menu-item key="1">
            <a-icon type="book" />
            <span class="nav-text">Quản lý từ</span>
        </a-menu-item>
        <a-menu-item key="2">
            <a-icon type="sketch" />
            <span class="nav-text">Trò chơi</span>
        </a-menu-item>
        <a-menu-item key="3">
            <a-icon type="user" />
            <span class="nav-text">Tôi</span>
        </a-menu-item>
        <!-- <a-menu-item key="5">
            <a-icon type="cloud-o" />
            <span class="nav-text">nav 5</span>
        </a-menu-item>
        <a-menu-item key="6">
            <a-icon type="appstore-o" />
            <span class="nav-text">nav 6</span>
        </a-menu-item>
        <a-menu-item key="7">
            <a-icon type="team" />
            <span class="nav-text">nav 7</span>
        </a-menu-item>
        <a-menu-item key="8">
            <a-icon type="shop" />
            <span class="nav-text">nav 8</span>
        </a-menu-item> -->
    </a-menu>
</a-layout-sider>
</template>

<script>
export default {
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
        }
    },
}
</script>
