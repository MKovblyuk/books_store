<?php

namespace App\Interfaces\General;

interface HasQuantityInterface 
{
    public function getQuantity(): int;
    public function setQuantity(int $value);
    public function decreaseQuantity(int $value);
    public function increaseQuantity(int $value);
}
