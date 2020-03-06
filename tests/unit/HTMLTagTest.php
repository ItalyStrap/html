<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\Tag;
use ItalyStrap\HTML\TagInterface;
use UnitTester;
use function sprintf;

class HTMLTagTest extends Unit {

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

	private function getInstance( $debug = false ) {
		Tag::$is_debug = $debug;
		$sut = new Tag( new Attributes() );
		$this->assertInstanceOf( TagInterface::class, $sut );
		$this->assertInstanceOf( Tag::class, $sut );
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldOutputDivTag() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test', 'div' );
		$close = $sut->close( 'test' );

		$this->assertStringContainsString( '<div>', $open, '' );
		$this->assertStringContainsString( '</div>', $close, '' );
	}

	/**
	 * @test
	 */
	public function itShouldOutputEmptyStringIfTagIsEmpty() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test', '' );
		$close = $sut->close( 'test' );

		$this->assertEmpty( $open );
		$this->assertEmpty( $close );
	}

	/**
	 * @test
	 */
	public function itShouldHaveAttributes() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test2', 'div', [ 'class' => 'someClass' ] );
		$close = $sut->close( 'test2' );

		$this->assertStringContainsString( '<div class="someClass">', $open, '' );
		$this->assertStringContainsString( '</div>', $close, '' );
	}

	/**
	 * @test
	 */
	public function itShouldBeVoid() {

		$sut = $this->getInstance();

		$void = $sut->void( 'test', 'input' );
		$this->assertStringContainsString( '<input/>', $void );
	}

	/**
	 * @test
	 */
	public function itShouldBeVoidWithAttributes() {

		$sut = $this->getInstance();

		$void = $sut->void( 'test2', 'input', [ 'type' => 'text' ] );
		$this->assertStringContainsString( '<input type="text"/>', $void );
	}

	/**
	 * @test
	 * @throws Exception
	 */
	public function itShouldHaveErrorIfTagIsNotClosed() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test', 'div' );
		$this->expectOutputString( 'You forgot to close this tags: { Context "test": Tag "div" }' );
	}

	/**
	 * @test
	 */
	public function itShouldHaveErrorIfOpenWithSameContextIsUsedMoreThanOnce() {

		$sut = $this->getInstance();

		$context = 'test';

		$open = $sut->open( $context, 'main' );
		$open2 = $sut->open( $context, 'main' );
		$this->expectOutputString( sprintf( 'The %s is already used', $context ) );

		$close = $sut->close( $context );
	}

	/**
	 * @test
	 */
	public function itShouldAddCommentsIfIsDebugModeActive() {

		$sut = $this->getInstance( true );

		$context = 'test';

		$open = $sut->open( $context, 'main' );
		$close = $sut->close( $context );

		$this->assertStringContainsString( '<!-- open in context: test --><main>', $open, '' );
		$this->assertStringContainsString( '</main><!-- close in context: test -->', $close, '' );

		$void = $sut->void( 'form', 'input' );
		$this->assertStringContainsString( '<!-- open in context: form --><input/>', $void, '' );
	}
}
