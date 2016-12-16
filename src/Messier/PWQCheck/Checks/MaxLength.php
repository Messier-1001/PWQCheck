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
 * Checks if the password is longer than a maximum allowed length.
 */
class MaxLength extends AbstractCheck
{


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct()
   {

      parent::__construct();

      $this->_options[ 'maxLength' ] = 128;
      $this->_acceptedOptions[ 'maxLength' ] = [ 'maxlength', 'max_length', 'max', 'max_len', 'maxlen', 'length' ];

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Gets the max length option value.
    *
    * @return int
    */
   public final function getMaxLength() : int
   {

      return $this->_options[ 'maxLength' ];

   }

   /**
    * Sets the max length option value. Valid values must be inside the range 32-255.
    *
    * @param  int $value
    * @return \Messier\PWQCheck\Checks\MaxLength
    */
   public final function setMaxLength( int $value ) : MaxLength
   {

      if ( $value < 32  ) { $value = 32; }
      if ( $value > 255 ) { $value = 255; }

      $this->_options[ 'maxLength' ] = $value;

      return $this;

   }

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\MaxLength
    */
   public final function setOption( $optionValue, string $optionName = 'maxLength' ) : MaxLength
   {

      if ( \in_array( \strtolower( $optionName ), $this->_acceptedOptions[ 'maxLength' ], true ) )
      {
         return $this->setMaxLength( (int) $optionValue );
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

      if ( $passwordLength > $this->getMaxLength() )
      {
         return PasswordQuality::NONE;
      }

      return PasswordQuality::HIGH;

   }

   // </editor-fold>


}

