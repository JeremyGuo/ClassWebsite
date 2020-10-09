<template>
    <el-row type="flex" class="row-bg" justify="center">
        <el-col :xs="24" :sm="16" :md="10" :lg="6" :xl="6">
            <el-card class="login-panel" header="登入">
                <el-form :model="form" ref="form" label-width="80px" :rules="rules">
                    <el-form-item label="名称" prop="username">
                        <el-input placeholder="你的名称" v-model="form.username"></el-input>
                    </el-form-item>
                    <el-form-item label="密码" prop="password">
                        <el-input placeholder="你的密码" v-model="form.password" type="password"></el-input>
                    </el-form-item>
                    <el-form-item style="float:right;">
                        <el-button type="primary" @click="onSubmit" :disabled="submitting">登入</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
export default{
    name: 'LoginPage',
    data: function () {
        return {
            form: {
                username: '',
                password:'',
            },
            submitting: false,
            rules: {
                username: [
                    {min: 1, max: 16, message: "长度在1到16个字符之间", trigger: 'blur'}
                ],
                password: [
                    {min: 6, max: 16, message: "长度在6到16个字符之间", trigger: 'blur'},
                ],
            }
        };
    },
    methods:{
        onSubmit: function() {
            this.submitting = true;
            this.$refs.form.validate((valid) => {
                if(!valid) {
                    this.submitting = false;
                } else {
                    this.$requests.axios.post('/user/login', this.form).then(
                        (res) => {
                            if(res.status != 200) this.$message.error('出事故了！状态码: '+res.status);
                            else {
                                this.$emit('onUserInfoChanged', res.data);
                                if(window.history.length > 1) this.$router.go(-1);
                                else this.$router.push('/home');
                            }
                            this.submitting  = false;
                        }
                    ).catch((e)=> {
                        console.log(e);
                        this.submitting = false;
                    });
                }
            })
        }
    }
}
</script>