<?php
class DBInitializer extends CI_Model{
    public function initTables(){
        $this->load->dbforge();
        echo "开始创建user表<br/>";
        $this->dbforge->drop_table('user', TRUE);
        $this->dbforge->add_field('id');
        $fields = array(
            'nickname' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => TRUE,
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => TRUE,
            ),
            'signature' => array(
                'type' => 'TEXT',
                'default' => '',
            ),
            'email' => array(
                'type' => 'TEXT',
                'default' => '',
            ),
            'permission' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'default' => 0
            ),
            'password' => array(
                'type' => 'TEXT',
                'default' => ''
            ),
            'avatar' => array(
                'type' => 'MEDIUMBLOB'
            ),
            'avatar_type' => array(
                'type' => 'TEXT',
                'default' => ''
            )
        );
        var_dump($fields);
        echo "<br/>";
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('user');
        echo "user创建成功<br/>";
        
        echo "开始创建timeline表<br/>";
        $this->dbforge->drop_table('timeline', TRUE);
        $this->dbforge->add_field('id');
        $fields = array(
            'author_id' => array(
                'type' => 'INT'
            ),
            'type' => array(
                'type' => 'INT'
            ),
            'beg_due' => array(
                'type' => 'INT'
            ),
            'end_due' => array(
                'type' => 'INT'
            ),
            'position' => array(
                'type' => 'VARCHAR',
                'constraint' => '10240',
            ),
            'limit' => array(
                'type' => 'INT'
            ),
            'qrcode' => array(
                'type' => 'MEDIUMBLOB'
            ),
            'enabled' => array(
                'type' => 'INT'
            )
        );
        var_dump($fields);
        echo "<br/>";
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('timeline');
        echo "timeline创建成功<br/>";
        
        echo "开始创建timeline_relation表<br/>";
        $this->dbforge->drop_table('timeline_relation', TRUE);
        $this->dbforge->add_field('id');
        $fields = array(
            'event_id' => array(
                'type' => 'INT'
            ),
            'user_id' => array(
                'type' => 'INT'
            )
        );
        var_dump($fields);
        echo "<br/>";
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('timeline_relation');
        echo "timeline_relation创建成功<br/>";
        
        $this->load->dbforge();
        echo "开始创建message表<br/>";
        $this->dbforge->drop_table('message', TRUE);
        $this->dbforge->add_field('id');
        $fields = array(
            'content' => array(
                'type' => 'VARCHAR',
                'constraint' => '10240',
            ),
            'target_user_id' => array(
                'type' => 'INT'
            ),
            'author_id' => array(
                'type' => 'INT'
            ),
            'extra_data' => array(
                'type' => 'VARCHAR',
                'constraint' => '10240',
            ),
            'read' => array(
                'type' => 'INT'
            ),
            'hide' => array(
                'type' => 'INT'
            ),
            'callback' => array(
                'type' => 'VARCHAR',
                'constraint' => '256',
            ),
            'choices' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024'
            ),
            'need_backinfo' => array(
                'type' => 'INT'
            )
        );
        var_dump($fields);
        echo "<br/>";
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('message');
        echo "message创建成功<br/>";
    }
}
        