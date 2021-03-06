<?php

class hbar_value
{
	function __construct( $left, $right=null )
	{
		if( isset( $right ) )
		{
			$this->left = $left;
			$this->right = $right;
		}
		else
			$this->right = $left;
	}
	
	function set_colour( $colour )
	{
		$this->colour = $colour;	
	}
	
	function set_tooltip( $tip )
	{
		$this->tip = $tip;	
	}
		
	function set_on_click( $text )
	{
		$tmp = 'on-click';
		$this->$tmp = $text;
	}
}

class hbar
{
	function __construct( $colour )
	{
		$this->type      = "hbar";
		$this->values    = array();
		$this->set_colour( $colour );
	}
	
	function append_value( $v )
	{
		$this->values[] = $v;		
	}
	
	function set_values( $v )
	{
		foreach( $v as $val )
			$this->append_value( new hbar_value( $val ) );
	}
	
	function set_colour( $colour )
	{
		$this->colour = $colour;	
	}
		
	function set_on_click( $text )
	{
		$tmp = 'on-click';
		$this->$tmp = $text;
	}
	function set_key( $text, $size )
	{
		$this->text = $text;
		$tmp = 'font-size';
		$this->$tmp = $size;
	}
	
	function set_tooltip( $tip )
	{
		$this->tip = $tip;	
	}
}

