<?php

	inspect("hello");
	inspect(123);
	inspect(true);

	function inspect($object)
	{
		echo inspectRender($object, true);
	}

	function inspectClass($object)
	{
		// Type
		$type = gettype($object);

		// Class
		if($type == "object") {return (object) array("label" => "CLASS", "value" => get_class($object));}

		// Primitive
		return (object) array("label" => "TYPE", "value" => $type);
	}

	function inspectRender($object, $title)
	{
		// Styles
		$style = inspectStyle();

		// Table Start
		$html = '<table style = "'.$style->table.'">';

		// Title
		if($title)
		{
			$html .= '<tr valign = "top">';
			$html .= '<td colspan = "2" style = "'.$style->td.'">';
			$html .= 'INSPECT';
			$html .= '</td>';
			$html .= '</tr>';
		}

		// Class
		$class = inspectClass($object);
		$html .= '<tr valign = "top">';
		$html .= '<td style = "'.$style->td.'">';
		$html .= $class->label;
		$html .= '</td>';
		$html .= '<td style = "'.$style->td.$style->value.'">';
		$html .= $class->value;
		$html .= '</td>';
		$html .= '</tr>';

		// Class
		// NOTE: need to put specifics in here
		// NOTE: how to handle queries? special object? typeof mysqli result?

		// Value
		// NOTE: merge specifics with above? primitives?
		$value = inspectRenderVar($object);
		$onClick = "var id = this.id.split('|')[1];if(document.getElementById('__inspectValueStatus|' + id).value == 'expand') {document.getElementById('__inspectValueSpan|' + id).style = 'display:none;';document.getElementById('__inspectValueHide|' + id).style = 'display:inline;';document.getElementById('__inspectValueStatus|' + id).value = 'hidden';} else {document.getElementById('__inspectValueSpan|' + id).style = 'display:inline;';document.getElementById('__inspectValueHide|' + id).style = 'display:none;';document.getElementById('__inspectValueStatus|' + id).value = 'expand';}";
		$html .= '<tr valign = "top">';
		$html .= '<td id = "__inspectValueLabel|'.$value->id.'" style = "'.$style->td.' cursor:pointer;" onClick = "'.$onClick.'">';
		$html .= '<input type = "hidden" id = "__inspectValueStatus|'.$value->id.'" value = "expand" />';
		$html .= $value->label;
		$html .= '</td>';
		$html .= '<td style = "'.$style->td.' '.$style->value.'">';
		$html .= '<span id = "__inspectValueSpan|'.$value->id.'" style = "display:inline;">'.$value->html.'</span>';
		$html .= '<span id = "__inspectValueHide|'.$value->id.'" style = "display:none;">...</span>';
		$html .= '</td>';
		$html .= '</tr>';

		// Table End
		$html .= '</table>';
		$html .= '<br>';
		return $html;
	}

	function inspectRenderVar($object)
	{
		// Type
		$type = gettype($object);

		// Class
		if($type == "object") {return (object) array("label" => "VALUE", "html" => "object value", "id" => uniqid());}

		// Array
		if($type == "array") {return inspectRenderVarArray($object);}

		// Primitive
		return inspectRenderVarSimple($object);
	}

	function inspectRenderVarArray($object)
	{
		// Styles
		$style = inspectStyle();

		// Table Start
		$html = '<table style = "'.$style->table.'">';

		// Elements
		for($e = 0; $e < count($object); $e ++)
		{
			$html .= '<tr valign = "top">';
			$html .= '<td style = "'.$style->td.'">';
			$html .= $e;
			$html .= '</td>';
			$html .= '<td style = "'.$style->td.' '.$style->value.'">';
			$html .= inspectRender($object[$e], false);
			$html .= '</td>';
			$html .= '</tr>';
		}

		// Table End
		$html .= '</table>';
		return (object) array("label" => "ELEMENTS", "html" => $html, "id" => uniqid());
	}

	function inspectRenderVarSimple($object)
	{
		return (object) array("label" => "VALUE", "html" => $object, "id" => uniqid());
	}

	function inspectStyle()
	{
		// Theme
		$colourBkg = "88A583";
		$colourLight = "BCCBBC";
		$colourBorder = "000000";

		// Styles
		return (object) array("table" => "background-color: #".$colourBkg."; border: 1px solid #".$colourBorder."; border-collapse: collapse; font-family: monospace; padding: 5px; padding-left: 10px; padding-right: 10px;", "td" => "border: 1px solid #".$colourBorder."; border-collapse :collapse; padding: 5px; padding-left: 10px; padding-right: 10px;", "value" => "background-color: #".$colourLight.";");
	}

?>