<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

interface AttributesInterface {

	/**
	 * @param string $context
	 * @param array $attr
	 * @return $this
	 */
	public function add( string $context, array $attr );

	/**
	 * @param string $context
	 * @return mixed
	 */
	public function get( string $context );

	/**
	 * @param string $context
	 * @return bool
	 */
	public function has( string $context ): bool;

	/**
	 * @param string $context
	 * @return self
	 */
	public function remove( string $context );

	/**
	 * Build list of attributes into a string and apply contextual filter on string.
	 *
	 * The contextual filter is of the form `italystrap_attr_{context}_output`.
	 *
	 * @param  string $context The context, to build filter name.
	 * @param  null   $args    Optional. Extra arguments in case is needed.
	 * @return string          String of HTML attributes and values.
	 */
	public function render( string $context, $args = null ): string;
}
