Blog (PHP)
=
>Very simple blog backend, includes post & comment features.

Examples
=
```php
<?php

  include( 'blog.php' );
  
  $blog = new Blog();
  foreach( $blog->data['posts'] as $post ):
  	$title = $post['post_title'];
  	echo( "<h2>Title: $title</h2>" );
  	$content = $post['post_content'];
  	echo( "<p>$content</p><br />" );
  endforeach; // output all posts
  
  $blog->post->create->_invoke( AUTHOR_ID, 'title', 'content' ); // create new post
  
  $post = $blog->post->get->_invoke( POST_ID ); // get post data as array
  
  $blog->post->comment->_invoke( POST_ID, AUTHOR_ID, 'content' ); // comment on existing post
  
  $comment = $blog->comment->get->_invoke( COMMENT_ID ); // get comment data as array
  
?>
```

