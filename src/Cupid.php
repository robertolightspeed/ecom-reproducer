<?php
namespace App;

use App\Reproducer;

class Cupid
{
    public function throwArrow($times, $minion)
    {
        $minion = new $minion();

        if ($minion instanceof Reproducer)
        {
            $minion->_prepare();

            for ($t = 0; $t < $times; $t++)
            {
                $minion->_action();
            }
        }
    }
}