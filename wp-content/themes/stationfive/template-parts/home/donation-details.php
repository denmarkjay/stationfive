<?php
/**
 * The main template is used to display the donation details.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Stationfive
 * @since Stationfive 1.0
 */

?>

<div class="container">

	<div class="row">
		<div class="col-12 col-md-5 background-poster" style="<?php if ( get_field( 'donatin_details_poster' ) ) { echo esc_html( 'background-image: url(' . esc_url( get_field( 'donatin_details_poster' ) ) . ')' ); } ?>">
		</div>

		<div class="col-12 col-md-7 d-flex donation-content">
			<div class="d-block inner position-relative">
				<div class="dotted"></div>
				<div class="arrow right"></div>
				<div class="arrow left"></div>
				<h5 class="font-heading mb-4"><?php echo wp_kses_post( get_field( 'donation_details_heading' ) ); ?></h5>
				<p><?php echo wp_kses_post( get_field( 'donation_details_heading' ) ); ?></p>
			</div>
		</div>
	</div>
</div>
