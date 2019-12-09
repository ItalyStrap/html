<?php 
class HTMLTagTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
		\tad\FunctionMockerLe\define( 'apply_filters', function ( $filtername, $value ) { return $value; } );
		\tad\FunctionMockerLe\define( 'esc_attr', function ( $value ) { return $value; } );
		\tad\FunctionMockerLe\define( 'esc_html', function ( $value ) { return $value; } );
    }

    protected function _after()
    {
    }

	private function getInstance( $debug = false ) {
		ItalyStrap\HTML\Tag::$is_debug = $debug;
		$sut = new ItalyStrap\HTML\Tag( new ItalyStrap\HTML\Attributes() );
		$this->assertInstanceOf( ItalyStrap\HTML\TagInterface::class, $sut );
		$this->assertInstanceOf( ItalyStrap\HTML\Tag::class, $sut );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldOutputDivTag() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test', 'div' );
		$close = $sut->close( 'test' );

		$this->assertStringContainsString( '<div>', $open, '' );
		$this->assertStringContainsString( '</div>', $close, '' );
	}

	/**
	 * @test
	 */
	public function ItShouldOutputEmptyStringIfTagIsEmpty() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test', '' );
		$close = $sut->close( 'test' );

		$this->assertEmpty( $open );
		$this->assertEmpty( $close );
	}

	/**
	 * @test
	 */
	public function ItShouldHaveAttributes() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test2', 'div', [ 'class' => 'someClass' ] );
		$close = $sut->close( 'test2' );

		$this->assertStringContainsString( '<div class="someClass">', $open, '' );
		$this->assertStringContainsString( '</div>', $close, '' );

	}

	/**
	 * @test
	 */
	public function ItShouldBeVoid() {

		$sut = $this->getInstance();

		$void = $sut->void( 'test', 'input' );
		$this->assertStringContainsString( '<input/>', $void );
	}

	/**
	 * @test
	 */
	public function ItShouldBeVoidWithAttributes() {

		$sut = $this->getInstance();

		$void = $sut->void( 'test2', 'input', [ 'type' => 'text' ] );
		$this->assertStringContainsString( '<input type="text"/>', $void );
	}

	/**
	 * @test
	 * @throws Exception
	 */
	public function ItShouldHaveErrorIfTagIsNotClosed() {

		$sut = $this->getInstance();

		$open = $sut->open( 'test', 'div' );
		$this->expectOutputString( 'You forgot to close this tags: { Context "test": Tag "div" }' );
	}

	/**
	 * @test
	 */
	public function ItShouldHaveErrorIfOpenWithSameContextIsUsedMoreThanOnce() {

		$sut = $this->getInstance();

		$context = 'test';

		$open = $sut->open( $context, 'main' );
		$open2 = $sut->open( $context, 'main' );
		$this->expectOutputString( \sprintf( 'The %s is already used', $context ) );

		$close = $sut->close( $context );
    }

	/**
	 * @test
	 */
	public function ItShouldAddCommentsIfIsDebugModeActive() {

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