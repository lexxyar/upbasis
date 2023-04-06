<?php

namespace Lexxsoft\Upbasis\Http\Middleware;

use Closure;
use Lexxsoft\Upbasis\Http\Library\OdataFilter;
use Lexxsoft\Upbasis\Http\Library\OdataFilterStructure;
use Lexxsoft\Upbasis\Http\Library\OdataOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

class ParseOdataRequest
{
    public int $limit = -1;
    public array $select = [];
    public int $offset = -1;
    public array $filter = [];
    public array $order = [];
    public array $expand = [];

    private function cacheKey(): string
    {
        $aKeys = ['limit', 'select', 'offset', 'filter', 'order', 'expand'];
        sort($aKeys);
        $aValues = [];
        foreach ($aKeys as $sKey) {
            $aValues[] = json_encode($this->$sKey);
        }
        $str = \request()->method() . json_encode($aValues);
        return md5($str);
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $queryParams = $request->all();
        if (isset($queryParams['$top'])) {
            $this->parseLimit($queryParams['$top']);
        }
        if (isset($queryParams['$limit'])) {
            $this->parseLimit($queryParams['$limit']);
        }
        if (isset($queryParams['$skip'])) {
            $this->parseOffset($queryParams['$skip']);
        }
        if (isset($queryParams['$orderby'])) {
            $this->parseOrder($queryParams['$orderby']);
        }
        if (isset($queryParams['$order'])) {
            $this->parseOrder($queryParams['$order']);
        }
        if (isset($queryParams['$expand'])) {
            $this->parseExpand($queryParams['$expand']);
        }
        if (isset($queryParams['$select'])) {
            $this->parseSelect($queryParams['$select']);
        }
        if (isset($queryParams['$filter'])) {
            $this->parseFilter($queryParams['$filter']);
        }

        $oData = new stdClass();

        $oData->limit = $this->limit;
        $oData->top = $this->limit;
        $oData->skip = $this->offset;
        $oData->offset = $this->offset;
        $oData->filter = $this->filter;
        $oData->select = $this->select;
        $oData->expand = $this->expand;
        $oData->order = $this->order;
        $oData->orderby = $this->order;
        $oData->cacheKey = $this->cacheKey();

        $request->oData = $oData;
        return $next($request);
    }

    /**
     * Парсинг $top
     */
    private function parseLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Парсинг $skip
     */
    private function parseOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * Парсинг $select
     */
    private function parseSelect(string $select): void
    {
        $this->select = [];
        $a = explode(',', $select);
        foreach ($a as $item) {
            $this->select[] = trim($item);
        }
    }

    /**
     * Парсинг строки $expand
     */
    private function parseExpand(string $sExpand): void
    {
        $this->expand = [];
        $a = explode(',', $sExpand);
        foreach ($a as $item) {
            $this->expand[] = trim($item);
        }
    }

    /**
     * Парсинг строки сортировки
     */
    private function parseOrder(string $string): void
    {
        if (!$string) return;

        $aOrderParts = explode(',', $string);
        foreach ($aOrderParts as $sOrderPart) {
            $oOrder = new OdataOrder(trim($sOrderPart));
            $this->order[] = $oOrder;
        }
    }

    /**
     * Парсинг строки фильтра
     */
    private function parseFilter(string $filterString): void
    {
//    $re = '/(?<Filter>(?<Field>[^ ]+?)\s(?<Operator>eq|ne|gt|ge|lt|le|)\s\'?(?<Value>.+?))\'?\s*(?:[^\']*$|\s+(?<Condition>:|or|and|not))/m';
//    preg_match_all($re, $sFilterString, $matches, PREG_SET_ORDER, 0);
//    dd($sFilterString, $matches);
        $words = explode(' ', $filterString);

        $quote = 0;
        $text = '';
        $stage = 0;
        $matches = [];
        $o = new stdClass();
        $group = 0;
        $isFirst = true;
        foreach ($words as $word) {
            $text = trim(implode(' ', [$text, $word]));
            $quoteCount = substr_count($word, "'");
            $quote += $quoteCount;
            if ($quote % 2 != 0) continue;

            if ($isFirst) {
                $o = new OdataFilterStructure();
                $matches[] = $o;
                $stage++;
            }

            switch ($stage) {
                case 0: // Binary operation
                    $o = new OdataFilterStructure();
                    $matches[] = $o;
                    $o->condition = $text;
                    $stage++;
                    break;
                case 1: // Field
                    if (str_starts_with($text, '(')) {
                        $group++;
                        $text = substr($text, 1);
                    }
                    $o->field = $text;
                    $o->group = $group;
                    $stage++;
                    break;
                case 2: // Sign
//          dump($o);
                    if (in_array($text, explode(',', 'eq,ne,lt,le,gt,ge'))) {
                        $o->operator = $text;
                        $stage++;
                    } else {
                        $o->field .= $text;
                    }
                    break;
                case 3: // Value
                    if (str_ends_with($text, ')')) {
                        $group--;
                        $text = substr($text, 0, -1);
                    }
                    $o->value = $text;
                    $stage = 0;
                    break;

            }
            $text = '';
            if ($isFirst) {
                $isFirst = false;
            }
        }


        foreach ($matches as $match) {
            $oFilter = new OdataFilter($match);
            $this->filter[] = $oFilter;
        }
    }
}
