<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier\PWQCheck
 * @since          2016-12-14
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\PWQCheck;


use Messier\PWQCheck\Checks\CharCount;
use Messier\PWQCheck\Checks\CharPosition;
use Messier\PWQCheck\Checks\CharType;
use Messier\PWQCheck\Checks\Length;
use Messier\PWQCheck\Checks\MaxLength;
use Messier\PWQCheck\Checks\MinLength;
use Messier\PWQCheck\Checks\NotEmpty;
use Messier\PWQCheck\Checks\WordList;


/**
 * This class can be used to test the quality of an password.
 *
 * It uses different methods for checking:
 *
 * The next 3 checking methods always result in a {@see \Messier\PWQCheck\PasswordQuality::NONE} if they fail and
 * finish the checking routine on fail
 *
 * - NotEmpty:     A password can not be empty (This check can not be disabled!)
 * - MinLength:    A password must use a minimal amount of characters to be a usable password. Accepted min length value
 *                 range is 6 - 128 but default value is 8 (more secure but not also often to short)
 * - MaxLength:    A password can use a maximal amount of characters to be a usable password. Accepted max length value
 *                 range is 32 - 255 but default value is 128. There is no problem if you accept loooong passwords.
 *                 They are more secure!
 *
 * The next method finish the Checking routine if it returns a {@see \Messier\PWQCheck\PasswordQuality::VERY_BAD}
 *
 * - WordList:     If the password is known inside the used word list (~550 often used english passwords) this check
 *
 *         returns  {@see \Messier\PWQCheck\PasswordQuality::VERY_BAD}. Otherwise this test is ignored.
 *
 * and:
 *
 * - Length  :     Checks the quality by password length
 * - CharType:     Checks the quality by the amount of different used char types
 * - CharCount:    Checks the quality by the use of different chars
 *
 * The usage is really simple:
 *
 * <code>
 * use Messier\PWQCheck\QualityCheck;
 *
 * $check = new QualityCheck(
 *    8,   // min length
 *    128, // max length
 *    true // Use word list check?
 * );
 *
 * echo '222233334444: ', $check->checkQuality( '222233334444' );
 * </code>
 */
class QualityCheck
{


   // <editor-fold desc="// – – –   P R I V A T E   F I E L D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   /**
    * @type \Messier\PWQCheck\Checks\NotEmpty
    */
   private $_checkNotEmpty;

   /**
    * @type \Messier\PWQCheck\Checks\MinLength
    */
   private $_checkMinLength;

   /**
    * @type \Messier\PWQCheck\Checks\MaxLength
    */
   private $_checkMaxLength;

   /**
    * @type \Messier\PWQCheck\Checks\Length
    */
   private $_checkLength;

   /**
    * @type \Messier\PWQCheck\Checks\CharType
    */
   private $_checkCharType;

   /**
    * @type \Messier\PWQCheck\Checks\CharCount
    */
   private $_checkCharCount;

   /**
    * @type \Messier\PWQCheck\Checks\CharPosition
    */
   private $_checkCharPosition;

   /**
    * @type \Messier\PWQCheck\Checks\CharPosition
    */
   private $_checkWordList;

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –">

   public function __construct( int $minLength = 8, int $maxLength = 255, bool $useWordList = true )
   {

      $this->_checkNotEmpty     = new NotEmpty();
      $this->_checkMinLength    = new MinLength();
      $this->_checkMinLength->setMinLength( $minLength );
      $this->_checkMaxLength    = new MaxLength();
      $this->_checkMaxLength->setMaxLength( $maxLength );
      $this->_checkLength       = new Length();
      $this->_checkCharType     = new CharType();
      $this->_checkCharCount    = new CharCount();
      $this->_checkCharPosition = new CharPosition();
      $this->_checkWordList     = $useWordList ? new WordList() : null;

   }

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –">

   public function checkQuality( string $password )
   {

      $chars     = \preg_split( '//u', $password, -1, PREG_SPLIT_NO_EMPTY );
      $charCount = \count( $chars );

      if ( ( PasswordQuality::NONE === $this->_checkNotEmpty->checkQuality( $chars, $charCount ) ) ||
           ( PasswordQuality::NONE === $this->_checkMinLength->checkQuality( $chars, $charCount ) ) ||
           ( PasswordQuality::NONE === $this->_checkMaxLength->checkQuality( $chars, $charCount ) ) )
      {
         return PasswordQuality::NONE;
      }

      if ( null !== $this->_checkWordList )
      {
         $q3 = $this->_checkWordList->checkQuality( $chars, $charCount );
         if ( PasswordQuality::GOOD !== $q3 )
         {
            return $q3;
         }
      }

      $q1s = $this->_checkLength->checkQuality( $chars, $charCount )
           + $this->_checkCharType->checkQuality( $chars, $charCount )
           + $this->_checkCharCount->checkQuality( $chars, $charCount );
      $q1  = $q1s / 3.0;
      $q1i = (int) $q1;

      $q2 = $this->_checkCharPosition->checkQuality( $chars, $charCount );
      if ( $q2 < $q1i )
      {
         $q2++;
      }
      else if ( $q2 > $q1i )
      {
         $q2--;
      }

      $q1s += $q2;
      $q1  = $q1s / 4.0;

      return (int) $q1;

   }

   // </editor-fold>


}

