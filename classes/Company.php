<?php
/**
 * Company
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-2.0-or-later
 * @package   Pronamic\Orbis\Companies
 */

namespace Pronamic\Orbis\Companies;

/**
 * Company class
 */
class Company {
	private $post;

	
	/**
	 * Constructs and initialize an Orbis plugin
	 *
	 * @param string $file
	 */
	public function __construct( $post = null ) {
		$this->post = get_post( $post );
	}

	public function get_email() {
		return get_post_meta( $this->post->ID, '_orbis_email', true );
	}

	public function get_address() {
		$address           = new Orbis_Address();
		$address->address  = get_post_meta( $this->post->ID, '_orbis_address', true );
		$address->postcode = get_post_meta( $this->post->ID, '_orbis_postcode', true );
		$address->city     = get_post_meta( $this->post->ID, '_orbis_city', true );
		$address->country  = get_post_meta( $this->post->ID, '_orbis_country', true );

		return $address;
	}
}
