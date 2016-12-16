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
 * Checks the quality of a password, depending to its length.
 *
 * 0-4 chars => NONE
 * 5 chars   => VERY_BAD
 * 6-7 chars => BAD
 * 8 chars   => MEDIUM
 * 9 chars   => GOOD
 * >9 chars  => HIGH
 */
class Length extends AbstractCheck
{


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
    * @return \Messier\PWQCheck\Checks\Length
    */
   public final function setOption( $optionValue, string $optionName ) : Length
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

      if ( $passwordLength < 5 )
      {
         # 1-4 Chars
         return PasswordQuality::NONE;
      }

      if ( $passwordLength < 6 )
      {
         # 5 chars
         return PasswordQuality::VERY_BAD;
      }

      if ( $passwordLength < 8 )
      {
         # 6-7 chars
         return PasswordQuality::BAD;
      }

      if ( $passwordLength < 9 )
      {
         # 8 chars
         return PasswordQuality::MEDIUM;
      }

      if ( $passwordLength < 10 )
      {
         # 9 chars
         return PasswordQuality::GOOD;
      }

      # > 9 chars
      return PasswordQuality::HIGH;

   }

   // </editor-fold>


}

