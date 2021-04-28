<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Stationfive
 * @since Stationfive 1.0
 */

get_header();
?>

	<main>

		<div class="container-fluid" id="donation-form">
			<div class="row">
				<div class="col-12">

					<?php get_template_part( 'template-parts/home/donation-form' ); ?>

				</div>
			</div>
		</div>

		<div class="container-fluid" id="donation-details">
			<div class="row">
				<div class="col-12">

					<?php get_template_part( 'template-parts/home/donation-details' ); ?>

				</div>
			</div>
		</div>

	</main>
	
<?
get_footer();
