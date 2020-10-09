<template>
    <div id="app">
        <el-container>
            <el-header id="main-el-header">
                <NavbarMain :uinfo="uinfo" @onUserInfoChanged="jwtChanged"/>
            </el-header>
            <el-main id="main-el-main">
                <router-view :uinfo="uinfo" @onUserInfoChanged="jwtChanged"></router-view>
            </el-main>
            <el-footer>
            </el-footer>
        </el-container>
    </div>
</template>

<script>
import NavbarMain from './components/NavbarMain.vue'

export default {
    name: 'App',
    components: {
        NavbarMain
    },
    data: () => {
        return {
            uinfo:{id:0, username:'unknown', nickname:'unknown', permission:-1, signature:'', email:'unknown'}
        }
    },
    methods: {
        jwtChanged: function(jwt){
            localStorage.setItem('jwt', jwt);
            this.$requests.setJWT(jwt);
            if(jwt == "")
                this.uinfo = {id:0, username:'unknown', nickname:'unknown', permission:-1, signature:'', email:'unknown'};
            else
                this.updateUinfo();
        },
        updateUinfo: function(){
            this.$requests.axios.get('/user').then((res) => {
                if(res.status == 200){
                    this.uinfo = res.data;
                }
            }).catch((e) => {
                // var jwt = localStorage.getItem('jwt');
                console.log(e);
            })
        }
    },
    created: function(){
        if(localStorage.getItem('jwt') == null)
            localStorage.setItem('jwt', '')
        var jwt = localStorage.getItem('jwt');
        if(jwt != '')
            this.$requests.setJWT(jwt);
        this.updateUinfo()
    }
}
</script>
<style>
body { margin: 0 !important; }
#main-el-header {
    position: fixed !important;
    top: 0px !important;
    width: 100% !important;
    padding: 0 !important;
    z-index: 3000 !important;
}
#main-el-main { 
    padding: 60px 0 !important;
    margin: 8px !important;
}
.el-message {
    z-index: 10001 !important;
}
</style>