<?php

global $post;

$orbis_company = new Orbis_Company( $post );

$orbis_id = get_post_meta( $post->ID, '_orbis_company_id', true );

$kvk_number = get_post_meta( $post->ID, '_orbis_kvk_number', true );
$vat_number = get_post_meta( $post->ID, '_orbis_vat_number', true );

$email               = get_post_meta( $post->ID, '_orbis_email', true );
$accounting_email    = get_post_meta( $post->ID, '_orbis_accounting_email', true );
$invoice_email       = get_post_meta( $post->ID, '_orbis_invoice_email', true );
$invoice_header_text = get_post_meta( $post->ID, '_orbis_invoice_header_text', true );
$invoice_footer_text = get_post_meta( $post->ID, '_orbis_invoice_footer_text', true );
$website             = get_post_meta( $post->ID, '_orbis_website', true );

$address  = get_post_meta( $post->ID, '_orbis_address', true );
$postcode = get_post_meta( $post->ID, '_orbis_postcode', true );
$city     = get_post_meta( $post->ID, '_orbis_city', true );
$country  = get_post_meta( $post->ID, '_orbis_country', true );

$iban = get_post_meta( $post->ID, '_orbis_iban', true );

$company_twitter  = get_post_meta( $post->ID, '_orbis_twitter', true );
$company_facebook = get_post_meta( $post->ID, '_orbis_facebook', true );
$company_linkedin = get_post_meta( $post->ID, '_orbis_linkedin', true );

wp_nonce_field( 'orbis_save_company_details', 'orbis_company_details_meta_box_nonce' );

?>
<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_company_id"><?php esc_html_e( 'Orbis ID', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="orbis_company_id" name="_orbis_company_id" value="<?php echo esc_attr( $orbis_id ); ?>" type="text" class="regular-text" readonly="readonly" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="orbis_company_kvk_number"><?php esc_html_e( 'Registration Number', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="orbis_company_kvk_number" name="_orbis_kvk_number" value="<?php echo esc_attr( $kvk_number ); ?>" type="text" size="20" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="orbis_company_vat_number"><?php esc_html_e( 'VAT Number', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="orbis_company_vat_number" name="_orbis_vat_number" value="<?php echo esc_attr( $vat_number ); ?>" type="text" size="20" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="orbis_company_email"><?php esc_html_e( 'E-Mail', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="orbis_company_email" name="_orbis_email" value="<?php echo esc_attr( $orbis_company->get_email() ); ?>" type="email" size="42" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="_orbis_invoice_email"><?php esc_html_e( 'Accounting E-Mail', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="_orbis_invoice_email" name="_orbis_accounting_email" value="<?php echo esc_attr( $accounting_email ); ?>" type="email" size="42" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="_orbis_invoice_email"><?php esc_html_e( 'Invoice E-Mail', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="_orbis_invoice_email" name="_orbis_invoice_email" value="<?php echo esc_attr( $invoice_email ); ?>" type="email" size="42" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="_orbis_invoice_header_text"><?php esc_html_e( 'Invoice Header Text', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<textarea id="_orbis_invoice_header_text" name="_orbis_invoice_header_text" rows="2" cols="60"><?php echo esc_textarea( $invoice_header_text ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="_orbis_invoice_footer_text"><?php esc_html_e( 'Invoice Footer Text', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<textarea id="_orbis_invoice_footer_text" name="_orbis_invoice_footer_text" rows="2" cols="60"><?php echo esc_textarea( $invoice_footer_text ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="orbis_company_website"><?php esc_html_e( 'Website', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="orbis_company_website" name="_orbis_website" value="<?php echo esc_attr( $website ); ?>" type="url" size="42" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="orbis_company_address"><?php esc_html_e( 'Address', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input id="orbis_company_address" name="_orbis_address" placeholder="<?php echo esc_attr( __( 'Address', 'orbis-companies' ) ); ?>" value="<?php echo esc_attr( $address ); ?>" type="text" size="42" />
				<br />
				<input id="orbis_company_postcode" name="_orbis_postcode" placeholder="<?php echo esc_attr( __( 'Postcode', 'orbis-companies' ) ); ?>" value="<?php echo esc_attr( $postcode ); ?>" type="text" size="10" />
				<input id="orbis_company_city" name="_orbis_city" placeholder="<?php echo esc_attr( __( 'City', 'orbis-companies' ) ); ?>" value="<?php echo esc_attr( $city ); ?>" type="text" size="25" />
				<br />
				<input id="orbis_company_country" name="_orbis_country" placeholder="<?php echo esc_attr( __( 'Country', 'orbis-companies' ) ); ?>" value="<?php echo esc_attr( $country ); ?>" type="text" size="42" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_iban"><?php _e( 'IBAN', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input type="text" id="orbis_iban" name="_orbis_iban" value="<?php echo esc_attr( $iban ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_company_twitter"><?php esc_html_e( 'Twitter Username:', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input type="text" id="orbis_company_twitter" name="_orbis_twitter" value="<?php echo esc_attr( $company_twitter ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_company_facebook"><?php esc_html_e( 'Facebook URL:', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input type="text" id="orbis_company_facebook" name="_orbis_facebook" value="<?php echo esc_attr( $company_facebook ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_company_linkedin"><?php esc_html_e( 'LinkedIn URL:', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<input type="text" id="orbis_company_linkedin" name="_orbis_linkedin" value="<?php echo esc_attr( $company_linkedin ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_company_payment_method"><?php esc_html_e( 'Payment Method', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<?php

				$terms = get_the_terms( $post->ID, 'orbis_payment_method' );

				$term = ( ! $terms ) ? $terms : array_shift( $terms );

				wp_dropdown_categories(
					[
						'name'             => 'tax_input[orbis_payment_method]',
						'show_option_none' => __( '— Select Payment Method —', 'orbis-companies' ),
						'hide_empty'       => false,
						'selected'         => is_object( $term ) ? $term->term_id : false,
						'taxonomy'         => 'orbis_payment_method',
					] 
				);

				?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="orbis_company_invoice_shipping_method"><?php esc_html_e( 'Invoice Shipping Method', 'orbis-companies' ); ?></label>
			</th>
			<td>
				<?php

				$terms = get_the_terms( $post->ID, 'orbis_invoice_shipping_method' );

				$term = ( ! $terms ) ? $terms : array_shift( $terms );

				wp_dropdown_categories(
					[
						'name'             => 'tax_input[orbis_invoice_shipping_method]',
						'show_option_none' => __( '— Select Invoice Shipping Method —', 'orbis-companies' ),
						'hide_empty'       => false,
						'selected'         => is_object( $term ) ? $term->term_id : false,
						'taxonomy'         => 'orbis_invoice_shipping_method',
					] 
				);

				?>
			</td>
		</tr>
	</tbody>
</table>
