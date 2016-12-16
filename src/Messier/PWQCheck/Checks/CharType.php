<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\PWQCheck\Checks
 * @since          2016-12-10
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\PWQCheck\Checks;


use Messier\PWQCheck\PasswordQuality;


/**
 * Defines a class that …
 *
 * - upper case letters (1.0 points)
 * - lower case letters (1.0 points)
 * - numbers            (1.0 points)
 * - .,-_|!$/=?         (1.5 points)
 * - all other chars    (2.0 points)
 *
 * A summary of 4.5 Points or higher means, this is highest quality
 */
class CharType extends AbstractCheck
{


   private static $charRanges = [
      [ 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','ä','ö','ü','ß' ],
      [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','Ä','Ö','Ü' ],
      [ '0','1','2','3','4','5','6','7','8','9' ],
      [ '.',',','-','_','|','!','$','/','=','?' ]
   ];


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct()
   {

      parent::__construct();

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\CharType
    */
   public final function setOption( $optionValue, string $optionName ) : CharType
   {

      return $this->_setOption( $optionName, $optionValue );

   }

   /**
    * Checks the quality of the defined password.
    *
    * The returned quality value is a value between 0 and 5. See {@see \Messier\PWQCheck\PasswordQuality}
    *
    * @param array $passwordChars
    * @param int   $passwordLength
    * @return int Return a quality between 0 and 5
    */
   public function checkQuality( array $passwordChars, int $passwordLength ) : int
   {

      $summary = 0.0;
      $matches = [ 0, false, false, false, false, false ];

      // Loop all password chars
      foreach ( $passwordChars as $char )
      {

         // lower letters
         if ( \in_array( $char, static::$charRanges[ 0 ], false ) )
         {
            if ( $matches[ 1 ] ) { continue; }
            $matches[ 0 ]++;
            $matches[ 1 ] = true;
            $summary += 1.0;
            continue;
         }

         // UPPER letters
         if ( \in_array( $char, static::$charRanges[ 1 ], false ) )
         {
            if ( $matches[ 2 ] ) { continue; }
            $matches[ 0 ]++;
            $matches[ 2 ] = true;
            $summary += 1.0;
            continue;
         }

         // Numbers
         if ( \in_array( $char, static::$charRanges[ 2 ], false ) )
         {
            if ( $matches[ 3 ] ) { continue; }
            $matches[ 0 ]++;
            $matches[ 3 ] = true;
            $summary += 1.0;
            continue;
         }

         // Dot, Comma, etc.
         if ( \in_array( $char, static::$charRanges[ 3 ], false ) )
         {
            if ( $matches[ 4 ] ) { continue; }
            $matches[ 0 ]++;
            $matches[ 4 ] = true;
            $summary += 1.5;
            continue;
         }

         // All other chars
         if ( $matches[ 5 ] ) { continue; }
         $matches[ 0 ]++;
         $matches[ 5 ] = true;
         $summary += 2.0;

      }


      if ( $summary > 4.4 )
      {
         return PasswordQuality::HIGH;
      }

      if ( $matches[ 5 ] )
      {

         // Some very special chars are used (fine!)

         if ( $matches[ 4 ] )
         {
            // And also often used non alphanumeric chars are used (more fine)
            if ( $summary > 4.5 )
            {
               // And some more chars of two other types are used
               return PasswordQuality::HIGH;
            }
            if ( $summary > 3.5 )
            {
               // And some more chars of one other type is used
               return PasswordQuality::GOOD;
            }
            return PasswordQuality::MEDIUM;
         }

         // And NO often used non alphanumeric chars are used

         if ( 4 === $matches[ 0 ] )
         {
            // And some more chars of 3 other types are used
            return PasswordQuality::HIGH;
         }

         if ( 3 === $matches[ 0 ] )
         {
            // And some more chars of 2 other types are used
            return PasswordQuality::GOOD;
         }

         if ( 2 === $matches[ 0 ] )
         {
            // And some more chars of 1 other types are used
            return PasswordQuality::MEDIUM;
         }

         return PasswordQuality::BAD;

      }

      if ( $matches[ 4 ] )
      {
         // Often used non alphanumeric chars are used
         if ( $summary > 4.4 )
         {
            // And some more chars of 3 other types are used
            return PasswordQuality::HIGH;
         }
         if ( $summary > 3.4 )
         {
            // And some more chars of 2 other type is used
            return PasswordQuality::GOOD;
         }
         if ( $summary > 2.4 )
         {
            // And some more chars of 2 other type is used
            return PasswordQuality::MEDIUM;
         }
         return PasswordQuality::BAD;
      }

      if ( $summary > 2.9 )
      {
         // And some more chars of 3 other types are used
         return PasswordQuality::MEDIUM;
      }

      if ( $summary > 1.9 )
      {
         // And some more chars of 3 other types are used
         return PasswordQuality::BAD;
      }

      return PasswordQuality::VERY_BAD;

   }

   // </editor-fold>


}

