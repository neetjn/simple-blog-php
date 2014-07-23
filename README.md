Blog (PHP)
=
>A very simple and lightweight blog backend.
Examples
=
```php
<?php

  include( 'blog.php' );
  
  $blog = new Blog();
  foreach( $blog->data['posts'] as $post ):
  	$title = $post->data['post_title'];
  	echo( "<h2>Title: $title</h2>" );
  	$content = $post->data['post_content'];
  	echo( "<p>$content</p><br />" );
  	/*
  	 * interate through all post comments
  	 *
  	  
    	  foreach( $post->data['comments'] as $comment ):
    	    ...
    	  endforeach;
  	
  	 */
  endforeach; // output all posts
  
  $blog->post->create->_invoke( AUTHOR_ID, 'title', 'content' ); // create new post
  
  $post = $blog->post->get->_invoke( POST_ID ); // get post data as array
  
  $blog->post->comment->_invoke( POST_ID, AUTHOR_ID, 'content' ); // comment on existing post
  
?>
```

