<?php
class MyTimeline extends CI_Model{
    function findEventById($event_id){
        $this->db->where('id', $event_id);
        return $this->db->get('timeline')->row_array();
    }
    
    function hasPermission($user_id, $action, $event_id){
        $event = $this->findEventById($event_id);
        if($action == 'cancel'){
            if($event['author_id'] == $user_id)
                return TRUE;
            return FALSE;
        }
        if($action == 'join'){
            if($this->db->where('user_id', $user_id)->where('event_id', $event_id)->from('timeline_relation')->count_all_results() > 0)
                return FALSE;
            return TRUE;
        }
    }
    
    function cancel(){
        $this->db->set('enabled', 0);
        $this->db->where('id', $event_id);
        $this->db->update('timeline');
    }
    
    function addParticipant($event_id, $user_id){
        $this->db->where('event_id', $event_id)->where('user_id', $user_id)->from('timeline_relation');
        if($this->db->count_all_results() == 0)
            $this->db->insert('timeline_relation', array(
                'event_id' => $event_id,
                'user_id' => $user_id
                ));
    }
    
    function delParticipant($event_id, $user_id){
        $this->db->where('event_id', $event_id)->where('user_id', $user_id)->delete('timeline_relation');
    }
    
    function findUserById($user_id){
        $this->db->where('id', $user_id);
        $this->db->select('id, username, nickname, signature, email, permission');
        $user = $this->db->get('user')->row_array();
        return $user;
    }
    
    function findUserByName($username){
        $this->db->where('username', $username);
        $this->db->select('id, username, nickname, signature, email, permission');
        $user = $this->db->get('user')->row_array();
        return $user;
    }
    
    function getList($start_time, $finish_mask, $user_mask, $author_mask, $time_limit, $user_id){
        $this->db->where('beg_due > ', $start_time);
        $this->db->where('end_due < ', $time_limit + $start_time);
        $current_time = time();
        if($finish_mask != 3){
            if($finish_mask & 1)
                # 选择所有未完成的
                $this->db->where('end_due > ', $current_time);
            else
                # 选择所有已经完成的
                $this->db->where('end_due < ', $current_time);
        }
        if($author_mask != 0)
            $this->db->where('author_id', $author_mask);
        $this->db->order_by('beg_due', 'ASC');
        $result = $this->db->get('timeline')->result_array();
        $ret = [];
        if($user_mask == 0)
            return $result;
        foreach($result as $row){
            if($this->db->where('event_id', $row['id'])->where('user_id', $user_mask)->from('timeline_relation')->count_all_results() > 0)
            array_push($ret, $row);
        }
        return $ret;
    }
    
    function getParticipants($event_id){
        $result = array();
        $users = $this->db->where('event_id', $event_id)->get('timeline_relation')->result_array();
        foreach($users as $row){
            $user = $this->findUserById($row['user_id']);
            array_push($result, $user);
        }
        return $result;
    }
    
    function create($user_id, $type, $beg_due, $end_due, $position, $limit){
        $this->db->insert('timeline', array(
            'author_id' => $user_id,
            'type' => $type,
            'beg_due' => $beg_due,
            'end_due' => $end_due,
            'position' => $position,
            'limit' => $limit,
            'enabled' => 1
            ));
        $event_id = $this->db->insert_id();
        $this->db->insert('timeline_relation', array(
            'event_id' => $event_id,
            'user_id' => $user_id
            ));
    }
}