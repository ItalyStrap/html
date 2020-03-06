<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\HTML\Tag;
use UnitTester;
use function ItalyStrap\HTML\close_tag;
use function ItalyStrap\HTML\close_tag_e;
use function ItalyStrap\HTML\get_attr;
use function ItalyStrap\HTML\get_attr_e;
use function ItalyStrap\HTML\is_HTML;
use function ItalyStrap\HTML\open_tag;
use function ItalyStrap\HTML\open_tag_e;
use function ItalyStrap\HTML\void_tag;
use function ItalyStrap\HTML\void_tag_e;
use function ItalyStrap\HTML\tag;

class HelpersTest extends Unit {

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {
		// phpcs:ignore
		\tad\FunctionMockerLe\define( 'apply_filters', function ( $filtername, $value ) {
			return $value;
		} );
		// phpcs:ignore
		\tad\FunctionMockerLe\define( 'esc_attr', function ( $value ) {
			return $value;
		} );
		// phpcs:ignore
		\tad\FunctionMockerLe\define( 'esc_html', function ( $value ) {
			return $value;
		} );
	}

	// phpcs:ignore
	protected function _after() {
	}

	/**
	 * @test
	 */
	public function itShouldRenderAttributes() {
		$html = get_attr( 'test', [ 'class' => 'btn-primary' ] );
		$this->assertIsString( $html );
		$this->assertStringContainsString( ' class="btn-primary"', $html, '' );
	}

	/**
	 * @test
	 */
	public function itShouldOutputAttributes() {
		get_attr_e( 'test', [ 'class' => 'btn-primary' ] );
		$this->expectOutputString( ' class="btn-primary"' );
	}

	/**
	 * @test
	 */
	public function itShouldRenderTag() {
		Tag::$is_debug = false;
		$open = tag()->open( 'test', 'div', [ 'class' => 'btn-primary' ] );
		$this->assertStringContainsString( '<div class="btn-primary">', $open, '' );
		$closed = tag()->close( 'test' );
		$this->assertStringContainsString( '</div>', $closed, '' );
	}

	/**
	 * @test
	 */
	public function itShouldRenderTagFromHelpers() {
		Tag::$is_debug = false;
		$open = open_tag( 'test', 'div', [ 'class' => 'btn-primary' ] );
		$this->assertStringContainsString( '<div class="btn-primary">', $open, '' );
		$closed = close_tag( 'test' );
		$this->assertStringContainsString( '</div>', $closed, '' );
	}

	/**
	 * @test
	 */
	public function itShouldOutputTagFromHelpers() {
		Tag::$is_debug = false;
		open_tag_e( 'test', 'div', [ 'class' => 'btn-primary' ] );
		echo 'Content';
		close_tag_e( 'test' );

		$this->expectOutputString( '<div class="btn-primary">Content</div>' );
	}

	/**
	 * @test
	 */
	public function itShouldRenderTagVoidFromHelpers() {
		Tag::$is_debug = false;
		$open = void_tag( 'test', 'img', [ 'src' => 'uri' ] );
		$this->assertStringContainsString( '<img src="uri"/>', $open, '' );
	}

	/**
	 * @test
	 */
	public function itShouldOutputTagVoidFromHelpers() {
		Tag::$is_debug = false;
		void_tag_e( 'test', 'img', [ 'src' => 'uri' ] );
		$this->expectOutputString( '<img src="uri"/>' );
	}

	/**
	 * @test
	 */
	public function itShouldBeValidHtml() {
		$this->assertTrue( is_HTML( '<div>Content</div>' ), '' );
	}
}
