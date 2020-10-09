<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $_POST = json_decode($this->input->raw_input_stream, true);
        $uid = $this->getAuthorizationId();
        if(!$uid)
            show_error('Permission denied');
        $this->load->model('myMessage', 'message', TRUE);
        $this->output->set_header("Access-Control-Allow-Origin: * ");
    }
    
    function read($message_id){
        $user_id = $this->getAuthorizationId();
        $message_id = intval($message_id);
        if($message_id == 0) show_error('');
        $message = $this->message->findMessageById($message_id);
        if($message['target_user_id'] == $user_id){
            $this->message->read($message_id);
            $this->message->hide($message_id);
        }
    }
    
    function getList(){
        # 从新到旧返回所有的visible的Message
        $start = 0;
        $limit = 20;
        if(isset($_GET['start'])) $start = intval($_GET['start']);
        if(isset($_GET['limit'])) $limit = intval($_GET['limit']);
        
        $user_id = $this->getAuthorizationId();
        $res = $this->message->getList($user_id, $start, $limit);
        
        $this->load->model('myUser', 'user', TRUE);
        foreach($res as &$row)
            $row['author'] = $this->user->findUserById($row['author_id']);
        
        echo json_encode($res);
    }
    
    function del($message_id){
        $user_id = $this->getAuthorizationId();
        $message_id = intval($message_id);
        $message = $this->message->findMessageById($message_id);
        if($message['target_user_id'] == $user_id)
            $this->message->hide($message_id);
    }
    
    function getUnreadCount(){
        $user_id = $this->getAuthorizationId();
        $unread = $this->message->getUnread($user_id);
        echo "".$unread;
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
}