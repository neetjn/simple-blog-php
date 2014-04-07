<?php

class Blog {
    
    public $post_count=0, $posts=null;
    
    public function __construct() {
         
        $this->fetch_data();
    }
    
    public function fetch_data() {
        
        $sql = "SELECT * FROM blog_posts";
        $query = mysql_query($sql);
        $temp = array();
        while ($row = mysql_fetch_assoc($query)) {
            $temp[] = $row;
        }
        $this->posts=$temp;
        $this->post_count=sizeof($temp);
    }
    
    public function Post($user_id, $title, $content) {
        
        $sql = "INSERT INTO `blog_posts` (`id`, `author_id`, `post_date`, `post_title`, `post_content`, `post_comments`) VALUES (NULL, '$user_id', CURRENT_TIMESTAMP, '$title', '$content', '0')";
        $query = mysql_query($sql);
    }
}

class Post {
    
    public $data=null, $author=null;
    
    public function __construct($id) {
        
        $this->fetch_data($id);
    }
    
    public function fetch_data($id) {
        
        $sql = "SELECT * FROM blog_posts WHERE id='$id'";
        $query = mysql_query($sql);
        $this->data = mysql_fetch_assoc($query);
        $this->author=$this->Author($this->data['author_id']);
    }
    
    private function Author($user_id) {
        
        $sql = "SELECT * FROM users WHERE id='$user_id'";
        $query = mysql_query($sql);
        $_user=mysql_fetch_assoc($query);
        return $_user['username'];
    }
    
    public function Comment($user_id, $content) {
        
        $post_id = $this->data['post_id'];
        $sql = "INSERT INTO `blog_comments` (`id`, `post_id`, `author_id`, `comment_content`) VALUES (NULL, '$post_id', '$user_id', '$content')";
        $query = mysql_query($sql);
    }
}

class Comment {
    
    public $data=null, $author=null;
    
    public function __construct($id) {
        
        $this->fetch_data($id);
    }
    
    public function fetch_data($id) {
        
        $sql = "SELECT * FROM blog_comments WHERE id='$id'";
        $query = mysql_query($sql);
        $this->data = mysql_fetch_assoc($query);
        $this->author=$this->Author($this->data['author_id']);
    }
    
    private function Author($user_id) {
        
        $sql = "SELECT * FROM users WHERE id='$user_id'";
        $query = mysql_query($sql);
        $_user=mysql_fetch_assoc($query);
        return $_user['username'];
    }
}