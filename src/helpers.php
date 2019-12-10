<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

if ( ! function_exists( __NAMESPACE__ . '\get_attr' ) ) {

	/**
	 * Build list of attributes into a string and apply contextual filter on string.
	 *
	 * The contextual filter is of the form `italystrap_attr_{context}_output`.
	 *
	 * @param string $context The context, to build filter name.
	 * @param array $attr Optional. Extra attributes to merge with defaults.
	 * @param bool $echo True for echoing or false for returning the value.
	 *                            Default false.
	 * @param null $args Optional. Extra arguments in case is needed.
	 *
	 * @return string String of HTML attributes and values.
	 */
	function get_attr( string $context, array $attr = [], $echo = false, $args = null ): string {

		$obj = new Attributes();

		$obj->add( $context, $attr );

		if ( $echo ) {
			_deprecated_argument( __FUNCTION__, '1.1.0', 'Use get_attr_e() for printing attributes' );
			echo $obj->render( $context, $args );
			return '';
		}

		return $obj->render( $context, $args );
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

/**
 * @return Tag
 */
if ( ! \function_exists( __NAMESPACE__ . '\tag' ) ) {
	function tag(): Tag {

		static $tag = null;

		if ( ! $tag ) {
			$tag = new Tag( new Attributes() );
		}

		return $tag;
	}
}

/**
 * @param string $context
 * @param string $tag
 * @param array $attr
 * @param bool $is_void
 * @return string
 */
if ( ! \function_exists( __NAMESPACE__ . '\open_tag' ) ) {
	function open_tag( string $context, string $tag, array $attr = [] ) : string {
		return tag()->open( ...\func_get_args() );
	}
}

/**
 * @param string $context
 * @param string $tag
 * @param array $attr
 * @param bool $is_void
 */
if ( ! \function_exists( __NAMESPACE__ . '\open_tag_e' ) ) {
	function open_tag_e( string $context, string $tag, array $attr = [] ) {
		echo tag()->open( ...\func_get_args() );
	}
}

/**
 * @param string $context
 * @return string
 */
if ( ! \function_exists( __NAMESPACE__ . '\close_tag' ) ) {
	function close_tag( string $context ) : string {
		return tag()->close( $context );
	}
}

/**
 * @param string $context
 */
if ( ! \function_exists( __NAMESPACE__ . '\close_tag_e' ) ) {
	function close_tag_e( string $context ) {
		echo tag()->close( $context );
	}
}

/**
 * @param string $context
 * @param string $tag
 * @param array $attr
 * @return string
 */
if ( ! \function_exists( __NAMESPACE__ . '\void_tag' ) ) {
	function void_tag( string $context, string $tag, array $attr = [] ) : string {
		return tag()->void( ...\func_get_args() );
	}
}

/**
 * @param string $context
 * @param string $tag
 * @param array $attr
 */
if ( ! \function_exists( __NAMESPACE__ . '\void_tag_e' ) ) {
	function void_tag_e( string $context, string $tag, array $attr = [] ) {
		echo tag()->void( ...\func_get_args() );
	}
}

if ( ! function_exists( 'ItalyStrap\HTML\is_HTML' ) ) {

	/**
	 * https://subinsb.com/php-check-if-string-is-html/
	 *
	 * @param  string $string
	 *
	 * @return bool
	 */
	function is_HTML( string $string ): bool {
		return $string !== \strip_tags( $string );
	}
}
