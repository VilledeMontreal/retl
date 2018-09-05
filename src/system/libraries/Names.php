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
 * Librairy of helper methods related to naming things.
 * Should only contain static methods and class constant.
 */
class Names
{
    /**
    * Convert snake_case into PascalCase (a.k.a. upper camel case)
    *
    * src: https://codereview.stackexchange.com/a/129765
    *
    * @param   string   $name
    * @return  string
    */
   public static function snakeToPascalCase(string $name) {
      return ucFirst(
         str_replace(
            '_',
            '',
            ucwords(
               strToLower($name), //Too lazy to test ucwords behavior with internal capitals...
               '_'
            )
         )
      );
   }
  
   /**
    * Convert snake_case into camelCase (a.k.a. lower camel case)
    *
    * src: https://codereview.stackexchange.com/a/129765
    *
    * @param   string   $name
    * @return  string
    */
   public static function snakeToCamelCase(string $name) {
      return lcFirst(self::snakeToPascalCase($name));
   }
  
   /**
    * Test
    *
    * @param   array   $names A list of names to transform
    * @return  string
    */
   public static function test1(array $names = array()) {
      $names = count($names) ? $names : [
         'aBc DEF ghi',
         'aBc_DEF_ghi',
         'ABC_DEF_GHI',
         'abc_def_ghi',
         '',
         123,
         //NULL,
         //array(),
      ];
      
      $methods = [
         'snakeToPascalCase',
         'snakeToCamelCase',
      ];
      
      foreach($methods as $method) {
         echo '<h3>Method: ', $method, '</h3>';
         echo '<ul>';
         foreach($names as $name) {
            echo '<li>', $name, ' => ', call_user_func(__CLASS__.'::'.$method, $name), '</li>';   
         }
         echo '</ul>';
         echo '<hr/>';
         
      }
   }


}