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
class NotEmpty extends AbstractCheck
{


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct()
   {

      parent::__construct();

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

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

      if ( 0 === $passwordLength )
      {
         return PasswordQuality::NONE;
      }

      return PasswordQuality::HIGH;

   }

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\NotEmpty
    */
   public final function setOption( $optionValue, string $optionName ) : NotEmpty
   {

      return $this->_setOption( $optionName, $optionValue );

   }

   // </editor-fold>


}

