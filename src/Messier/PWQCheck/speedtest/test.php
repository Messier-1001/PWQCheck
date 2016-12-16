<?php
/**
 * This file tests the speed of 4 different word list storage types.
 *
 * Here with 3 different machines always the "Text file" is the fastest so
 * this type is used as word list format.
 *
 * It is easy to use for all (one word in one line) and fast
 *
 * If you want to run the test simple call this script from console
 */

$charRanges = array_merge(
   array_merge( range( 'A', 'Z' ), range( 'a', 'z' ) ),
   array_merge( range( '0', '9' ), [ '.', ':', '-', '_', ',', ';', '|', '@', '!', '§', '$', ' ', '%', '&', '/', '=' ] )
);

// Generate the 1000 random passwords
$passwords = [];

for ( $i = 0; $i < 1000; $i++ )
{
   $length = random_int( 6, 10 );
   $passwords[] = implode( '', array_rand( $charRanges, $length ) );
}


$files = [
   'Text file'       => function( $password )
   {
      $passwords = explode(
         "\n",
         str_replace(
            ["\r\n","\r"],
            "\n",
            file_get_contents( __DIR__ . '/data/passwords.txt' )
         )
      );
      return in_array( mb_strtolower( $password ), $passwords, true );
   },
   'JSON file'       => function( $password )
   {
      $passwords = json_decode( file_get_contents( __DIR__ . '/data/passwords.json' ), true );
      return in_array( mb_strtolower( $password ), $passwords, true );
   },
   'Serialized data' => function( $password )
   {
      $passwords = unserialize( file_get_contents( __DIR__ . '/data/passwords.data' ) );
      return in_array( mb_strtolower( $password ), $passwords, true );
   },
   'PHP file'        => function( $password )
   {
      $passwords = include __DIR__ . '/data/passwords.php';
      return in_array( mb_strtolower( $password ), $passwords, true );
   }
];



foreach ( $files as $name => $action )
{

   $lastStart = microtime( true );

   for ( $i = 0; $i < 1000; ++$i )
   {

      $action( $passwords[ $i ] );

   }

   $lastEnd = microtime( true );

   echo "\n", str_pad( $name, 16, ' ', STR_PAD_RIGHT ), ': ', ( $lastEnd - $lastStart ), ' sec';

}

