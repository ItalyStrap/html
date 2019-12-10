<?php
declare(strict_types=1);

namespace ItalyStrap\HTML;

/**
 * Class Attributes
 * @package ItalyStrap\HTML
 */
class Attributes implements AttributesInterface
{
	/**
	 * @var array
	 */
	private $attributes = [];

	/**
	 * @inheritDoc
	 */
	public function add( string $context, array $attr ): Attributes {
		$this->attributes[ $context ] = $attr;
		return $this;
 	}

	/**
	 * @inheritDoc
	 */
	public function get( string $context ) {
		return $this->attributes[ $context ];
 	}

	/**
	 * @inheritDoc
	 */
	public function has( string $context ): bool {
		return \array_key_exists( $context, $this->attributes );
 	}

	/**
	 * @inheritDoc
	 */
	public function remove( string $context ) {
		unset( $this->attributes[ $context ] );
		return $this;
 	}

	/**
	 * @inheritDoc
	 */
	public function render( string $context, $args = null ): string {

		/**
		 * This filters the array with html attributes.
		 *
		 * @param  array  $attr    The array with all HTML attributes to render.
		 * @param  string $context The context in wich this functionis called.
		 * @param  null   $args    Optional. Extra arguments in case is needed.
		 *
		 * @var array
		 */
		$attr = (array) \apply_filters( "italystrap_{$context}_attr", $this->get( $context ), $context, $args );

		/**
		 * This filters the output of the html attributes.
		 *
		 * @param  string $html    The HTML attr output.
		 * @param  array  $attr    The array with all HTML attributes to render.
		 * @param  string $context The context in wich this functionis called.
		 * @param  null   $args    Optional. Extra arguments in case is needed.
		 *
		 * @var string
		 */
		$html = \apply_filters(
			"italystrap_attr_{$context}_output",
			$this->generateValidHtml( $attr ),
			$attr,
			$context,
			$args
		);

		$this->remove( $context );
		return \strval( $html );
 	}

	/**
	 * @param array $attr
	 * @return string
	 */
	private function generateValidHtml( array $attr ): string {

		/**
		 * @link https://www.php.net/manual/en/function.array-reduce.php#118254
		 */
		return \array_reduce( \array_keys( $attr ), function ( $html, $key ) use ( $attr ) {

			if ( empty( $attr[ $key ] ) ) {
				return '';
			}

			if ( true === $attr[ $key ] ) {
				return $html . ' ' . \esc_html( $key );
			}

			return $html . \sprintf(
				' %s="%s"',
				esc_html( $key ),
				('href' === $key) ? \esc_url( $attr[ $key ] ) : \esc_attr( $attr[ $key ] )
			);
		}, '' );
	}
}
