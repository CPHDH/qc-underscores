<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package QC_Underscores
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<?php if(comments_open()):?>
<div id="qc-comment-prompt">
	<h2><?php echo qc_sprite('comments');?>Tell us about <?php echo get_the_title();?></h2>
	<p>Many of the locations documented on Queer Cleveland are not well-documented in the historical record. If you have additional information about <?php echo get_the_title();?>, please let us know by sharing a memory, correction, or suggestion using the comment form below.</p>
	<p><em>Or send an email to <a href="mailto:info@queerclevelandhistories.org?subject=Queer%20Cleveland:%20<?php echo str_replace(' ', '%20', get_the_title());?>&body=%0A<?php echo get_the_permalink();?>">info@queerclevelandhistories.org</a>.</em></p>
</div>
<?php endif;?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$qc_underscores_comment_count = get_comments_number();
			if ( '1' === $qc_underscores_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'qc-underscores' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $qc_underscores_comment_count, 'comments title', 'qc-underscores' ) ),
					number_format_i18n( $qc_underscores_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'qc-underscores' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().
	?>
	
	<?php
	comment_form();
	?>

</div><!-- #comments -->
