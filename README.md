Blog (PHP)
=
>Very simple blog backend, includes post & comment features.

Examples
=
```php
<?php
  include( 'blog.php' );
  
  $blog = new Blog();
  for( $i = sizeof( $blog->data['posts'] )-1; $i+1 > 0; $i-- ):
  	$title = $blog->data['posts'][$i]['post_title'];
  	echo( "<h2>Title: $title</h2>" );
  	$post = $blog->data['posts'][$i]['post_content'];
  	echo( "<p>$post</p><br />" );
  endfor; // output all posts
  
  $blog->post->create->_invoke( AUTHOR_ID, 'title', 'content' ); // create new post
  
  $post = $blog->post->get->_invoke( POST_ID ); // get post data as array
  
  $blog->post->comment->_invoke( POST_ID, AUTHOR_ID, 'content' ); // comment on existing post
  
  $comment = $blog->comment->get->_invoke( COMMENT_ID ); // get comment data as array
?>
```

