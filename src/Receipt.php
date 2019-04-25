<?php
namespace TDD;
class Receipt {
    public function total(array $items = [1, 2, 3], $coupon) {
        $sum = array_sum($items);
        if (!is_null($coupon)) { //kui kupong ei ole võrdne nulliga
            return $sum - ($sum * $coupon);  // Siin korrutab summa kupongi hinnaga ning siis lahutab summast.
        }
        return $sum; // aga kui on võrdne nulliga, siis väljastab tavalise summa
    }

    public function tax($amount, $tax) {
        return ($amount * $tax); //Korrutab summa ja maksud
    }
}