<template>
  <div id="activities">
    <el-container>
      <el-main>
        <el-col id="posts">
          <div v-for="post in posts" :key="post.id" style="margin-top: 10px">
            <blogpost :post="post"></blogpost>
          </div>
        </el-col>
      </el-main>
    </el-container>
  </div>
</template>

<script>
import BlogPostItem from '@/components/common/BlogPostItem'
export default {
  name: 'Activities',
  data () {
    return {
      posts: [
        {id: 1, title: '集体定向', img: '/static/posts/Img1.jpg', src: '/', time: '2021/2/10', abstract: '班级校内定向活动'},
        {id: 2, title: '圆明园', img: '/static/posts/Img2.jpg', src: '/', time: '2021/2/10', abstract: '圆明园游园活动'},
        {id: 3, title: '火锅&餐后活动', img: '/static/posts/Img3.jpg', src: '/', time: '2021/2/10', abstract: '期中后聚餐'},
        {id: 4, title: '送温暖', img: '/static/posts/Img4.jpg', src: '/', time: '2021/2/10', abstract: '团委组织送温暖活动'}
      ]
    }
  },
  components: {
    'blogpost': BlogPostItem
  }
}
</script>
