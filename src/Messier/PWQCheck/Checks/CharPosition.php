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
 * - 1234567890abcdefxyz         => BAD
 * - ABCDEFghijqrstuvw           => MEDIUM
 * - GHIJkKlLmMnNoOpPQRSTUVW.-_  => GOOD
 * - all other                   => HIGH
 */
class CharPosition extends AbstractCheck
{


   private static $charRanges = [
      [ '1','2','3','8','9','0','a','b','c','d','e','f','x','y','z' ],
      [ 'A','B','C','D','E','F','g','h','i','j','q','r','s','t','u','v','w' ],
      [ 'G','H','I','J','k','K','l','L','m','M','n','N','o','O','p','P','Q','R','S','T','U','V','W','.','-','_' ]
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
    * @return \Messier\PWQCheck\Checks\CharPosition
    */
   public final function setOption( $optionValue, string $optionName ) : CharPosition
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

      $summary = 0;
      $indexToQuality = function( int $index )
         {
            switch ( $index )
            {
               case 0 : return PasswordQuality::BAD;
               case 1 : return PasswordQuality::MEDIUM;
               case 2 : return PasswordQuality::GOOD;
               default: return PasswordQuality::HIGH;
            }
         };

      foreach ( $passwordChars as $char )
      {

         $done = false;

         foreach ( static::$charRanges as $idx => $range )
         {
            if ( \in_array( $char, $range, false ) )
            {
               $summary += $indexToQuality( $idx );
               $done = true;
               break;
            }
         }

         if ( ! $done )
         {
            $summary += $indexToQuality( 3 );
         }

      }

      return (int) ( ( (float) $summary ) / ( (float) $passwordLength ) );

   }

   // </editor-fold>


}

