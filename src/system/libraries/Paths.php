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
 * Librairy of helper methods related to paths and the file system.
 * Should only contain static methods and class constants.
 */
class Paths
{
    /**
    * Concatenates a list of path segments into a path string.
    *
    * DOES:
    *    - Remove leading and trailing slashes and spaces from each segment.
    *    - Keep leading slash at the begining of first segment.
    *    - Keep trailing slash at end of last segment.
    *    - Uses PHP constant DIRECTORY_SEPARATOR by default.
    *
    * DOESN'T:
    *    - Validate path syntax or correctness
    *    - Validate path existence.
    *
    * @param array  $segments  A list of path segments from parent to child.
    * @return string The imploded path
    * @todo When last segment is an empty string, then ending slash is not preserved if previous
    *       non empty segment end with a slash. It's an edge case. May be resolved by:
    *       1- Imploding $segments.
    *       2- Removing consecutive separators in segments string.
    *       3- Exploding segments string by separator.
    *       4- Process resulting $segments array exactly as before.
    */
   public static function implodePath(array $segments, string $separator = '') {
      if(strlen($separator) < 1) {
         $separator = DIRECTORY_SEPARATOR;
      }
      
      $path = [];
      $has_leading_separator = false;
      $has_trailing_separator = false;
      
      //Must keep leading separator of first segment and trailing slash of last segment.
      $n = count($segments);
      for($i = 0; $i < $n ; $i++) {
         $segment = $segments[$i];
         
         //Remove spaces that may surround separators, such as in " /directory/ ".
         $segment = trim($segment);
         
         // Check if path has leading separator
         // Also, will reintroduce the first segment if it's a separator.
         if($i === 0 && strlen($segment) > 0) {
            $has_leading_separator = ($segment[0] === $separator);
         }
         // Check if path as trailing separator
         // Also, will reintroduce the last segment if it's a separator.
         if($i === $n-1 && strlen($segment) > 0) {
            $has_trailing_separator = ($segment[strlen($segment) - 1] === $separator);
         }
         
         // Remove separators and extra spaces
         $segment = trim(trim($segment, $separator));
         
         // Only keep strings with length
         if(strlen($segment) > 0) {
            $path[] = $segment;
         }
      }
      
      if(count($path) > 0) {
         // To string
         $path = implode($separator, $path);
         
         // Restore leading separator.
         $path = $has_leading_separator ? $separator.$path : $path;
         
         // Restore trailing separator.
         $path = $has_trailing_separator ? $path.$separator : $path;

         // Edge case: We had only leading and trailing separators, keep only one.
         if($path === $separator.$separator) {
            $path = $separator;
         }

      } else {
         $path = '';
      }

      return $path;
   }

    /**
    * Create a directory only if missing. Die on error.
    *
    * @param string  $path  An absolute path to the directory to create, if missing
    * @return void
    */
   public static function makeDirOrDie($path) {
      @ mkdir($path)
      or die("Can't create directory: ".$path);
   }

    /**
    * Test autoloader.
    *
    * @return string A datetime string
    */
   public static function test() {
      return date('Y-m-d H:i:s');
   }


}
