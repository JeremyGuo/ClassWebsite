<template>
    <div>
        <el-row type="flex" class="row-bg" justify="center" style="margin:10px 0;">
            <el-col :xs="24" :sm="18" :md="14" :lg="12" :xl="10">
                <el-card>
                    <template>
                        <el-button icon="el-icon-refresh" @click="refreshList" circle></el-button>
                        <el-popover
                          placement="bottom"
                          width="300"
                          style="margin-left:5px;">
                            <el-form label-width="80px" :model="form">
                                <el-form-item label="活动地点">
                                    <el-input v-model="form.place"></el-input>
                                </el-form-item>
                                <el-form-item label="活动类型">
                                    <el-select v-model="form.type" placeholder="请选择">
                                        <el-option v-for="item in types" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                    </el-select>
                                </el-form-item>
                                <el-form-item label="活动时间">
                                    <el-date-picker
                                        v-model="form.date_beg"
                                        type="datetime"
                                        placeholder="选择日期时间">
                                    </el-date-picker>
                                </el-form-item>
                                <el-form-item label="结束时间">
                                    <el-date-picker
                                        v-model="form.date_end"
                                        type="datetime"
                                        placeholder="选择日期时间">
                                    </el-date-picker>
                                </el-form-item>
                                <el-form-item label="人数期望">
                                    <el-slider v-model="form.limit" :step="1" :min="0" :max="26"></el-slider>
                                </el-form-item>
                                <el-button type="primary" @click="submitForm" :loading="submitting">立即创建</el-button>
                            </el-form>
                            <el-button icon="el-icon-plus" slot="reference" circle></el-button>
                        </el-popover>
                    </template>
                    <div style="float:right;">
                        <el-button-group style="margin-right:5px;">
                            <el-checkbox-group v-model="finish_filter" >
                                <el-checkbox-button :label="0">未完成的</el-checkbox-button>
                                <el-checkbox-button :label="1">完成的</el-checkbox-button>
                            </el-checkbox-group>
                        </el-button-group>
                        <el-button icon="el-icon-search" circle></el-button>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <el-row type="flex" class="row-bg" justify="center">
            <el-col :xs="24" :sm="18" :md="14" :lg="12" :xl="10" v-if="events.length != 0">
                <el-card style="padding-top:20px">
                    <el-timeline>
                        <el-timeline-item
                            v-for="event in events"
                            :key="event.id" :timestamp="id_to_type[event.type]+' '+formatDate(new Date(parseInt(event.beg_due)*1000))" placement="top">
                            
                            <TimelineBlock :event="event" :id_to_type="id_to_type" :uinfo="uinfo"/>
                      </el-timeline-item>
                  </el-timeline>
                </el-card>
            </el-col>
            <el-card v-else>
                <div>
                    空空如也
                </div>
            </el-card>
        </el-row>
    </div>
</template>

<script>
import TimelineBlock from './TimelineBlock.vue';
export default {
    name: 'TimelinePage',
    data: () => {
        return {
            types: [{
                value: "0",
                label: "学习"
            }, {
                value: "1",
                label: "运动"
            }, {
                value: "2",
                label: "旅行"
            }],
            // user_mask: '', //筛选用户
            // author_mask: '', //筛选作者
            // beg_time: -1, //开始时间筛选
            // time_limit: -1, //时间长度筛选
            finish_filter: [0, 1], //参与状态筛选
            form: {
                limit: 0,
                type: '',
                date_beg: '',
                date_end: '',
                place: '',
            },
            events: [],
            submitting: false,
            id_to_type: ['学习', '运动', '旅行'],
        };
    },
    created: function(){
        this.refreshList();
    },
    methods: {
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
        convertTimestamp(val) {
            var time = new Date(val);
            var dateTime = time.getTime() / 1000;
            return dateTime;
        },
        submitForm() {
            if(this.form.type == ''){
                this.$message.error('错误的类型');
                return ;
            }
            if(this.form.limit < 0 || this.form.limit > 26){
                this.$message.error('错误的人员限制');
                return ;
            }
            if(this.form.date_beg == '' || this.form.date_end == ''){
                this.$message.error('错误的日期');
                return ;
            }
            this.submitting = true;
            var send_form = {
                beg_due: this.convertTimestamp(this.form.date_beg),
                end_due: this.convertTimestamp(this.form.date_end),
                type: parseInt(this.form.type),
                position: this.form.place,
                limit: parseInt(this.form.limit),
            }
            this.$requests.axios.post('/timeline/createEvent', send_form).then((res) => {
                if(res.status == 200)
                    this.$message.success('添加事件成功');
                else
                    this.$message.error('添加事件失败,请检查参数,(开始时间,结束时间,类型)为必填');
                this.submitting = false;
            }).catch((e) => {
                console.log(e);
                this.submitting = false;
            })
        },
        refreshList() {
            var finish_mask = 0
            for(var i=0;i<this.finish_filter.length;i++)
                finish_mask += (1 << this.finish_filter[i]);
            var send_form = {
                finish_mask: finish_mask
            }
            this.$requests.axios.post('/timeline/eventList', send_form).then((res) => {
                if(res.status != 200)
                    this.events = [];
                else{
                    this.events = res.data;
                }
            })
        },
    },
    watch: {
        uinfo: {
            immediate: true,
            handler () {
                this.refreshList()
            }
        }
    },
    props: ["uinfo"],
    components:{
        TimelineBlock
    }
}
</script>