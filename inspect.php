<?php

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

		// Value
		$html .= inspectRenderVar($object);

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
		if($type == "object") {return inspectRenderVarObject($object);}

		// Array
		if($type == "array") {return inspectRenderVarArray($object);}

		// Primitive
		return inspectRenderVarSimple($object);
	}

	function inspectRenderVarArray($object)
	{
		// Styles
		$style = inspectStyle();

		// Value
		$value = inspectRenderVarArrayValue($object);

		// Javascript
		$onClick = "var id = this.id.split('|')[1];if(document.getElementById('__inspectValueStatus|' + id).value == 'expand') {document.getElementById('__inspectValueSpan|' + id).style = 'display:none;';document.getElementById('__inspectValueHide|' + id).style = 'display:inline;';document.getElementById('__inspectValueStatus|' + id).value = 'hidden';} else {document.getElementById('__inspectValueSpan|' + id).style = 'display:inline;';document.getElementById('__inspectValueHide|' + id).style = 'display:none;';document.getElementById('__inspectValueStatus|' + id).value = 'expand';}";

		// HTML
		$html = '<tr valign = "top">';
		$html .= '<td id = "__inspectValueLabel|'.$value->id.'" style = "'.$style->td.' cursor:pointer;" onClick = "'.$onClick.'">';
		$html .= '<input type = "hidden" id = "__inspectValueStatus|'.$value->id.'" value = "expand" />';
		$html .= $value->label;
		$html .= '</td>';
		$html .= '<td style = "'.$style->td.' '.$style->value.'">';
		$html .= '<span id = "__inspectValueSpan|'.$value->id.'" style = "display:inline;">'.$value->html.'</span>';
		$html .= '<span id = "__inspectValueHide|'.$value->id.'" style = "display:none;">...</span>';
		$html .= '</td>';
		$html .= '</tr>';
		return $html;
	}

	function inspectRenderVarArrayValue($object)
	{
		// Styles
		$style = inspectStyle();

		// Elements
		if(count($object))
		{
			// Table Start
			$html = '<table style = "'.$style->table.'">';

			// Elements
			$keys = array_keys($object);
			for($e = 0; $e < count($keys); $e ++)
			{
				// Unique ID
				$id = uniqid();

				// Javascript
				$onClick = "var id = this.id.split('|')[1];if(document.getElementById('__inspectElementStatus|' + id).value == 'expand') {document.getElementById('__inspectElementSpan|' + id).style = 'display:none;';document.getElementById('__inspectElementHide|' + id).style = 'display:inline;';document.getElementById('__inspectElementStatus|' + id).value = 'hidden';} else {document.getElementById('__inspectElementSpan|' + id).style = 'display:inline;';document.getElementById('__inspectElementHide|' + id).style = 'display:none;';document.getElementById('__inspectElementStatus|' + id).value = 'expand';}";

				// HTML
				$html .= '<tr valign = "top">';
				$html .= '<td id = "__inspectElementLabel|'.$id.'" style = "'.$style->td.' cursor:pointer;" onClick = "'.$onClick.'">';
				$html .= '<input type = "hidden" id = "__inspectElementStatus|'.$id.'" value = "expand" />';
				$html .= strtoupper($keys[$e]);
				$html .= '</td>';
				$html .= '<td style = "'.$style->td.' '.$style->value.'">';
				$html .= '<span id = "__inspectElementSpan|'.$id.'" style = "display:inline;">'.inspectRender($object[$keys[$e]], false).'</span>';
				$html .= '<span id = "__inspectElementHide|'.$id.'" style = "display:none;">...</span>';
				$html .= '</td>';
				$html .= '</tr>';
			}

			// Table End
			$html .= '</table>';
		}

		// No Elements
		else {$html = "NO ELEMENTS";}

		return (object) array("label" => "ELEMENTS", "html" => $html, "id" => uniqid());
	}

	function inspectRenderVarObject($object)
	{
		// Styles
		$style = inspectStyle();

		// Property Value
		$value = inspectRenderVarObjectProperty($object);

		// Property Javascript
		$onClick = "var id = this.id.split('|')[1];if(document.getElementById('__inspectPropertyStatus|' + id).value == 'expand') {document.getElementById('__inspectPropertySpan|' + id).style = 'display:none;';document.getElementById('__inspectPropertyHide|' + id).style = 'display:inline;';document.getElementById('__inspectPropertyStatus|' + id).value = 'hidden';} else {document.getElementById('__inspectPropertySpan|' + id).style = 'display:inline;';document.getElementById('__inspectPropertyHide|' + id).style = 'display:none;';document.getElementById('__inspectPropertyStatus|' + id).value = 'expand';}";

		// Property HTML
		$html = '<tr valign = "top">';
		$html .= '<td id = "__inspectPropertyLabel|'.$value->id.'" style = "'.$style->td.' cursor:pointer;" onClick = "'.$onClick.'">';
		$html .= '<input type = "hidden" id = "__inspectPropertyStatus|'.$value->id.'" value = "expand" />';
		$html .= $value->label;
		$html .= '</td>';
		$html .= '<td style = "'.$style->td.' '.$style->value.'">';
		$html .= '<span id = "__inspectPropertySpan|'.$value->id.'" style = "display:inline;">'.$value->html.'</span>';
		$html .= '<span id = "__inspectPropertyHide|'.$value->id.'" style = "display:none;">...</span>';
		$html .= '</td>';
		$html .= '</tr>';

		// Method Value
		$value = inspectRenderVarObjectMethod($object);

		// Method Javascript
		$onClick = "var id = this.id.split('|')[1];if(document.getElementById('__inspectMethodStatus|' + id).value == 'expand') {document.getElementById('__inspectMethodSpan|' + id).style = 'display:none;';document.getElementById('__inspectMethodHide|' + id).style = 'display:inline;';document.getElementById('__inspectMethodStatus|' + id).value = 'hidden';} else {document.getElementById('__inspectMethodSpan|' + id).style = 'display:inline;';document.getElementById('__inspectMethodHide|' + id).style = 'display:none;';document.getElementById('__inspectMethodStatus|' + id).value = 'expand';}";

		// Method HTML
		$html .= '<tr valign = "top">';
		$html .= '<td id = "__inspectMethodLabel|'.$value->id.'" style = "'.$style->td.' cursor:pointer;" onClick = "'.$onClick.'">';
		$html .= '<input type = "hidden" id = "__inspectMethodStatus|'.$value->id.'" value = "expand" />';
		$html .= $value->label;
		$html .= '</td>';
		$html .= '<td style = "'.$style->td.' '.$style->value.'">';
		$html .= '<span id = "__inspectMethodSpan|'.$value->id.'" style = "display:inline;">'.$value->html.'</span>';
		$html .= '<span id = "__inspectMethodHide|'.$value->id.'" style = "display:none;">...</span>';
		$html .= '</td>';
		$html .= '</tr>';
		return $html;
	}

	function inspectRenderVarObjectMethod($object)
	{
		// Styles
		$style = inspectStyle();

		// Table Start
		$html = '<table style = "'.$style->table.'">';

		// Methods
		$methods = get_class_methods($object);
		$keys = array_keys($methods);
		if(count($methods))
		{
			for($m = 0; $m < count($methods); $m ++)
			{
				$html .= '<tr valign = "top">';
				$html .= '<td style = "'.$style->td.'">';
				$html .= strtoupper($keys[$m]);
				$html .= '</td>';
				$html .= '<td style = "'.$style->td.' '.$style->value.'">';
				$html .= inspectRender($methods[$keys[$m]], false);
				$html .= '</td>';
				$html .= '</tr>';
			}
		}

		// No Methods (NOTE: come back to this - abstract into unique expandable td like properties)
		else
		{
			$html .= '<tr valign = "top">';
			$html .= '<td style = "'.$style->td.'">';
			$html .= '';
			$html .= '</td>';
			$html .= '<td style = "'.$style->td.' '.$style->value.'">';
			$html .= 'NO METHODS';
			$html .= '</td>';
			$html .= '</tr>'; 
		}

		// Table End
		$html .= '</table>';
		return (object) array("label" => "METHODS", "html" => $html, "id" => uniqid());
	}

	function inspectRenderVarObjectProperty($object)
	{
		// Styles
		$style = inspectStyle();

		// Table Start
		$html = '<table style = "'.$style->table.'">';

		// Properties
		$properties = get_object_vars($object);
		$keys = array_keys($properties);
		if(count($properties))
		{
			for($p = 0; $p < count($keys); $p ++)
			{
				$html .= '<tr valign = "top">';
				$html .= '<td style = "'.$style->td.'">';
				$html .= strtoupper($keys[$p]);
				$html .= '</td>';
				$html .= '<td style = "'.$style->td.' '.$style->value.'">';
				$html .= inspectRender($properties[$keys[$p]], false);
				$html .= '</td>';
				$html .= '</tr>';
			}
		}

		// No Properties
		else
		{
			$html .= '<tr valign = "top">';
			$html .= '<td style = "'.$style->td.'">';
			$html .= '';
			$html .= '</td>';
			$html .= '<td style = "'.$style->td.' '.$style->value.'">';
			$html .= 'NO PROPERTIES';
			$html .= '</td>';
			$html .= '</tr>'; 
		}

		// Table End
		$html .= '</table>';
		return (object) array("label" => "PROPERTIES", "html" => $html, "id" => uniqid());
	}

	function inspectRenderVarSimple($object)
	{
		// Styles
		$style = inspectStyle();

		// Value
		//$value = (object) array("label" => "VALUE", "html" => $object, "id" => uniqid());
		$value = (object) array("label" => "VALUE", "html" => $object, "id" => uniqid());

		// Javascript
		$onClick = "var id = this.id.split('|')[1];if(document.getElementById('__inspectValueStatus|' + id).value == 'expand') {document.getElementById('__inspectValueSpan|' + id).style = 'display:none;';document.getElementById('__inspectValueHide|' + id).style = 'display:inline;';document.getElementById('__inspectValueStatus|' + id).value = 'hidden';} else {document.getElementById('__inspectValueSpan|' + id).style = 'display:inline;';document.getElementById('__inspectValueHide|' + id).style = 'display:none;';document.getElementById('__inspectValueStatus|' + id).value = 'expand';}";

		// HTML
		$html = '<tr valign = "top">';
		$html .= '<td id = "__inspectValueLabel|'.$value->id.'" style = "'.$style->td.' cursor:pointer;" onClick = "'.$onClick.'">';
		$html .= '<input type = "hidden" id = "__inspectValueStatus|'.$value->id.'" value = "expand" />';
		$html .= $value->label;
		$html .= '</td>';
		$html .= '<td style = "'.$style->td.' '.$style->value.'">';
		$html .= '<span id = "__inspectValueSpan|'.$value->id.'" style = "display:inline;">'.$value->html.'</span>';
		$html .= '<span id = "__inspectValueHide|'.$value->id.'" style = "display:none;">...</span>';
		$html .= '</td>';
		$html .= '</tr>';
		return $html;
	}

	function inspectStyle()
	{
		// Theme
		$theme = array(
			"nature" => array("bkg" => "88A583", "light" => "BCCBBC", "border" => "000000"),
			"sand" => array("bkg" => "A58883", "light" => "CBBCBC", "border" => "000000"),
			"slate" => array("bkg" => "8883A5", "light" => "BCBCCB", "border" => "000000"),
			"stone" => array("bkg" => "888888", "light" => "BCBCBC", "border" => "000000")
		);

		// Scheme
		$scheme = "nature";

		// Styles
		return (object) array("table" => "background-color: #".$theme[$scheme]["bkg"]."; border: 1px solid #".$theme[$scheme]["border"]."; border-collapse: collapse; font-family: monospace; padding: 5px; padding-left: 10px; padding-right: 10px;", "td" => "border: 1px solid #".$theme[$scheme]["border"]."; border-collapse :collapse; padding: 5px; padding-left: 10px; padding-right: 10px;", "value" => "background-color: #".$theme[$scheme]["light"].";");
	}

?>
