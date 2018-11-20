<?php 

/**
 * @package: XMLObject
 */
class XMLObject {
  var $name;
  var $attributes;
  var $value;
  var $children;
};

function xml_to_object($xml) {
  $parser = xml_parser_create();
  xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
  xml_parse_into_struct($parser, $xml, $tags);
  xml_parser_free($parser);

  $elements = array();
  $stack = array();
  foreach ($tags as $tag) {
    $index = count($elements);
    if ($tag['type'] == "complete" || $tag['type'] == "open") {
      $elements[$index] = new XMLObject;
      $elements[$index]->name = $tag['tag'];
      $elements[$index]->attributes = isset($tag['attributes'])?$tag['attributes']:null;
      $elements[$index]->value = isset($tag['value'])?$tag['value']:null;
      if ($tag['type'] == "open") {
        $elements[$index]->children = array();
        $stack[count($stack)] = &$elements;
        $elements = &$elements[$index]->children;
      }
    }
    if ($tag['type'] == "close") {
      $elements = &$stack[count($stack) - 1];
      unset($stack[count($stack) - 1]);
    }
  }
  return $elements[0];
}



?>
