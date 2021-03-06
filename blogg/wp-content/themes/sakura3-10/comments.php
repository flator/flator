<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.<p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'Alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
	<h3 class="respond">
<?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;
	</h3>

	<div class="CommentList">

	<?php foreach ($comments as $comment) : ?>

<div class="entryBox<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
	<p class="who"><?php comment_author_link() ?> Says:</p>
<div class="entryDescription">
		<?php if ($comment->comment_approved == '0') : ?>

	
		<p>
	<em>Your comment is awaiting moderation.</em>
		</p>

	<?php endif; ?>
		<?php comment_text() ?>
	</div><!-- end .entryDescription -->

	<div class="entryBottom">
		<p class="commentmetadata">
	<a href="#comment-<?php comment_ID() ?>" title="">
	<?php comment_date('F jS, Y') ?> at 
	<?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?>
		</p><!-- end .commentmetadata -->
	</div><!-- end .entryBottom -->

</div><!-- end .entryBox<?php echo $oddcomment; ?> -->

	<?php /* Changes every other comment to a different class */
		if ('Alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'Alt';
	?>
	
	<?php endforeach; /* end for each comment */ ?>

</div><!-- end .CommentList -->

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<h3 class="respond">Comments are closed.</h3>


	<?php endif; ?>

<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 class="respond">Leave a Reply</h3>

<div id="commentForm">

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p>
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="45" tabindex="1" />
<label for="author">Name <?php if ($req) echo "(required)"; ?></label>
</p>

<p>
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="45" tabindex="2" />
<label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label>
</p>

<p>
<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="45" tabindex="3" />
<label for="url">Website</label>
</p>

<?php endif; ?>

<p>
<strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?>
</p>

<p>
<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
</p>

<p>
<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>

<?php do_action('comment_form', $post->ID); ?>

</form>

</div><!-- end #commentForm -->

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
