<template>
    <el-menu
      :default-active="this.$route.path"
      class="el-menu-demo"
      mode="horizontal"
      background-color="#545c64"
      text-color="#fff"
      :router=true
      @select="handleSelect"
      active-text-color="#ffd04b">
        <el-menu-item index="/home">首页</el-menu-item>
        <el-menu-item index="/timeline">时间轴</el-menu-item>
        <el-menu-item index="/share">共享</el-menu-item>
        <el-submenu index="personal" style="float:right;" v-if="uinfo.id != 0">
            <template slot="title">{{uinfo.nickname}}</template>
            <el-menu-item index="/user">个人信息</el-menu-item>
            <el-submenu index="mailbox" v-if="messages.length != 0">
                <template slot="title">收件箱<el-badge class="mark" :value="messages.length" /></template>
                <el-card v-for="mess in messages" :key="mess.id">
                    <p><b>发件人:</b>{{mess.author.nickname}}</p>
                    <p>{{mess.content}}</p>
                    <div style="text-align: right; margin: 0">
                        <el-button v-for="option in JSON.parse(mess.choices)" type="primary" size="mini" @click="resp(mess.callback,option,mess.id,mess.need_backinfo)" :key="option">{{option}}</el-button>
                    </div>
                </el-card>
            </el-submenu>
            <el-menu-item index="/logout">退出登陆</el-menu-item>
        </el-submenu>
        <el-submenu index="" style="float:right;" v-else>
            <template slot="title">未登录</template>
            <el-menu-item index="/register">注册</el-menu-item>
            <el-menu-item index="/login">登陆</el-menu-item>
        </el-submenu>
        <el-dialog
          title="反馈内容"
          :visible.sync="dialogVisible"
          width="30%">
          <el-input
              type="textarea"
              :autosize="{ minRows: 2, maxRows: 4}"
              placeholder="请输入内容"
              v-model="callback_text">
            </el-input>
          <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible=false">取 消</el-button>
            <el-button type="primary" @click="dialogVisible=false;resp2();">确 定</el-button>
          </span>
        </el-dialog>
    </el-menu>
</template>

<script>
export default {
    name: 'NavbarMain',
    data: () => {
        return {
            messages: [],
            refreshing: false,
            dialogVisible: false,
            callback_text: '',
            current_callback: '',
            current_data: '',
            current_id: '',
        };
    },
    props: ["uinfo"],
    methods:{
        handleSelect(key) {
            if(key == "/logout")
                this.$emit('onUserInfoChanged', '');
        },
        isEmpty(v){
            return v == null || v == "";
        },
        refreshMessage(){
            if(this.refreshing || this.isEmpty(localStorage.getItem("jwt")))
                return ;
            this.refreshing = true;
            this.$requests.axios.get('/message/getList').then((res) => {
                if(res.status == 200){
                    this.messages = res.data;
                    console.log(this.messages);
                }else
                    this.$message.error('错误,无法载入消息列表')
                this.refreshing = false;
            }).catch((e) => {
                this.refreshing = false;
                console.log(e.toString());
            });
        },
        resp(callback, data, id, need_back){
            if(callback[0] != '/')
                callback = '/' + callback;
            this.callback_text = '';
            this.current_id = id;
            this.current_data = data;
            this.current_callback = callback;
            if(parseInt(need_back) == 1)
                this.dialogVisible = true;
            else
                this.resp2();
        },
        resp2(){
            this.$requests.axios.post(this.current_callback+'/'+this.current_id, {
                extra_data: this.callback_text,
                choice: this.current_data,
            }).then((res) => {
                if(res.status == 200){
                    this.$message.success('成功,请刷新页面');
                }else
                    this.$message.error('错误,请检查网络或联系郭俊毅');
            }).catch((e) => {
                console.log(e.toString());
            });
        }
    },
    watch: {
        uinfo: {
            immediate: true,
            handler () {
                this.refreshMessage();
            }
        }
    },
    created: function() {
        this.refreshMessage();
    }
}
</script>
<style>
.el-dialog__wrapper{
    z-index: 1000000 !important;
}
</style>