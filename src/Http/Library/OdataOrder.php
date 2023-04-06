<?php


namespace Lexxsoft\Upbasis\Http\Library;

class OdataOrder
{
    public string $fieldname = '';
    public string $direction = self::ASC;

    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * OdataOrder constructor
     */
    public function __construct(string $string)
    {
        $aParts = explode(' ', $string);
        if (sizeof($aParts) === 2) {
            $this->fieldname = trim($aParts[0]);
            $this->direction = OdataOrder::convert(trim($aParts[1]));
        }
        if (sizeof($aParts) === 1) {
            $this->fieldname = trim($aParts[0]);
            $this->direction = OdataOrder::ASC;
        }
    }

    /**
     * Конвертирует значение константы в текстовое значение
     */
    private static function convert(string $sValue): string
    {
        $sUpperValue = strtoupper($sValue);
        if (defined(OdataOrder::class . '::' . $sUpperValue)) {
            return $sUpperValue;
        } else {
            return self::ASC;
        }
    }

}
