<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @author RegiJG
 *
 */

if (!function_exists('rpToInt')) {
    function rpToInt($harga)
    {
        $harga_str = preg_replace("/[^0-9]/", "", $harga);
        $harga = (int) $harga_str;
        return $harga;
    }
}

if (!function_exists('removeChar')) {
    function removeChar($string)
    {
        $remove_char =preg_replace("/[^A-Za-z0-9?![:space:]]/","", $string);
        return $remove_char;
    }
}

function rp($angka)
{

  $hasil_rupiah = number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
}
