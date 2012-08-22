<li class="note">
	<?php if ( '' != get_the_title( $post->ID ) ) : ?>
		<h3 class="title"><?php the_title(); ?></h3>
	<?php endif; ?>
	
	<?php echo wp_trim_words( apply_filters( 'the_content', get_the_content( '' ) ), 40 ); ?>
	<a href="<?php the_permalink(); ?>" class="click-through"></a>
</li>