<?php

    require_once( 'connect.php' );

    class Blog {

        public $data, $post;
        
        /*
         * $this->data as multi-dimensional array
         * $this->post as stdClass
         * $this->post->get as dynamic function
         * $this->post->create as dynamic function
         * $this->post->comment as dynamic function
         */

        public function __construct() {
            
            $this->post = new stdClass();
            
            $this->post->get = function($post_id) {

                $data = mysql_fetch_assoc( mysql_query( "SELECT * FROM `blog_posts` WHERE `id` = '$post_id'" ) );

                if( $data ):
				
			$user_id = $data['author_id'];
			$author = mysql_fetch_assoc( mysql_query( "SELECT * FROM `users` WHERE `id` = '$user_id'" ) );

			$comments = array(  );

			if( ( (int) $data['post_comments'] ) !== 0 ):

				$select_comments = mysql_query( "SELECT * FROM `blog_comments` WHERE `post_id` = '$post_id'" );
				while ( $row = mysql_fetch_assoc( $select_comments ) ):
					$user_id = $row['author_id'];
					$commentor = mysql_fetch_assoc( mysql_query( "SELECT * FROM `users` WHERE `id` = '$user_id'" ) );
					$comment = array(
						'author' => $commentor['username'],
						'content' => $row['comment_content']
					);
					$comments[] = $comment;
				endwhile;
						
			endif;
					
			$post = new stdClass();
					
			$post->data = array(
				'id' => $data['id'],
				'author' => $author['username'],
				'title' => $data['post_title'],
				'content' => $data['post_content'],
				'comments' => $comments,
				'posted' => strtotime( $data['post_date'] )
			);
					
			$post->comment = function($data, $author, $content) {
				$this->post->comment( $data['id'], $author, $content );
			};
					
			return $post;
					
		else:
				
			return false;
				
		endif;
            };
            
            $this->post->create = function($author, $title, $content) {
		
		$title = str_replace("'", "\'", $title);
                $content = str_replace("'", "\'", $content);
                mysql_query( "INSERT INTO `blog_posts` (`id`, `author_id`, `post_date`, `post_title`, `post_content`, `post_comments`) VALUES (NULL, '$author', CURRENT_TIMESTAMP, '$title', '$content', '0')" );
            };
            
            $this->post->comment = function($post_id, $author, $content) {

		$content = str_replace("'", "\'", $content);
                $post = mysql_fetch_assoc( mysql_query( "SELECT * FROM `blog_posts` WHERE `id` = '$post_id'" ) );
                if( $post ) {
			$comments = ( (int) $post['post_comments'] ) + 1; 
			mysql_query( "UPDATE `blog_posts` SET `post_comments` = '$comments' WHERE `id` = '$post_id'" );
			mysql_query( "INSERT INTO `blog_comments` (`id`, `post_id`, `author_id`, `comment_content`) VALUES (NULL, '$post_id', '$author', '$content')" );
		} else {
			return false;
		}
            };
            
            $this->data = array(  );
            $select_posts = mysql_query( "SELECT * FROM `blog_posts`" );
            while ( $row = mysql_fetch_assoc( $select_posts ) ):
                
                $post = $this->post->get->__invoke( $row['id'] );
                $this->data['posts'][] = $post;
            
            endwhile;
        }
    }

?>
