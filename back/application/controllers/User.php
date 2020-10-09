<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $_POST = json_decode($this->input->raw_input_stream, true);
        $this->output->set_header("Access-Control-Allow-Origin: * ");
    }

    public function get_my_id(){ //???这垃圾山有用？
        $id = $this->getAuthorizationId();
        if(!$id)
            show_error('Please login first.', 401);
        echo $id;
    }
    
    /**
     * Need: hasId, findUserById
     **/
    public function index()
    {
        if(isset($_GET['id']) && trim($_GET['id']) != "") $id = intval($_GET['id']);
        else $id = $this->getAuthorizationId();
        $this->load->model('myUser', 'user', TRUE);
        if(!$id || !$this->user->hasId($id)) show_error('No permission.', 403);
        $data = $this->user->findUserById($id);
        if(!$data) show_error('No such user.', 401);
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        unset($data['avatar']);
        unset($data['avatar_type']);
        echo json_encode($data);
    }
    
    /**
     * Need: valid, register
     **/
    public function register()
    {
        $id = $this->getAuthorizationId();
        if($id != false) show_error('You have already logged in.', 401);
        
        if(!isset($_POST["nickname"])) show_error('nickname is invalid.', 403);
        if(!isset($_POST['password'])) show_error('password is invalid.', 403);
        if(!isset($_POST['email'])) show_error('email is invalid.', 403);
        if(!isset($_POST['username'])) show_error('username is invalid.', 403);
        
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        
        $this->load->model('myUser', 'user', TRUE);
        $this->user->valid($username, $nickname, $password, $email);
        $this->user->register($username, $nickname, $password, $email);
    }
    
    /**
     * Need: login
     **/
    public function login()
    {
        $id = $this->getAuthorizationId();
        if($id != false) show_error('You have already logged in.', 403);
	if(!isset($_POST['username'])) show_error('username is invalid.', 402);
        if(!isset($_POST['password'])) show_error('password is invalid.', 401);
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $this->load->model('myUser', 'user', TRUE);
        $id = $this->user->login($username, $password);
        
        $payload = $this->generatePayload($id);
        $jwt = $this->jwt->getToken($payload);
        if(!$jwt)
            show_error("[Error 1]用户非法", 401);
        echo $jwt;
    }
    
    /**
     * Need: getAvatar
     **/
    public function avatar($id = "")
    {
        if($id == "upload"){
            $this->avatar_upload();
            return;
        }
        if($id == "") $id = $this->getAuthorizationId();
        else $id = intval($id);
        if(!$id) show_error('No permission', 401);
        $this->load->model('myUser', 'user', TRUE);
        $avatar_data = $this->user->getAvatar($id);
        if($avatar_data != false){
            $this->output->set_header("Content-Type: ".$avatar_data["avatar_type"].";");
            echo $avatar_data["avatar"];
        }
    }
    
    /**
     * Need: newAvatar
     **/
    public function avatar_upload()
    {
        $id = $this->getAuthorizationId();
        if(!$id) show_error('No permission', 401);
        $image = file_get_contents($_FILES['file']['tmp_name']);
        $type = $_FILES['file']['type'];
        $this->load->model('myUser', 'user', TRUE);
        $this->user->newAvatar($id, $image, $type);
    }
    
    private function getAuthorizationId()
    {
        $header = $this->input->request_headers();
        if(isset($header["authorization"]))
            $header["Authorization"] = $header['authorization'];
        if(!isset($header["Authorization"]))
            return false;
        $user_info = $this->jwt->verifyToken($header["Authorization"]);
        if(!$user_info || !isset($user_info["sub"]))
            return false;
        $id = intval($user_info['sub']);
        return $id;
    }

    private function generatePayload($id)
    {
        return [
            'iss'=>'jwt_admin',  //该JWT的签发者
            'iat'=>time(),  //签发时间
            'exp'=>time()+7200,  //过期时间
            'nbf'=>time(),  //该时间之前不接收处理该Token
            'sub'=>$id,  //面向的用户
            'jti'=>md5(uniqid('JWT').time())  //该Token唯一标识
        ];
    }
    
    /**
     * Need: hasSameUsername
     **/
    public function modify(){
        var_dump($_POST);
        $target_id = $this->getAuthorizationId();
        $self_id = $this->getAuthorizationId();
        if(!$self_id)
            show_error('Permission denied', 401);
        if(isset($_POST['id'])) #一般来说只有管理员才会用到这个参数
            $target_id = intval($_POST['id']);
        if($target_id == NULL)
            show_error('Permission denied.', 401);
        $this->load->model('myUser', 'user', TRUE);
        
        $self_user_data = $this->user->findUserById($self_id);
        $target_user_data = $this->user->findUserById($target_id);
        
        if($self_user_data['permission'] < USER_PERMISSION_OP && $target_id != $self_id)
            show_error('Permission denied.', 401);

        if(!isset($_POST['data']))
            die();
        $data = $_POST['data'];
        if(isset($data['username'])){
            $new_username = trim($data['username']);
            if($new_username != $target_user_data['username']
                && strlen($new_username) > 0){
                    if($this->user->hasSame('username', $new_username))
                        show_error('Username has been used.', 403);
                    $this->user->changeUserInfo($target_id, 'username', $new_username);
                }
        }
        if(isset($data['nickname'])){
            $this->user->changeUserInfo($target_id, 'nickname', $data['nickname']);
        }
        if(isset($data['signature'])){
            $this->user->changeUserInfo($target_id, 'signature', $data['signature']);
        }
        if(isset($data['avatar'])){
            $this->user->changeUserInfo($target_id, 'avatar', $data['avatar']);
        }
        if(isset($_POST['new_password'])){
            if(!isset($_POST['old_password']) && $self_user_data['permission'] < USER_PERMISSION_OP)
                show_error('No permission to change the password.', 401);
            if($self_user_data['permission'] < USER_PERMISSION_OP && !$this->user->verifyPassword($target_id, $_POST['old_password']))
                show_error('Wrong old password or No permission.', 403);
            $this->user->changePassword($target_user_data, $_POST['new_password']);
        }
    }
}
