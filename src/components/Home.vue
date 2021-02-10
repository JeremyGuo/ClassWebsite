<template>
  <el-row justify="center" type="flex">
    <el-col :xs="24" :sm="24" :md="8" class="content">
      <my-content></my-content>
    </el-col>
  </el-row>
</template>

<script>
import SpringFestival2021 from '@/components/Posts/SpringFestival2021'
export default {
  name: 'Home',
  components: {
    'my-content': SpringFestival2021
  }
}
</script>

<style scoped>
</style>
