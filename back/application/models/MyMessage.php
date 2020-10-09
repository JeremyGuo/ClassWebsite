<?php
class MyMessage extends CI_Model{
    function send($author_id, $target_user_id, $content, $choices, $callback, $extra_data, $need_callback_info){
        $message = array(
            'author_id' => intval($author_id),
            'target_user_id' => intval($target_user_id),
            'content' => $content,
            'extra_data' => $extra_data,
            'need_backinfo' => intval($need_callback_info),
            'callback' => $callback,
            'choices' => json_encode($choices),
            'hide' => 0,
            'read' => 0
            );
        $this->db->insert('message', $message);
    }
    
    function read($message_id){
        $this->db->set('read', 1);
        $this->db->where('id', $message_id);
        $this->db->update('message');
    }
    
    function findMessageById($message_id){
        $this->db->where('id', $message_id);
        return $this->db->get('message')->row_array();
    }
    
    function hide($message_id){
        $this->db->set('hide', 1);
        $this->db->where('id', $message_id);
        $this->db->update('message');
    }
    
    function getUnread($user_id){
        $this->db->where('read', 0);
        $this->db->where('target_user_id', $user_id);
        $this->db->from('message');
        return $this->db->count_all_results();
    }
    
    function getList($user_id, $start, $limit){
        $this->db->where('target_user_id', $user_id);
        $this->db->limit($limit, $start);
        $this->db->where('hide', 0);
        return $this->db->get('message')->result_array();
    }
}