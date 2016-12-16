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
 * Checks if the password is…
 */
class WordList extends AbstractCheck
{


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct()
   {

      parent::__construct();

      $this->_options[ 'listFile' ] = __DIR__ . '/data/passwords.txt';
      $this->_acceptedOptions[ 'listFile' ] = [
         'listfile', 'list_file', 'file', 'wordlist', 'wordlistfile', 'wordlist_file' ];

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Gets the word list text file path.
    *
    * @return string
    */
   public final function getListFile() : string
   {

      return $this->_options[ 'listFile' ];

   }

   /**
    * Sets the word list text file path.
    *
    * @param  string $value
    * @return \Messier\PWQCheck\Checks\WordList
    */
   public final function setListFile( string $value ) : WordList
   {

      if ( ! \file_exists( $value ) ) { return $this; }

      $this->_options[ 'listFile' ] = $value;

      return $this;

   }

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\WordList
    */
   public final function setOption( $optionValue, string $optionName = 'maxLength' ) : WordList
   {

      if ( \in_array( \strtolower( $optionName ), $this->_acceptedOptions[ 'listFile' ], true ) )
      {
         return $this->setListFile( $optionValue );
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

      $passwords = \explode(
         "\n",
         \str_replace(
            ["\r\n","\r"],
            "\n",
            \file_get_contents( $this->_options[ 'listFile' ] )
         )
      );

      $password = \implode( $passwordChars );

      return \in_array( \mb_strtolower( $password ), $passwords, true )
         ? PasswordQuality::VERY_BAD
         : PasswordQuality::GOOD;

   }

   // </editor-fold>


}

