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


/**
 * Defines a class that …
 */
abstract class AbstractCheck implements ICheck
{


   // <editor-fold desc="// – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * Associative array with check depending options.
    *
    * @type array
    */
   protected $_options;

   /**
    * Accepted options
    *
    * @type array
    */
   protected $_acceptedOptions = [];

   // </editor-fold>


   // <editor-fold desc="// – – –   P R O T E C T E D   C O N S T R U C T O R   – – – – – – – – – – – – – – – – –">

   protected function __construct()
   {

      $this->_options   = [];

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">


   /**
    * Gets the value of the option with the defined option name.
    *
    * @param  string $optionName   The option name.
    * @param  bool   $defaultValue If the option not exists, return this value.
    * @return mixed
    */
   public function getOption( string $optionName, $defaultValue = false )
   {

      if ( ! $this->optionExists( $optionName ) )
      {
         return $defaultValue;
      }

      return $this->_options[ $optionName ];

   }

   /**
    * Gets all defined check options as associative array.
    *
    * @return array
    */
   public function getOptions() : array
   {

      return $this->_options;

   }

   /**
    * Get the names of all currently declared options.
    *
    * @return array
    */
   public final function getOptionNames() : array
   {

      return \array_keys( $this->_options );

   }

   /**
    * Get if an option with defined name is declared.
    *
    * @param  string $optionName
    * @return bool
    */
   public final function optionExists( string $optionName ) : bool
   {

      return \in_array( $optionName, $this->_options, true );

   }

   // </editor-fold>


   protected function _setOption( string $optionName, $optionValue )
   {

      $this->_options[ $optionName ] = $optionValue;

      return $this;

   }


}

