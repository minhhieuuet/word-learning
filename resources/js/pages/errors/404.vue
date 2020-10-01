<template>
  <div style="text-align:center;padding-bottom: 20px;">
    <img src="/images/404.gif">
    <h2>Ơ! Đây là đâu ??</h2>
    <p><i>Lạc đường rồi bạn ơi, nhấn nút bên đưới để về nhà nhé !!!</i></p>
    <a-button size="large" icon="home" type="primary" @click="backToDashboard">
        Quay về
      </a-button>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  methods: {
    backToDashboard () {
      this.$router.push({ name: 'Dashboard' })
    }
  }
};
</script>