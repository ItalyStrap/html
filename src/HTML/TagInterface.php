<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

interface TagInterface
{
	/**
	 * @param string $context
	 * @param string $tag
	 * @param array $attr
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
	 * @param array $attr
	 * @return string
	 */
	public function void( string $context, string $tag, array $attr = [] ): string;
}