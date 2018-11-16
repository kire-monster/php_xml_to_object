<?php 
/**
 *
 * Ejemplo
 * Permite recorrer el XML con recursividad.
 *
 */
include '../XMLObject.php';


function fetchXML($xml)
{
	foreach ($xml as $value) {
		printf("%s: %s",$value->name ,($value->value!=null)?$value->value:"null");
		if($value->attributes!=null)
		{
			foreach ($value->attributes as $key => $attr) { printf("<br>%s => %s",$key,$attr); }
		}
		echo "<br><br>....................................................................................<br>";
		if($value->children!=null){	fetchXML($value->children); }
	}
}


$xml = file_get_contents("test.xml");
$object = xml_to_object($xml);


fetchXML($object->children);


?>
