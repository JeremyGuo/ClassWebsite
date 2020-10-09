<?php
class MyUser extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $_POST = json_decode($this->input->raw_input_stream, true);
    }
    
    public function register($username, $nickname, $password, $email){
        $data = array(
            'username' => $username,
            'nickname' => $nickname,
            'password' => $this->encryptPassword($password),
            'email' => $email,
            'signature' => '',
            'permission' => USER_PERMISSION_USER
        );
        $this->db->insert('user', $data);
    }

    public function login($username, $password){
        $this->db->where('username', $username);
        $this->db->where('password', $this->encryptPassword($password));
	$this->db->from('user');
        if($this->db->count_all_results() > 0){
            $this->db->where('username', $username);
            $this->db->where('password', $this->encryptPassword($password));
            $this->db->from('user');
            return $this->db->get()->row_array()['id'];
        }
        show_error("Failed to login", 401);
    }
    
    public function hasId($id){
        $this->db->where('id', $id);
        $this->db->from('user');
        if($this->db->count_all_results() > 0)
            return true;
        return false;
    }
    public function hasName($name){
        $this->db->where('username', $name);
        $this->db->from('user');
        if($this->db->count_all_results() > 0)
            return true;
        return false;
    }

    public function valid($username, $nickname, $password, $email){
        if($this->db->where('username', $username)->from('user')->count_all_results() > 0)
            show_error('无效的用户名', 401);
        if($this->db->where('email', $email)->from('user')->count_all_results() > 0)
            show_error('无效的邮箱', 401);
    }
    
    public function findUserById($id){
        if(!$this->hasId($id))
            return false;
        $query = $this->db->select('id, username, nickname, signature, email, permission, avatar, avatar_type')->where('id', $id)->from('user')->get();
        return $query->row_array();
    }
    public function findUserByName($name){
        if(!$this->hasName($name))
            return false;
        $query = $this->db->select('id, username, nickname, signature, email, permission, avatar, avatar_type')->where('username', $name)->from('user')->get();
        return $query->row_array();
    }

    public function verifyPassword($id, $password){
        if($this->db->where('id', $id)->where('password', $this->encryptPassword($password))->from('user')->count_all_results() > 0)
            return TRUE;
        return FALSE;
    }

    public function hasSame($key, $value){
        return $this->db->where($key, $value)->from('user')->count_all_results() > 0;
    }
    
    public function changeUserInfo($id, $key, $value){
        $this->db->set($key, $value)->where('id', $id)->update('user');
    }

    public function newAvatar($id, $data, $type){
        $this->db->set('avatar', $data);
        $this->db->set('avatar_type', $type);
        $this->db->where('id', $id);
        $this->db->update('user');
    }

    public function getAvatar($id){
        if(!$this->hasId($id))
            return false;
        $this->db->select('avatar, avatar_type');
        $this->db->where('id', $id);
        $this->db->from('user');
        return $this->db->get()->row_array();
    }

    private function encryptPassword($password)
    {
        return sha1($password).hash("sha256",$password);
    }
}

