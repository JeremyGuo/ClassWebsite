<template>
  <header id="topNav">
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
      <el-menu-item index="1"><router-link to="/" style="text-decoration: none">10班</router-link></el-menu-item>
      <el-menu-item index="2"><router-link to="/Activities" style="text-decoration: none">活动</router-link></el-menu-item>
    </el-menu>
    <div class="line"></div>
  </header>
</template>

<script>
export default {
  name: 'TopNav',
  data () {
    return {
      activeIndex: '1'
    }
  }
}
</script>
