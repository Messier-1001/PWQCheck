<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier.DBLib
 * @since          2016-12-09
 * @subpackage     …
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\PWQCheck\Checks;


/**
 * This interface declares the methods, required to say a class is a valid password check module.
 *
 * @since v0.1.0
 */
interface ICheck
{

   /**
    * Checks the quality of the defined password.
    *
    * The returned quality value is a value between 0 and 5. See {@see \Messier\PWQCheck\PasswordQuality}
    *
    * @param array $passwordChars
    * @param int   $passwordLength
    * @return int Return a quality between 0 and 5
    */
   public function checkQuality( array $passwordChars, int $passwordLength ) : int;

   /**
    * Gets the value of the option with the defined option name.
    *
    * @param  string $optionName   The option name.
    * @param  bool   $defaultValue If the option not exists, return this value.
    * @return mixed
    */
   public function getOption( string $optionName, $defaultValue = false );

   /**
    * Sets the option with defined name.
    *
    * @param  mixed  $optionValue
    * @param  string $optionName
    * @return \Messier\PWQCheck\Checks\MaxLength
    */
   public function setOption( $optionValue, string $optionName );

   /**
    * Gets all defined check options as associative array.
    *
    * @return array
    */
   public function getOptions() : array;

   /**
    * Get the names of all currently declared options.
    *
    * @return array
    */
   public function getOptionNames() : array;

   /**
    * Get if an option with defined name is declared.
    *
    * @param  string $optionName
    * @return bool
    */
   public function optionExists( string $optionName ) : bool;

}

