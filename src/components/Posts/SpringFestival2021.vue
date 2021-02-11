<template>
  <div class="content">
    <el-row>
        <div class='para-title'>
        <h2>国庆团建</h2>
        </div>
    </el-row>
    <el-row>
      <div class="para-content" id="para-content">
        <p>
          在静园草坪集合，领取任务卡
        </p>
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_1" :key="item.url"><!--路径名记得改hhhhhh-->
          <img :src="item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <p>
          神秘任务书！
        </p>
      <div class="para-content" id = "para-content">
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_2" :key="item.url"><!--路径名记得改hhhhhh-->
            <img :src="item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          穿梭在校园中~
        </p>
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_3" :key="item.url"><!--路径名记得改hhhhhh-->
            <img :src="item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          在石舫上玩传话游戏，从最开始的10句话，到最后只成功传达了不到一半
        </p>
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_4" :key="item.url"><!--路径名记得改hhhhhh-->
            <img :src="item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          回到静园草坪，进行最终关卡：你划我猜！
        </p>
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_5" :key="item.url"><!--路径名记得改hhhhhh-->
            <img :src="item.url"/>
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
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_6" :key="item.url"><!--路径名记得改hhhhhh-->
          <img :src="item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          休整之后，大部队从学校徒步到圆明园，秋游！不出所料，十一的圆明园人山人海，但同学们仍兴致勃勃，游览、划船不亦乐乎。
        </p>
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_7" :key="item.url"><!--路径名记得改hhhhhh-->
            <img :src="item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          划船的最终奥义——合成链表！（好活当赏）
        </p>
        <el-carousel trigger="click">
          <el-carousel-item v-for="item in imag_list_8" :key="item.url"><!--路径名记得改hhhhhh-->
            <img :src = "item.url"/>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <hr/>
    <el-row>
      <div class="para-title">
        <h2 class="para-title-text">锅边谈话</h2>
      </div>
    </el-row>
    <el-row style="margin-top:20px;">
      <div class="para-content">
        <el-carousel trigger="click" height="500px">
          <el-carousel-item v-for="item in imag_list_9" :key="item[1].url">
            <div>
              <img :src="item[1].url"/>
              <p>{{ item[0] }}</p>
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
        <el-carousel trigger="click" height="800px"> <!-- 注意这里的高度要小心调整，建议开F12，然后手动观察高度的最大值 -->
          <el-carousel-item v-for="item in imag_list_10" :key="item[1].url"><!--路径名记得改hhhhhh-->
            <div>
              <img height = 100% :src="item[1].url"/>
              <p>{{ item[0] }}</p>
            </div>
          </el-carousel-item>
        </el-carousel>
      </div>
    </el-row>
    <el-row>
      <div class="para-content">
        <p>
          本次整活实属仓促(狗头<br/>
          祝同学们在新的一年里学习进步<br/>
          在新的一年里找到更合适自己的学习方向<br/>
        </p>
      </div>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'SpringFestival2021',
  data () {
    return {
      imag_list_1: [
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2719.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2724.jpg' }
      ],
      imag_list_2: [
        { url: '/static/SpringFestival2021/photos/NationalDay/IMG_8613.JPG' },
        { url: '/static/SpringFestival2021/photos/NationalDay/image3.jpg' }
      ],
      imag_list_3: [
        { url: '/static/SpringFestival2021/photos/NationalDay/image4.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2742.jpg' }
      ],
      imag_list_4: [
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2754.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2765.jpg' }
      ],
      imag_list_5: [
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2848.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2858.jpg' }
      ],
      imag_list_6: [
        { url: '/static/SpringFestival2021/photos/NationalDay/image10.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/image11.jpg' }
      ],
      imag_list_7: [
        { url: '/static/SpringFestival2021/photos/NationalDay/class_photo_1.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/class_photo_2.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/class_photo_3.jpg' }
      ],
      imag_list_8: [
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2924.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2921.jpg' },
        { url: '/static/SpringFestival2021/photos/NationalDay/_DSC2919.jpg' }
      ],
      imag_list_9: [
        [
          '1202年12月20日，CSer与Pipelined-Lab的决战已近尾声.图班各路英雄聚首，解决战后资金的分配问题。此次集会秘密地在一家火锅店内举行，史称“（锅）炉边谈话”',
          {url: '/static/SpringFestival2021/photos/Eating/image1.jpg'}
        ],
        [
          '所有参会人员的重要影像资料',
          {url: '/static/SpringFestival2021/photos/Eating/image2.jpg'}
        ],
        [
          '会后组织了看电影和麻将联谊活动（猜猜有几个人/BOT在打麻将',
          {url: '/static/SpringFestival2021/photos/Eating/image6.jpg'}
        ]
      ],
      imag_list_10: [
        [
          '精挑细选.jpg',
          { url: '/static/SpringFestival2021/photos/warmnessDeliver/image1.jpg' }
        ],
        [
          '郭班好可爱\n"awsl"',
          { url: '/static/SpringFestival2021/photos/warmnessDeliver/image3.jpg' }
        ],
        [
          '男神阿炜',
          { url: '/static/SpringFestival2021/photos/warmnessDeliver/image4.jpg' }
        ],
        [
          '寝室送温暖-->概统送温暖-->绩点++ 温暖',
          { url: '/static/SpringFestival2021/photos/warmnessDeliver/image5.jpg' }
        ]
      ],
      screenWidth: 0
    }
  },
  methods: {
    setSize: function () {
      var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
      this.screenWidth = width
    }
  },
  mounted () {
    this.setSize()
    window.addEventListener('resize', this.setSize, false)
  }
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
    background-color: #ffffff;
}
.el-carousel__item:nth-child(2n+1) {
    background-color: #ffffff;
}
div.para-title {
  text-align: center;
  background: rgba(0, 0, 0, 0);
  border-width: 10px 15px 10px 15px;
  border-style: solid;
  border-image-slice: 50 100 50 100;
  border-image-source: url('/static/SpringFestival2021/borders/a.png');
}
p {
  text-align: center;
  background: rgba(0, 0, 0, 0);
  border-width: 15px 15px 15px 15px;
  border-style: solid;
  border-image-slice: 300 300 300 300;
  border-image-source: url('/static/SpringFestival2021/borders/c.png');
}
img {
  max-width: 100%;
  height: auto;
  display: inline-block;;
  margin: auto;
}
</style>
