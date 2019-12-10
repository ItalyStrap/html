<?php 
class HelpersTest extends \Codeception\Test\Unit
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

	/**
	 * @test
	 */
    public function ItShouldRenderAttributes()
    {
		$html = \ItalyStrap\HTML\get_attr( 'test', [ 'class' => 'btn-primary' ] );
		$this->assertIsString( $html );
		$this->assertStringContainsString( ' class="btn-primary"', $html, '' );
    }

	/**
	 * @test
	 */
    public function ItShouldOutputAttributes()
    {
		\ItalyStrap\HTML\get_attr_e( 'test', [ 'class' => 'btn-primary' ] );
		$this->expectOutputString( ' class="btn-primary"' );
    }

	/**
	 * @test
	 */
    public function ItShouldRenderTag()
    {
    	\ItalyStrap\HTML\Tag::$is_debug = false;
		$open = \ItalyStrap\HTML\tag()->open( 'test', 'div', [ 'class' => 'btn-primary' ] );
		$this->assertStringContainsString( '<div class="btn-primary">', $open, '' );
		$closed = \ItalyStrap\HTML\tag()->close( 'test' );
		$this->assertStringContainsString( '</div>', $closed, '' );
    }

	/**
	 * @test
	 */
    public function ItShouldRenderTagFromtHelpers()
    {
    	\ItalyStrap\HTML\Tag::$is_debug = false;
		$open = \ItalyStrap\HTML\open_tag( 'test', 'div', [ 'class' => 'btn-primary' ] );
		$this->assertStringContainsString( '<div class="btn-primary">', $open, '' );
		$closed = \ItalyStrap\HTML\close_tag( 'test' );
		$this->assertStringContainsString( '</div>', $closed, '' );
    }

	/**
	 * @test
	 */
    public function ItShouldOutputTagFromtHelpers()
    {
    	\ItalyStrap\HTML\Tag::$is_debug = false;
		\ItalyStrap\HTML\open_tag_e( 'test', 'div', [ 'class' => 'btn-primary' ] );
		echo 'Content';
		\ItalyStrap\HTML\close_tag_e( 'test' );

		$this->expectOutputString( '<div class="btn-primary">Content</div>' );
    }
}