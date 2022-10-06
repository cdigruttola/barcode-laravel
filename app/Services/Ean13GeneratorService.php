<?php

namespace App\Services;

use App\Interfaces\BarcodeGeneratorServiceInterface;

class Ean13GeneratorService implements BarcodeGeneratorServiceInterface
{

    /**
     * @param $id
     * @return string
     */
    public function genCode($id)
    {
        $country_prefix = '805';
        $company_prefix = '12345';

        $prefix = $country_prefix . $company_prefix;
        $prefixLen = strlen($prefix);
        $zeroEANLen = 12 - $prefixLen;
        $ean = $prefix . str_pad($id, $zeroEANLen, '0', STR_PAD_LEFT);

        $sum = 0;
        for ($i = strlen($ean) - 1; $i >= 0; $i--) {
            if ($i % 2 !== 0) {
                $sum += ($ean[$i] * 3);
            } else {
                $sum += (int)$ean[$i];
            }
        }
        $difference = (10 - ($sum % 10)) % 10;
        return $ean . $difference;
    }

}
