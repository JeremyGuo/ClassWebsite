<template>
  <div class="content">
    <el-row>
      <div class="para-title">
        <h2 class="para-title-text">国庆团建</h2>
        <!-- <img class="para-title-border" src="a.jpg"/> TIP(naive): 修改 Display:absolute; 然后手动定位-->
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/a.jpg', '/static/2021/b.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
        <p>
          在静园草坪集合，领取任务卡
        </p>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/c.jpg', '/static/2021/c.1.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
        <p>
          神秘任务书！
        </p>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/d.jpg', '/static/2021/e.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
        <p>
          穿梭在校园中~
        </p>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/e.jpg', '/static/2021/f.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
        <p>
          在石舫上玩传话游戏，从最开始的10句话，到最后只成功传达了不到一半
        </p>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          回到静园草坪，进行最终关卡：你划我猜！
        </p>
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/g.jpg', '/static/2021/h.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
        <p>
          至今仍无法想出班长比划的是什么（狗头
        </p>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          中午静园草坪野餐：巨大的pizza+肥宅快乐奶茶，以及吃饱喝足后愉快的桌游！
        </p>
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/i.jpg', '/static/2021/j.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          休整之后，大部队从学校徒步到圆明园，秋游！不出所料，十一的圆明园人山人海，但同学们仍兴致勃勃，游览、划船不亦乐乎。<!--我觉得这段文字可以加个框来分段（你可以按需加）？？？-->
        </p>
        <el-carousel trigger="click" height="204px"> <!-- 注意这里的高度要小心调整 -->
          <el-carousel-item v-for="item in [['集体照*2', '/static/2021/k.jpg'], ['集体照*2', '/static/2021/l.jpg'], ['在圆明园划船（hua shui）', '/static/2021/m.jpg']]" :key="item[1]"><!--路径名记得改hhhhhh-->
            <div>
              <p>{{ item[0] }}</p>
              <h3 class="small">{{ item[1] }}</h3>
              <!-- <img :src="item"/> -->
            </div>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          划船的最终奥义——合成链表！（好活当赏）
        </p>
        <el-carousel trigger="click" height="150px">
          <el-carousel-item v-for="item in ['/static/2021/n.jpg', '/static/2021/o.jpg', '/static/2021/p.jpg', '/static/2021/q.jpg']" :key="item"><!--路径名记得改hhhhhh-->
            <h3 class="small">{{ item }}</h3>
            <!-- <img :src="item"/> -->
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <hr/>
    <el-row>
      <div class="para-title">
        <h2 class="para-title-text">锅边谈话</h2>
        <!-- <img class="para-title-border" src="a.jpg"/> TIP(naive): 修改 Display:absolute; 然后手动定位-->
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <el-carousel trigger="click" height="240px"> <!-- 注意这里的高度要小心调整，建议开F12，然后手动观察高度的最大值 -->
          <el-carousel-item v-for="item in [['1202年12月20日，CSer与Pipelined-Lab的决战已近尾声。图班各路英雄聚首，解决战后资金的分配问题。此次集会秘密地在一家火锅店内举行，史称“（锅）炉边谈话”。', '/static/2021/r.jpg'], ['所有参会人员的重要影像资料', '/static/2021/s.jpg'], ['会后组织了看电影和麻将联谊活动（猜猜有几个人/BOT在打麻将）', '/static/2021/t.jpg']]" :key="item[1]"><!--路径名记得改hhhhhh-->
            <div>
              <p>{{ item[0] }}</p>
              <h3 class="small">{{ item[1] }}</h3>
              <!-- <img :src="item"/> -->
            </div>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <hr/>
    <el-row>
      <div class="para-title">
        <h2 class="para-title-text">寝室送温暖</h2>
        <!-- <img class="para-title-border" src="a.jpg"/> TIP(naive): 修改 Display:absolute; 然后手动定位-->
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          “概统作业写了吗”<br/>
          嗯没错，这大概就是学期中后段大家生活的真实写照。<br/>
          “如此繁重的学业生活中，也不忘整活吗”<br/>
          “当然，问就是’This is the way.’ ”<br/>
          于是就开始了新班级的第一次刷楼活动<br/>
        </p>
        <el-carousel trigger="click" height="240px"> <!-- 注意这里的高度要小心调整，建议开F12，然后手动观察高度的最大值 -->
          <el-carousel-item v-for="item in [['精挑细选.jpg', '/static/2021/u.jpg'], ['', '/static/2021/v.jpg'], ['郭班好可爱\n“awsl”', '/static/2021/w.jpg'], ['男神阿炜', '/static/2021/x.jpg'], ['寝室送温暖-->概统送温暖-->绩点++ 温暖', '/static/2021/y.jpg']]" :key="item[1]"><!--路径名记得改hhhhhh-->
            <div>
              <p>{{ item[0] }}</p>
              <h3 class="small">{{ item[1] }}</h3>
              <!-- <img :src="item"/> -->
            </div>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'SpringFestival2021'
}
</script>

<style scoped>
.content {
  display: block;
}
.el-carousel__item h3 {
  color: #475669;
  font-size: 14px;
  opacity: 0.75;
  line-height: 150px;
  margin: 0;
}

.el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
}
</style>
