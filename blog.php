<?php

    require_once( 'connect.php' );

    class Blog {

        public $data;
        public $post, $comment;

        public function __construct() {

            $this->data = array();
            $select_posts = mysql_query( "SELECT * FROM `blog_posts`" );
            while ( $row = mysql_fetch_assoc( $select_posts ) ):
                $this->data['posts'][] = $row;
            endwhile;

            $this->post = new stdClass();
            $this->post->get = function($post_id) {

                $post = mysql_fetch_assoc( mysql_query( "SELECT * FROM `blog_posts` WHERE `id` = '$post_id'" ) );

                if( !$post ):
                    return false;
                endif;

                $user_id = $post['author_id'];
                $author = mysql_fetch_assoc( mysql_query( "SELECT * FROM `users` WHERE `id` = '$user_id'" ) );

                $comments = false; // initialize

                if( ( (int) $post['post_comments'] ) !== 0 ):

                    $comments = array();
                    $select_comments = mysql_query( "SELECT * FROM `blog_comments`" );
                    while ( $row = mysql_fetch_assoc( $select_comments ) ):
                        if ($row['post_id'] == $post_id):
                            $user_id = $row['author_id'];
                            $author = mysql_fetch_assoc( mysql_query( "SELECT * FROM `users` WHERE `id` = '$user_id'" ) );
                            $comment = array(
                                'author' => $author['username'],
                                'content' => $row['comment_content']
                            );
                            $comments[] = $comment;
                        endif;
                    endwhile;
                endif;

                $data = array(
                    'author' => $author['username'],
                    'title' => $post['post_title'],
                    'content' => $post['post_content'],
                    'comments' => $comments,
                    'posted' => strtotime($post['post_date'])
                );

                return $data;
            };
            $this->post->create = function($author, $title, $content) {

                mysql_query( "INSERT INTO `blog_posts` (`id`, `author_id`, `post_date`, `post_title`, `post_content`, `post_comments`) VALUES (NULL, '$author', CURRENT_TIMESTAMP, '$title', '$content', '0')" );
            };
            $this->post->comment = function($post_id, $author, $content) {

                $post = mysql_fetch_assoc( mysql_query( "SELECT * FROM `blog_posts` WHERE `id` = '$post_id'" ) );
                if( !$post ):
                    return;
                endif;
                $comments = ( (int) $post['post_comments'] ) + 1; 
                mysql_query( "UPDATE `blog_posts` SET `post_comments` = '$comments' WHERE `id` = '$post_id'" );
                mysql_query( "INSERT INTO `blog_comments` (`id`, `post_id`, `author_id`, `comment_content`) VALUES (NULL, '$post_id', '$author', '$content')" );
            };

            $this->comment = new stdClass();
            $this->comment->get = function($comment_id) {

                $comment = mysql_fetch_assoc( mysql_query( "SELECT * FROM `blog_comments` WHERE `id` = '$comment_id'" ) );

                if( !$comment ):
                    return false;
                endif;

                $user_id = $comment['author_id'];
                $author = mysql_fetch_assoc( mysql_query( "SELECT * FROM `users` WHERE `id` = '$user_id'" ) );

                $data = array(
                    'author' => $author['username'],
                    'content' => $comment['comment_content']
                );

                return $data;
            };
        }
    }

?>