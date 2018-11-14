<?php
namespace retl\system\libraries;

/*
 -------------------------------------------------------------------------
 RETL library for reversible extract-transform-load data migration operations
 --------------------------------------------------------------------------
 @package   retl
 @author    Ville de Montréal
 @link      https://github.com/VilledeMontreal/retl
 @since     2018
 --------------------------------------------------------------------------
*/
/**
 * Generic helpers to convert variables into HTML representations.
 */
class GenericHtmlConverter
{

   /**
    * Generic logic for converting an item of any type into an HTML table.
    *
    * - String: Escape string and convert newlines to <br/>
    * - Object: Try the following scenarios in order.
    *    1- If method exists "toHtml": Use return value, as provided (no additionnal escaping).
    *    2- If method exists "__toString": Handle as if string. See above.
    *    3- Else: Use function var_export() and escape resulting string.
    * - Array: For each array item, display the key (escaped) and pass the item to toGenericHtmlTable
    *          This method is recursive. However, it will NOT stop when arrays contain cycles
    *          (memory references that refer to previously visited items). Make sure your arrays
    *          don't contain recursive memory references (i.e.: the usual case).
    * - Other: Use function var_export() and escape resulting string.
    * 
    * Usage note: You must provide the external table openning and closing tags. Row and cell tags
    *             are added automatically.
    * 
    * @param   mixed    $item       A string, an object, an array, etc. to convert to string.
    *
    * @return return An HTML string representation of the item
    */
   public static function toGenericHtmlTable($item) {
      $html = [];
   
      if(is_object($item) && method_exists($item, 'toHtml')) {
         $html[] = '<tr>';
            $html[] = '<td>';
               $html[] = $item->toHtml();
            $html[] = '</td>';
         $html[] = '</tr>';
         
      } elseif(is_string($item)) {
         $html[] = '<tr>';
            $html[] = '<td>';
               $html[] = nl2br(htmlentities($item));
            $html[] = '</td>';
         $html[] = '</tr>';
      
      } elseif(is_object($item) && method_exists($item, '__toString')) {
         $html[] = '<tr>';
            $html[] = '<td>';
               $html[] = nl2br(htmlentities($item));
            $html[] = '</td>';
         $html[] = '</tr>';
         
      } elseif(is_array($item)) {
         foreach($item as $category => $subitem) {
            $html[] = '<tr>';
               $html[] = '<td>';
                  $html[] = htmlentities($category).': ';
               $html[] = '</td>';
               $html[] = '<td>';
                  $html[] = '<table class="plugin-etl__section-error__recursing">';
                     $html[] = '<tbody>';
                        $html[] = self::toGenericHtmlTable($subitem);
                        $html[] = '</tbody>';
                     $html[] = '</table>';
               $html[] = '</td>';
            $html[] = '</tr>';
         }
      
      } else {
         $html[] = '<tr>';
            $html[] = '<td>';
               $html[] = '<pre>';
                  $html[] = htmlentities(var_export($item, true));
               $html[] = '</pre>';
            $html[] = '</td>';
         $html[] = '</tr>';
      }
      
      return implode('', $html);
   }

}