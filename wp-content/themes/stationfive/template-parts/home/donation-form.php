<?php
/**
 * The main template is used to display the donation form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Stationfive
 * @since Stationfive 1.0
 */

$form  = get_field( 'donation_form' );
$nonce = wp_create_nonce( 'donation-form' );

$current_amount = 0;

$donations_args = array(  
	'post_type'      => 'donations',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
);

$donations = new WP_Query( $donations_args ); 

if ( ! is_wp_error( $donations ) ) :
	while ( $donations->have_posts() ) : $donations->the_post(); 
		$id = get_the_ID();

		$current_amount += get_field( 'amount', $id );
	endwhile;
endif;

$current_amount = number_format( $current_amount );

wp_reset_postdata(); 
?>
	<div class="donation-area">
		<div class="donation-area__title-heading">
			<h1 class="text-white font-heading"><?php echo esc_html( get_field( 'page_title' ) ); ?></h1>
			<p class="text-white"><?php echo wp_kses_post( get_field( 'page_description' ) ); ?></p>

			<?php if ( isset( $_GET['success'] ) ) :?>
				<div class="alert alert-success" role="alert">
					<?php esc_html_e( 'Thank you for donating with us. ', 'stationfive' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-danger">Go back</a>
				</div>
			<?php endif; ?>

			<?php if ( isset( $_GET['error'] ) ) :?>
				<div class="alert alert-danger" role="alert">
					<?php esc_html_e( 'Oops! Something went wrong. Please try again.', 'stationfive' ); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="donation-area__form-area">
			<p class="donation-area__form-area__subheading text-center font-heading">
				<strong><?php echo esc_html( $form['form_heading'] ); ?></strong>
			</p>
			<p class="donation-area__form-area__amount text-center text-primary">
				<?php echo esc_html( $form['currency'] ); ?>
				<span class="animate-count .numbers-with-commas"><?php echo esc_html( $current_amount ); ?></span>
			</p>
			<p class="donation-area__form-area__total-figure text-center">
				<?php echo esc_html( $form['currency_description'] ); ?>
			</p>
			<div class="donation-area__form-area__percentage-bar">
				<div class="bar"><span class="bg-primary"></span></div>
			</div>
			<div class="donation-area__form">
				<form action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>" method="POST">
					<input type="hidden" id="donation-total-figure" value="<?php echo esc_attr( $form['goal_amount'] ); ?>" />
					<input type="hidden" name="action" value="save_my_custom_form" />
					<input type="hidden" name="nonce" value="<?php echo esc_attr( $nonce ); ?>" />

					<div class="form-group donation-area__form__amount mb-5">
						<div class="input-group">
							<label class="input-group-text" id="amount-addon" for="donation-amount"><?php echo esc_html( $form['currency'] ); ?></label>
							<input type="number" min="<?php echo esc_attr( $form['minimum_donation_amount'] ); ?>" class="form-control" id="donation-amount" name="donation_amount" placeholder="<?php esc_html_e( 'amount', 'stationfive' ); ?>" aria-label="<?php esc_html_e( 'amount', 'stationfive' ); ?>" aria-describedby="amount-addon" required>
						</div>
						<p class="text-center"><?php echo wp_kses_post( $form['form_description'] ); ?></p>
					</div>
					<div class="form-group">
						<p class="form-heading font-heading"><strong><?php esc_html_e( 'Select payment method', 'stationfive' ); ?></strong></p>
						<hr />
						<?php if ( $form['payment_methods'] ) : ?>
							<div class="form-check">
								<?php foreach ( $form['payment_methods'] as $km => $method ) : ?>
									<div class="check-area">
										<input class="form-check-input" type="radio" name="donation_method" value="<?php echo esc_html( $method['method'] ); ?>" id="<?php echo esc_attr( 'donation-method-' . $km ); ?>" <?php echo esc_attr( 0 === $km ? 'checked' : '' );?>>
										<label class="form-check-label" for="<?php echo esc_attr( 'donation-method-' . $km ); ?>">
											<?php echo esc_html( $method['method'] ); ?>
										</label>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="form-group donation-area__form__fields row mt-4 pt-2">
						<div class="col-12">
							<p class="form-heading font-heading"><strong><?php esc_html_e( 'Personal Information', 'stationfive' ); ?></strong></p>
							<hr />
						</div>
						<div class="col-6 odd">
							<input type="text" name="first_name" class="form-control" placeholder="<?php esc_html_e( 'First name*', 'stationfive' ); ?>" aria-label="<?php esc_html_e( 'First name', 'stationfive' ); ?>" required>
						</div>
						<div class="col-6 even">
							<input type="text" name="last_name" class="form-control" placeholder="<?php esc_html_e( 'Last name*', 'stationfive' ); ?>" aria-label="<?php esc_html_e( 'Last name', 'stationfive' ); ?>" required>
						</div>
						<div class="col-6 odd">
							<input type="email" name="email_address" class="form-control" placeholder="<?php esc_html_e( 'Email*', 'stationfive' ); ?>" aria-label="<?php esc_html_e( 'Email', 'stationfive' ); ?>" required>
						</div>
						<div class="col-6 even">
							<input type="number"  name="phone_number" class="form-control" placeholder="<?php esc_html_e( 'Phone*', 'stationfive' ); ?>" aria-label="<?php esc_html_e( 'Phone', 'stationfive' ); ?>" required>
						</div>
					</div>
					<div class="form-group donation-area__form__total">
						<div class="input-group">
							<span class="input-group-text" id="basic-addon1"><?php esc_html_e( 'Donation in total:', 'stationfive' ); ?></span>
							<span class="form-control"><?php echo esc_html( $form['currency'] ); ?><span class="total-mirror">0.00</span></span>
						</div>
						<p class="text-center mt-4">
							<button type="submit" class="btn btn-primary text-center"><?php esc_html_e( 'DONATE NOW', 'stationfive' ); ?></button>
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
