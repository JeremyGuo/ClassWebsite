<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Timeline extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $_POST = json_decode($this->input->raw_input_stream, true);
        $uid = $this->getAuthorizationId();
        if(!$uid)
            show_error('Permission denied');
    }
    
    function index(){
        show_error("", 404);
    }
    
    /**
     * 开始时间 required
     * 发起人 required
     * 事件类型 required
     * 大致地点
     * 结束时间 required
     * 人数上限
     * 
     * (只能通过modify上传)二维码信息: 用于放群聊的二维码 默认为空
     **/
    function createEvent(){
        $user_id = $this->getAuthorizationId();
        $type = EVENT_TYPE_STUDY;
        if(isset($_POST['type'])){
            $type = intval($_POST['type']);
            if($type > 3) $type = EVENT_TYPE_STUDY;
            if($type < 0) $type = EVENT_TYPE_STUDY;
        }
        
        if(!isset($_POST['beg_due']))
            show_error('不是一个有效的时间', 403);
        $beg_due = intval($_POST['beg_due']);
        if($beg_due < time())
            show_error('开始时间不能在当前时间之前', 403);
        
        if(!isset($_POST['end_due']))
            show_error('不是一个有效的时间', 403);
        $end_due = intval($_POST['end_due']);
        if($end_due < $beg_due)
            show_error('结束时间不能在开始时间之前', 403);
        
        $position = "";
        if(isset($_POST['position']))
            $position = $_POST['position'];
        
        $limit = 0;
        if(isset($_POST['limit']))
            $limit = intval($_POST['limit']);
        if($limit < 0)
            show_error('人数限制非法', 403);
        
        $this->load->model('myTimeline', 'timeline', TRUE);
        $this->timeline->create($user_id, $type, $beg_due, $end_due, $position, $limit);
    }
    
    /**
     * 为避免影响同学关系，如果临时无法组织事件，请提前自行告知已经报名参与的同学
     * 并不是真正的删除，会修改事件状态为取消
     **/
    function deleteEvent($event_id){
        $user_id = $this->getAuthorizationId();
        $this->load->model('myTimeline', 'timeline', TRUE);
        $event_id = intval($event_id);
        if($event_id == 0) show_error('');
        if($this->timeline->hasPermission($user_id, 'cancel', $event_id))
            $this->timeline->cancel($event_id);
        else
            show_error('Permission denied.', 403);
    }
    
    /**
     * 加入一个事件，当发起者同意后，会出现在自己的事件列表中
     **/
    function eventJoin($event_id){
        $user_id = $this->getAuthorizationId();
        $event_id = intval($event_id);
        if($event_id == 0) show_error('');
        $this->load->model('myTimeline', 'timeline', TRUE);
        $this->load->model('myMessage', 'message', TRUE);
        $this->load->model('myUser', 'user', TRUE);
        $user = $this->user->findUserById($user_id);
        
        if($this->timeline->hasPermission($user_id, 'join', $event_id)){
            $event = $this->timeline->findEventById($event_id);
            
            $type = array(
                0 => '学习',
                1 => '运动',
                2 => '旅行'
            );
            
            $this->message->send($user_id, $event['author_id'], $user['nickname'].'希望参加您的'.$type[$event['type']].'活动', 
                ['约', '下次吧'], 'timeline/eventJoinResponse', "".$event_id, TRUE);
        }else
            show_error('Permission denied.', 403);
    }
    
    /**
     * 发起者同意某个申请加入的信息，同意后发起者无法主动修改对方是否参与
     * 通用MessageResp格式
     * {
     * 'extra_data': xxxx (String)
     * 'choice': xxxx (String)
     * }
     **/
    function eventJoinResponse($message_id){
        $message_id = intval($message_id);
        if($message_id == 0)
            show_error('Wrong message id.', 403);
        $user_id = $this->getAuthorizationId();
        
        if(!isset($_POST['choice']))
            show_error('Permission denied.', 403);
        $choice = $_POST['choice'];
        if(!in_array($choice, ['约', '下次吧']))
            show_error('What do you want?', 403);
        
        $this->load->model('myMessage', 'message', TRUE);
        $message = $this->message->findMessageById($message_id);
        if($message['target_user_id'] != $user_id)
            show_error('Permission denied.', 403);
        $this->message->hide($message_id);
        
        if($choice == '约'){
            $this->load->model('myTimeline', 'timeline', TRUE);
            $this->timeline->addParticipant(intval($message['extra_data']), $message['author_id']);
        }
        
        if(isset($_POST['extra_data'])){
            $resp = trim($_POST['extra_data']);
            if($resp != "")
                $this->message->send($user_id, $message['author_id'], $resp, ['我知道了'], 'message/read', '', FALSE);
        }
    }
    
    /**
     * 退出一个事件，当然如果你是发起者，这样做是非法的
     **/
    function eventExit($event_id){
        $user_id = $this->getAuthorizationId();
        $this->load->model('myTimeline', 'timeline', TRUE);
        $event_id = intval($event_id);
        if($event_id == 0) show_error('');
        $event = $this->timeline->findEventById($event_id);
        if($event['author_id'] == $user_id)
            show_error('You cant exit.', 403);
        $this->timeline->delParticipant($event_id, $user_id);
    }
    
    
    /**
     * 获取一个事件的详细信息（基本咩用
     **/
    function eventDetail($event_id){
        $this->load->model('myTimeline', 'timeline', TRUE);
        $event_id = intval($event_id);
        if($event_id == 0) show_error('');
        $event = $this->timeline->findEventById($event_id);
        $this->load->model('myUser', 'user', TRUE);
        $event['author'] = $this->user->findUserById($event['author_id']);
        $event['participants'] = $this->timeline->getParticipants($event_id);
        echo json_encode($event);
    }
    
    /**
     * 注意获取的时间，应该在一周左右。 start_time
     * 当然也可以获取历史记录
     * 参加/不参加 join_mask
     * 已经完成/未完成 finish_mask
     * 参与者筛选器 user_mask # 按照用户username筛选因为username唯一
     * 发起者筛选器 # 按照username筛选因为username唯一
     * 时间筛选,默认为当前时间往后七天 time_limit(sec)
     **/
    function eventList(){
        $start_time = time();
        $finish_mask = 3;
        $user_mask = 0;
        $author_mask = 0;
        $time_limit = 60 * 60 * 24 * 365; # 一周时间
        
        if(isset($_GET['start_time'])) $start_time = intval($_GET['start_time']);
        if(isset($_GET['finish_mask'])) $finish_mask = intval($_GET['finish_mask']);
        if(isset($_GET['user_mask'])) $user_mask = intval($_GET['user_mask']);
        if(isset($_GET['author_mask'])) $author_mask = intval($_GET['author_mask']);
        if(isset($_GET['time_limit'])) $time_limit = intval($_GET['timelimit']);
        
        $user_id = $this->getAuthorizationId();
        
        $this->load->model('myTimeline', 'timeline', TRUE);
        $this->load->model('myUser', 'user', TRUE);
        $result = $this->timeline->getList($start_time, $finish_mask, $user_mask, $author_mask, $time_limit, $user_id);
        foreach($result as &$row){
            $row['author'] = $this->user->findUserById($row['author_id']);
            $row['participants'] = $this->timeline->getParticipants($row['id']);
        }
        echo json_encode($result);
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