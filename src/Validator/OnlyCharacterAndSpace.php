<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class OnlyCharacterAndSpace extends Constraint
{
    public $message = "La chaîne '{{ string }}' doit contenir seulement des lettres et des espaces";
}
