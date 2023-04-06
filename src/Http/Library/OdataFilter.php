<?php

namespace Lexxsoft\Upbasis\Http\Library;

/**
 * Class OdataFilter
 * @package LexxSoft\odata\Http
 */
class OdataFilter
{
    const _EQ_ = 'EQ';
    const _GT_ = 'GT';
    const _GE_ = 'GE';
    const _LT_ = 'LT';
    const _LE_ = 'LE';
    const _CP_ = 'LIKE';
    const _NE_ = 'NE';

    public string $sFilter;
    public string $sField;
    public string $sSign;
    public string $sValue;
    public bool $bGroup;
    public string $sCondition;
    private string $sTable = '';

    /**
     * Устанавливает имя таблицы
     */
    public function setTable(string $sTableName): void
    {
        $this->sTable = $sTableName;
    }

    /**
     * OdataFilter constructor.
     */
    public function __construct(OdataFilterStructure $oMatch)
    {
        $this->sField = $oMatch->field;

        if (str_starts_with($this->sField, 'substringof') ||
            str_starts_with($this->sField, 'contains') ||
            str_starts_with($this->sField, 'endswith') ||
            str_starts_with($this->sField, 'startswith')) {

            $sPattern = "{value}";
            if (str_starts_with($this->sField, 'substringof')) {
                $sPattern = "%" . $sPattern . "%";
            } elseif (str_starts_with($this->sField, 'contains')) {
                $sPattern = "%" . $sPattern . "%";
            } elseif (str_starts_with($this->sField, 'endswith')) {
                $sPattern = "%" . $sPattern;
            } elseif (str_starts_with($this->sField, 'startswith')) {
                $sPattern = $sPattern . "%";
            }

            $re = '/.+\((?<Field>.+),\s*\'(?<Value>.+)\'\)/m';
            $reReplace = '/\{\S+\}/m';

            preg_match_all($re, $this->sField, $matches, PREG_SET_ORDER, 0);
            foreach ($matches as $match) {
                $this->sField = $match['Field'];
                $this->sValue = preg_replace($reReplace, $match['Value'], $sPattern);
                $this->sSign = self::_CP_;
            }
        } else {
            $this->sSign = strtoupper($oMatch->operator);
            $this->sValue = $oMatch->value;
            $this->bGroup = $oMatch->group;
            if (str_starts_with($this->sValue, "'")) {
                $this->sValue = substr(substr($this->sValue, 1), 0, -1);
            }
        }

        $this->sCondition = strtolower($oMatch->condition);
    }

    /**
     * Конвертирование в массив
     */
    public function toArray(): array
    {
        $aParts = [0 => '', 1 => '', 2 => '', 3 => 'and'];

        if ($this->sTable !== '') {
            $aParts[0] = $this->sTable . '.';
        }
        $aParts[0] .= $this->sField;
        $aParts[1] = self::toSqlSign($this->sSign);
        $aParts[2] = $this->adoptValueType($this->sValue);
        $aParts[3] = $this->sCondition;
        return $aParts;
    }

    /**
     * Адаптирует значение переменной к подходящему типу
     */
    private function adoptValueType($sValue): mixed
    {
        if (strtolower($sValue) == 'true') return true;
        if (strtolower($sValue) == 'false') return false;
        if (strtolower($sValue) == 'null') return null;
        return $sValue;
    }

    /**
     * Конвертирование знака сравнения в SQL понятный
     */
    public static function toSqlSign(string $sSign = self::_EQ_): string
    {
        $a = [
            self::_EQ_ => '=',
            self::_GT_ => '>',
            self::_GE_ => '>=',
            self::_LT_ => '<',
            self::_LE_ => '<=',
            self::_CP_ => 'LIKE',
            self::_NE_ => '<>',
//            self::IS => 'IS',
//            self::ISNOT => 'IS NOT',
        ];
        return $a[$sSign];
    }
}
