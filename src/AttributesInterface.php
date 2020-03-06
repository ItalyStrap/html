<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

interface AttributesInterface {

	const ID = 'id';
	const CLASS_NAME = 'class';
	const STYLE = 'style';
	const TITLE = 'title';
	const TYPE = 'type';
	const VALUE = 'value';
	const PLACEHOLDER = 'placeholder';

	/**
	 * @param string $context
	 * @param array<string|bool> $attr
	 * @return AttributesInterface
	 */
	public function add( string $context, array $attr );

	/**
	 * @param string $context
	 * @return array<string|bool>
	 */
	public function get( string $context );

	/**
	 * @param string $context
	 * @return bool
	 */
	public function has( string $context ): bool;

	/**
	 * @param string $context
	 * @return AttributesInterface
	 */
	public function remove( string $context );

	/**
	 * Build list of attributes into a string and apply contextual filter on string.
	 *
	 * The contextual filter is of the form `italystrap_attr_{context}_output`.
	 *
	 * @param  string $context The context, to build filter name.
	 * @param  mixed  $args    Optional. Extra arguments in case is needed.
	 * @return string          String of HTML attributes and values.
	 */
	public function render( string $context, $args = null ): string;
}
