<template>
    <el-card @click="clicked">
        <h3>地点:{{event.position==""?"未定":event.position}}</h3>
        <p>开始时间: {{formatDate(new Date(parseInt(event.beg_due)*1000))}}</p>
        <p>结束时间: {{formatDate(new Date(parseInt(event.end_due)*1000))}}</p>
        <p>人数限制: {{event.limit == "0" ? "无限制" : event.limit}}</p>
        <p>组织者: {{event.author.nickname}}</p>
        <el-popover
        placement="right"
        width="200"
        trigger="click"
        v-model="visible"
        >
            <h4>参与者:</h4>
            <p v-for="user in event.participants" :key="user.id">{{user.nickname}}</p>
            <p>确认{{status}}?</p>
            <div style="text-align: right; margin: 0">
                <el-button size="mini" type="text" @click="visible = false">取消</el-button>
                <el-button type="primary" size="mini" @click="visible = false;clicked()">确定</el-button>
            </div>
            <el-button slot="reference" icon="el-icon-more-outline" :loading="submitting" circle> </el-button>
        </el-popover>
    </el-card>
</template>
<script>
export default{
    name: 'TimelineBlock',
    methods:{
        formatDate(datetime) {
            var date = new Date(datetime);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
            var year = date.getFullYear(),
                month = ("0" + (date.getMonth() + 1)).slice(-2),
                sdate = ("0" + date.getDate()).slice(-2),
                hour = ("0" + date.getHours()).slice(-2),
                minute = ("0" + date.getMinutes()).slice(-2),
                second = ("0" + date.getSeconds()).slice(-2);
            // 拼接
            var result = year + "-"+ month +"-"+ sdate +" "+ hour +":"+ minute +":" + second;
            // 返回
            return result;
        },
        clicked(){
            this.submitting = true;
            var method_name = "eventExit";
            if(this.status == "请求加入")
                method_name = "eventJoin";
            this.$requests.axios.post('/timeline/'+method_name+'/'+this.event.id.toString()).then((res) => {
                if(res.status == 200){
                    this.$message.success('成功,请点击刷新按钮');
                }else{
                    this.$message.error('错误,可能无法退出');
                }
                this.submitting = false;
            }).catch((e) => {
                this.submitting = false;
                this.$message.error('出现错误'+e.toString());
            })
        },
    },
    data: () => {
        return {
            visible: false,
            submitting: false,
        };
    },
    computed: {
        status(){
            for(var i=0;i<this.event.participants.length;i++){
                if(this.event.participants[i].id == this.uinfo.id){
                    return "退出";
                }
            }
            return "请求加入";
        }
    },
    props: ["event", "id_to_type", "uinfo"]
}
</script>