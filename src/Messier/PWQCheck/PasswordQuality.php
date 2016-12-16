<?php
/**
 * @author         Messier 1001 <messier.1001+code@gmail.com>
 * @copyright  (c) 2016, Messier 1001
 * @package        Messier.DBLib
 * @since          2016-12-11
 * @subpackage     …
 * @version        0.1.0
 */


declare( strict_types = 1 );


namespace Messier\PWQCheck;


/**
 * Defines all usable password quality values.
 *
 * @since v0.1.0
 */
interface PasswordQuality
{


   /**
    * The string no defines a usable password. The checked password does not pass the minimal requirements to be a
    * password.
    */
   const NONE = 0;

   /**
    * The checked password has a very bad quality and should never been used or the password is known in a dictionary,
    * etc., or a natural word and thus already disqualifies.
    */
   const VERY_BAD = 1;

   /**
    * The password does not meet modern security standards, but unfortunately corresponds to what you get in the
    * "Free Wilderness" is most likely to meet with 0815 users.
    *
    * An indication of a bad password is obligatory. 2 is regarded as unusable in the default settings and is
    * interpreted as passed. There may be people who might want to push one eye. But remember, dear people, it is not
    * just about the security of the user but also your website benefits from stronger passwords.
    */
   const BAD = 2;

   /**
    * The quality is medium. It is not wrong to think about a more secure password.
    */
   const MEDIUM = 3;

   /**
    * Good quality with minor flaws.
    */
   const GOOD = 4;

   /**
    * The best quality
    */
   const HIGH = 5;

   /**
    * All known password quality values.
    */
   const KNOWN_QUALITIES = [ self::NONE, self::VERY_BAD, self::BAD, self::MEDIUM, self::GOOD, self::HIGH ];


}

