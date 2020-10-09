<template>
    <el-row type="flex" class="row-bg" justify="center">
        <el-col :xs="24" :sm="16" :md="10" :lg="6" :xl="6">
            <el-card class="login-panel" header="登入">
                <el-form :model="form" ref="form" label-width="80px" :rules="rules">
                    <el-form-item label="邮箱" prop="email">
                        <el-input placeholder="你的邮箱" v-model="form.email"></el-input>
                    </el-form-item>
                    <el-form-item label="名称" prop="username">
                        <el-input placeholder="你的名称" v-model="form.username"></el-input>
                    </el-form-item>
                    <el-form-item label="昵称" prop="nickname">
                        <el-input placeholder="你的昵称" v-model="form.nickname"></el-input>
                    </el-form-item>
                    <el-form-item label="密码" prop="password">
                        <el-input placeholder="你的密码" v-model="form.password" type="password"></el-input>
                    </el-form-item>
                    <el-form-item label="密码确认" prop="password_rep">
                        <el-input placeholder="请再次输入密码" v-model="form.password_rep" type="password"></el-input>
                    </el-form-item>
                    <el-form-item style="float:right;">
                        <el-button type="primary" @click="onSubmit" :disabled="submitting">注册</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
export default{
    name: 'RegisterPage',
    data: function () {
        return {
            form: {
                username: '',
                password:'',
                nickname: '',
                password_rep: '',
                email: '',
            },
            submitting: false,
            rules: {
                username: [
                    {min: 1, max: 16, message: "长度在1到32个字符之间", trigger: 'blur'}
                ],
                nickname: [
                    {min: 1, max: 16, message: "长度在1到32个字符之间", trigger: 'blur'}
                ],
                password: [
                    {min: 6, max: 16, message: "长度在6到32个字符之间", trigger: 'blur'},
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
                    if(this.form.password != this.form.password_rep){
                        this.submitting = false;
                        return ;
                    }
                    this.$requests.axios.post('/user/register', this.form).then(
                        (res) => {
                            if(res.status != 200) this.$message.error("错误Code:" + res.status.toString())  ;
                            else {
                                this.$emit('onUserInfoChanged', res.data);
                                if(window.history.length > 1) this.$router.go(-1);
                                else this.$router.push('/home');
                                // this.$message.error("错误Code:" + res.status.toString());
                            }
                            this.submitting  = false;
                        }
                    ).catch((e)=> {
                        this.$message.error("错误Code:" + e.toString());
                        console.log(e);
                        this.submitting = false;
                    });
                }
            })
        }
    }
}
</script>