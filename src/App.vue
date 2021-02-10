<template>
  <div id="app">
    <div class="top-nav">
      <top-nav></top-nav>
    </div>
    <div class="body-content">
      <router-view/>
    </div>
  </div>
</template>

<script>
import TopNav from '@/components/TopNav/TopNav'
export default {
  name: 'App',
  components: {
    'top-nav': TopNav
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
.top-nav {
  position: fixed;
  z-index: 1;
  top: 0;
  width: 100%;
}
.body-content {
  position: relative;
  z-index: 0;
  top: 65px;
}
</style>
