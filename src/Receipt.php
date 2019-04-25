<?php
namespace TDD;

use \BadMethodCallException;

class Receipt {
    public function total(array $items = [], $coupon) {
        if ($coupon > 1.00) { // kui kupong on suurem, kui 1.00, siis viskab sõnumi "Coupong must be less than or equal to 1.00"
            throw new BadMethodCallException('Coupon must be less than or equal to 1.00');
        }
        $sum = array_sum($items);
        if (!is_null($coupon)) { //kui kupong ei ole võrdne nulliga
            return $sum - ($sum * $coupon);  // Siin korrutab summa kupongi hinnaga ning siis lahutab summast.
        }
        return $sum; // aga kui on võrdne nulliga, siis väljastab tavalise summa
    }

    public function tax($amount, $tax) {
        return ($amount * $tax); //Korrutab summa ja maksud
    }

    public function postTaxTotal($items, $tax, $coupon) { // anname väärtused
        $subtotal = $this->total($items, $coupon);
        return $subtotal + $this->tax($subtotal, $tax);
    }
}