<template>
  <div class="blogpost">
    <el-card :body-style="{ padding: '0px' }">
      <div style="float: left; width: 180px; height: 180px">
        <img :src="post.img" style="height: 180px; width:180px" class="leftImg" />
      </div>
      <div style="margin-left: 200px; padding: 10px">
        <el-link :href="post.src" target="_blank"><h4 style="font-size: 22px">{{post.title}}</h4></el-link>
        <p style="color: #444"><span>摘要：</span>{{post.abstract}}</p>
        <div class="bottom clearfix">
          <time class="time" style="font-size: 13px; color: #999">{{ post.time }}</time>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
export default {
  name: 'BlogPostItem',
  props: {
    post: {
      type: Object,
      required: true
    }
  }
}
</script>
