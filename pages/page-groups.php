<?php
/**
 * Template Name: Groups
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

get_header(); ?>
	
	<div id="groups-overview">
		<h2 class="group-title"><?php _e( 'Groups', 'noteboard' ); ?></h2>
		
		<?php if ( false !== ( $groups = noteboard_get_groups() ) ) : ?>
			<ul>
				<?php foreach ( $groups as $group ) : ?>
					<li class="group">
						<a href="<?php echo get_term_link( $group, 'group' ); ?>">
							<strong><?php echo esc_attr( $group->description ); ?></strong>
							<small><?php printf( __( '%d Notes', 'noteboard' ), count( get_objects_in_term( $group->term_id, 'group' ) ) ); ?></small>
						</a>
					</li>
				<?php endforeach; ?>
				<li class="group add-new">
					<a href="<?php echo esc_url( get_permalink( $noteboard->get( 'noteboard-groups-new' ) ) ); ?>">+</a>
				</li>
			</ul>
		<?php else : ?> 
		
		<?php endif; ?>
	</div>
		
<?php get_footer(); ?>