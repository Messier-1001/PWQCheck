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
 * Checks if the password is shorter than a minimum accepted length.
 */
class MinLength extends AbstractCheck
{


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct()
   {

      parent::__construct();

      $this->_options[ 'minLength' ] = 8;
      $this->_acceptedOptions[ 'minLength' ] = [ 'minlength', 'min_length', 'min', 'min_len', 'minlen', 'length' ];

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Gets the min length option value.
    *
    * @return int
    */
   public final function getMinLength() : int
   {

      return $this->_options[ 'minLength' ];

   }

   /**
    * Sets the min length option value.
    *
    * @param  int $value
    * @return \Messier\PWQCheck\Checks\MinLength
    */
   public final function setMinLength( int $value ) : MinLength
   {

      if ( $value < 6   ) { $value = 6; }
      if ( $value > 128 ) { $value = 128; }
      $this->_options[ 'minLength' ] = $value;

      return $this;

   }

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\MinLength
    */
   public final function setOption( $optionValue, string $optionName = 'minLength' ) : MinLength
   {

      if ( \in_array( \strtolower( $optionName ), $this->_acceptedOptions[ 'minLength' ], true ) )
      {
         return $this->setMinLength( (int) $optionValue );
      }

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

      if ( $passwordLength < $this->getMinLength() )
      {
         return PasswordQuality::NONE;
      }

      return PasswordQuality::HIGH;

   }

   // </editor-fold>


}

