<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

interface TagInterface {

	const DIV = 'div';
	const SPAN = 'span';
	const P = 'p';
	const A = 'a';
	const LABEL = 'label';
	const LEGEND = 'legend';

	/**
	 * @param string $context
	 * @param string $tag
	 * @param array<string|bool> $attr
	 * @param bool $is_void
	 * @return string
	 */
	public function open( string $context, string $tag, array $attr = [], $is_void = false ): string;

	/**
	 * @param string $context
	 * @return string
	 */
	public function close( string $context ): string;

	/**
	 * @param string $context
	 * @param string $tag
	 * @param array<string|bool> $attr
	 * @return string
	 */
	public function void( string $context, string $tag, array $attr = [] ): string;
}
