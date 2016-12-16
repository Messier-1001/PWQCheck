# PWQCheck

A small PHP7.1 library for checking the quality of an password.

## The checking methods

The next 3 checking methods always result in a `\Messier\PWQCheck\PasswordQuality::NONE` if they fail and
finish the checking routine on fail.

* **NotEmpty**:     A password can not be empty (This check can not be disabled!)
* **MinLength**:    A password must use a minimal amount of characters to be a usable password. Accepted min length
                    value range is `6` - `128` but default value is 8 (more secure but not also often to short)
* **MaxLength**:    A password can use a maximal amount of characters to be a usable password. Accepted max length value
                    range is `32` - `255` but default value is 128. There is no problem if you accept loooong passwords.
                    They are more secure!

The next method finish the checking routine if it returns a `\Messier\PWQCheck\PasswordQuality::VERY_BAD`

* **WordList**:     If the password is known inside the used word list (~550 often used english passwords) this check
                    returns  `\Messier\PWQCheck\PasswordQuality::VERY_BAD`. Otherwise this test is ignored.

and:

* **Length**   :    Checks the quality by password length
* **CharType** :    Checks the quality by the amount of different used char types
* **CharCount**:    Checks the quality by the use of different chars

## Usage

The usage is really simple:

```php
use Messier\PWQCheck\QualityCheck;

$check = new QualityCheck(
   8,   // min length
   128, // max length
   true // Use word list check?
);

echo '222233334444: ', $check->checkQuality( '222233334444' );
```
