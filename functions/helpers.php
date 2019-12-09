<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

if ( ! function_exists( __NAMESPACE__ . '\get_attr' ) ) {

	/**
	 * Build list of attributes into a string and apply contextual filter on string.
	 *
	 * The contextual filter is of the form `italystrap_attr_{context}_output`.
	 *
	 * @param  string $context    The context, to build filter name.
	 * @param  array  $attr Optional. Extra attributes to merge with defaults.
	 * @param  bool   $echo       True for echoing or false for returning the value.
	 *                            Default false.
	 * @param  null   $args       Optional. Extra arguments in case is needed.
	 *
	 * @return string|void String of HTML attributes and values.
	 */
	function get_attr( string $context, array $attr = [], $echo = false, $args = null ): string {

		$obj = new Attributes();

		$obj->add( $context, $attr );

		if ( ! $echo ) {
			return $obj->render( $context, $args );
		}

		echo $obj->render( $context, $args );
	}
}
if ( ! function_exists( __NAMESPACE__ . '\get_attr_e' ) ) {

	/**
	 * Build list of attributes into a string and apply contextual filter on string.
	 *
	 * The contextual filter is of the form `italystrap_attr_{context}_output`.
	 *
	 * @since 1.0.0
	 *
	 * @see In general-function on the plugin.
	 *
	 * @param  string $context    The context, to build filter name.
	 * @param  array  $attr Optional. Extra attributes to merge with defaults.
	 * @param  null   $args       Optional. Extra arguments in case is needed.
	 */
	function get_attr_e( string $context, array $attr = [], $args = null ) {
		echo get_attr( $context, $attr, false, $args );
	}
}