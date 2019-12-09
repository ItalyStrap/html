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
}