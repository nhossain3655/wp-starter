<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starter
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if (is_active_sidebar('footer')) : ?>

			<div class="footer-top-area">
				<div class="container">
					<div class="d-flex flex-row flex-column align-items-center <?php /* echo esc_attr( $widget_aligns ) */ ?> flex-wrap">
						<?php dynamic_sidebar('footer') ?>
					</div>
				</div>
			</div>
			
		<?php endif; ?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'starter' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'starter' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'starter' ), 'starter', '<a href="https://www.techdevo.com">Nazmul Hossain</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
