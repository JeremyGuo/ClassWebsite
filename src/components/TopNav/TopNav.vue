<template>
  <header id="topNav">
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal">
      <el-menu-item index="1" @click="jumpTo('/')">10班</el-menu-item>
      <el-menu-item index="2" @click="jumpTo('/Activities')">活动</el-menu-item>
    </el-menu>
    <div class="line"></div>
  </header>
</template>

<script>
export default {
  name: 'TopNav',
  data () {
    return {
      activeIndex: this.$route.path === '/' ? '1' : '2'
    }
  },
  methods: {
    jumpTo: function (key) {
      if (this.$route.path === key) {
        return
      }
      this.$router.push(key)
    }
  }
}
</script>
