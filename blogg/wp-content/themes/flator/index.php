
<?php get_header(); ?>	


	
	
		<div id="content-wrapper">
		
			<div id="content">
			
			
				<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>

		
				<div class="post-wrapper">
				

				

				
			<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<div> <?php the_author() ?> | Kategori: <?php the_category(', ') ?> | <?php the_time('Y-m-d') ?> <strong>|</strong> <?php comments_popup_link('Inga kommentarer &raquo;', '1 kommentar &raquo;', '% kommentarer &raquo;'); ?></div>

<div style="clear: both;"></div>

			<div class="post">

			<?php the_content('Läs fortsättningen &raquo;'); ?>

			</div>
			
			</div>

			<?php comments_template(); ?>

			<?php endwhile; ?>

			   <p class="pagination"><?php next_posts_link('&laquo; Föregående inlägg') ?> <?php previous_posts_link('Nästa inlägg &raquo;') ?></p>

			<?php else : ?>

			<h2 align="center">Not Found</h2>

			<p align="center">Sorry, but you are looking for something that isn't here.</p>

			<?php endif; ?>
			
			
	
			</div>
		
		</div>
		<?php get_sidebar(); ?>    
		<?php get_footer(); ?>   
	
</body>
</html>