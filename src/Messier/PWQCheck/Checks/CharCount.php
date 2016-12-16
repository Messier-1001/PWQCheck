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
 */
class CharCount extends AbstractCheck
{


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct()
   {

      parent::__construct();

      #$this->_error     = '';
      $this->_weighting = 4;
      $this->_failFinal = false;

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\CharCount
    */
   public final function setOption( $optionValue, string $optionName ) : CharCount
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

      #$chars = \preg_split( '//u', $password, -1, PREG_SPLIT_NO_EMPTY );

      $info  = [];

      foreach ( $passwordChars as $char )
      {

         if ( ! isset( $info[ $char ] ) )
         {
            $info[ $char ] = 0;
         }

         $info[ $char ]++;

      }

      $infoCharCount = \count( $info );

      if ( $infoCharCount === $passwordLength )
      {
         // each password char is an other
         if ( $passwordLength <=  7 ) { return PasswordQuality::MEDIUM; }
         if ( $passwordLength === 8 ) { return PasswordQuality::GOOD; }
         return PasswordQuality::HIGH;
      }

      if ( $infoCharCount <= 4 )
      {
         // up to 4 different chars
         if ( $passwordLength <= 7 ) { return PasswordQuality::VERY_BAD; }
         if ( $passwordLength === 8 ) { return PasswordQuality::BAD; }
         if ( $passwordLength === 9 ) { return PasswordQuality::MEDIUM; }
         return PasswordQuality::GOOD;
      }

      if ( $infoCharCount <= 6 )
      {
         // 5-6 different chars
         if ( $passwordLength <= 6 ) { return PasswordQuality::BAD; }
         if ( $passwordLength <= 8 ) { return PasswordQuality::MEDIUM; }
         return PasswordQuality::GOOD;
      }

      if ( $infoCharCount <= 8 )
      {
         // 7-8 different chars
         if ( $passwordLength <= 8 ) { return PasswordQuality::GOOD; }
         return PasswordQuality::HIGH;
      }

      return PasswordQuality::HIGH;

   }

   // </editor-fold>


}

