<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\AttributesInterface;
use UnitTester;

class AttributesTest extends Unit {

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

	private function getInstance() {
		$sut = new Attributes();
		$this->assertInstanceOf( AttributesInterface::class, $sut );
		$this->assertInstanceOf( Attributes::class, $sut );
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$this->getInstance();
	}

	/**
	 * @test
	 */
	public function itShouldAddAttributes() {
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
	public function itShouldGetAttributes() {
		$sut = $this->getInstance();

		$attr = [
			'class'	=> 'color-primary',
			'id'	=> 'unique_id',
		];

		$sut->add( 'test', $attr );

		$this->assertEquals( $attr, $sut->get( 'test' ), '' );
	}

	/**
	 * @test
	 */
	public function itShouldRemoveAttributes() {
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
	public function itShouldRenderTheGivenAttributes() {
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
	public function itShouldRemoveContextAfterRenderTheGivenAttributes() {
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
	public function itShouldRemoveAttributeIfValueIsEmpty() {
		$sut = $this->getInstance();
		$sut->add( 'test-with-key-value-first', [

			'id'	=> 'unique_id',
			'class'	=> '',
			'attr1'	=> null,
			'attr2'	=> false,
			'attr3'	=> 0,
		] );

		$attr = $sut->render( 'test-with-key-value-first' );
		$this->assertEquals( ' id="unique_id"', $attr, '' );

		$sut->add( 'test-with-key-null-first', [
			'class'	=> '',
			'attr1'	=> null,
			'attr2'	=> false,
			'attr3'	=> 0,
			'id'	=> 'unique_id',
		] );

		$attr = $sut->render( 'test-with-key-null-first' );
		$this->assertEquals( ' id="unique_id"', $attr, '' );
	}

	/**
	 * @test
	 */
	public function itShouldRenderAttributeWithNoValueIfAtributeIsTrue() {
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
	public function itShouldReturnEmptyStringIfNoAttributedAreGiven() {
		$sut = $this->getInstance();
		$sut->add( 'test', [] );

		$attr = $sut->render( 'test' );
		$this->assertEmpty( $attr, '' );
		$this->assertIsString( $attr, '' );
	}
}
