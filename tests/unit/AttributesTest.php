<?php 
class AttributesTest extends \Codeception\Test\Unit
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

	private function getInstance() {
		$sut = new ItalyStrap\HTML\Attributes();
		$this->assertInstanceOf( ItalyStrap\HTML\AttributesInterface::class, $sut );
		$this->assertInstanceOf( ItalyStrap\HTML\Attributes::class, $sut );
		return $sut;
	}

	/**
	 * @test
	 */
	public function ItShouldBeInstantiable() {
		$this->getInstance();
	}

	/**
	 * @test
	 */
	public function ItShouldAddAttributes() {
		$sut = $this->getInstance();
		$sut->add( 'test', [
			'class'	=> 'color-primary',
			'id'	=> 'unique_id',
		] );

		$this->assertTrue( $sut->has( 'test' ) );
	}

	/**
	 * @test
	 */
	public function ItShouldGetAttributes() {
		$sut = $this->getInstance();

		$attr = [
			'class'	=> 'color-primary',
			'id'	=> 'unique_id',
		];

		$sut->add( 'test', $attr );

		$this->assertEquals( $attr , $sut->get( 'test' ), '' );
	}

	/**
	 * @test
	 */
	public function ItShouldRemoveAttributes() {
		$sut = $this->getInstance();

		$attr = [
			'class'	=> 'color-primary',
			'id'	=> 'unique_id',
		];

		$sut->add( 'test', $attr );
		$sut->remove( 'test' );

		$this->assertFalse( $sut->has( 'test' ) );
	}

	/**
	 * @test
	 */
	public function ItShouldRenderTheGivenAttributes() {
		$sut = $this->getInstance();
		$sut->add( 'test', [
			'class'	=> 'color-primary',
			'id'	=> 'unique_id',
		] );

		$attr = $sut->render( 'test' );
		$this->assertStringContainsString( ' class="color-primary" id="unique_id"', $attr, '' );
	}

	/**
	 * @test
	 */
	public function ItShouldRemoveContextAfterRenderTheGivenAttributes() {
		$sut = $this->getInstance();
		$sut->add( 'test', [
			'class'	=> 'color-primary',
			'id'	=> 'unique_id',
		] );

		$attr = $sut->render( 'test' );

		$this->assertFalse( $sut->has( 'test' ), '' );
	}

	/**
	 * @test
	 */
	public function ItShouldRemoveAttributeIfValueIsEmpty() {
		$sut = $this->getInstance();
		$sut->add( 'test', [
			'class'	=> '',
			'attr1'	=> null,
			'attr2'	=> false,
			'attr3'	=> 0,
			'id'	=> 'unique_id',
		] );

		$attr = $sut->render( 'test' );
		$this->assertEquals( ' id="unique_id"', $attr, '' );
	}

	/**
	 * @test
	 */
	public function ItShouldRenderAttributeWithNoValueIfAtributeIsTrue() {
		$sut = $this->getInstance();
		$sut->add( 'test', [
			'class'	=> 'color-primary',
			'attrWithNoValue'	=> true,
			'id'	=> 'unique_id',
		] );

		$attr = $sut->render( 'test' );
		$this->assertEquals( ' class="color-primary" attrWithNoValue id="unique_id"', $attr, '' );
	}

	/**
	 * @test
	 */
	public function ItShouldReturnEmptyStringIfNoAttributedAreGiven() {
		$sut = $this->getInstance();
		$sut->add( 'test', [] );

		$attr = $sut->render( 'test' );
		$this->assertEmpty( $attr, '' );
		$this->assertIsString( $attr, '' );
	}
}