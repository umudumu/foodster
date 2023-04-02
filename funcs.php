<?php
    function caseform($num, $wordNom, $wordGenS, $wordGenP) {
        if (($num % 10 == 1) && (($num / 10) % 10 != 1))
            return $wordNom;
        if ((($num % 10 == 2) || ($num % 10 == 3) || ($num % 10 == 4)) && (($num / 10) % 10 != 1))
            return $wordGenS;
        else return $wordGenP;
    }