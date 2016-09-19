<?php
namespace App\Service;

class FizzbuzzService
{

    function handle($number)
    {
        if ($number % 3 === 0) {
            return 'Fizz';
        } elseif ($number % 5 === 0) {
            return 'Buzz';
        } else {
            return '1';
        }
    }
}