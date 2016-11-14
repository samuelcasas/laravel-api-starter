<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Builder;

trait HelperTrait
{
    use PimpableTrait;

    protected function getNotSearchableAttributes() {
        return ['page', 'per_page', 'sort', 'with', 'token', 'filter', 'no_paginate', 'include'];
    }

    /*public function __construct()
    {
        parent::__construct();

        //$this->addAppendDynamic('item_sum');

        /*$filter = Input::input('filter');

        if (isset($filter)) {
            if (is_string($filter)) {
                $filter = explode(',', $filter);
            }

            foreach ($filter as $key => $filt)
            {
                /*if(strpos($filt, '.') !== false)
                {
                    list($class, $attr) = explode('.',$filt);

                    //unset($filter[$key]);

                }
                else {
                    if(method_exists($this, 'get'.Str::studly($filt).'Attribute'))
                    {
                        $this->addAppendDynamic($filt);
                    }
               }

            }
        }
    }*/


    public function scopeInputPaginate($query, $perPage = null, $columns = array('*'), $pageName = 'page', $page = null)
    {
        $paginate = $query->paginate(
            ($perPage) ? $perPage : (int) Input::get('per_page'),
            $columns,
            $pageName,
            $page
        );

        return $paginate;
    }

    public function scopeSelector($query, $filter = null)
    {
        $filter = Input::input('other', $filter);

        if (isset($filter)) {
            if (is_string($filter)) {
                $filter = explode(',', $filter);
            }

            foreach ($filter as $key => $filt)
            {
                if(method_exists($this, 'get'.Str::studly($filt).'Attribute'))
                {
                    $query->getModel()->append($filt);
                    unset($filter[$key]);
                }
            }

            if(!empty($filter)) {
                $query->addSelect($filter);
            }
        }
    }

    public function addAppendDynamic($append)
    {
        $this->appends[] = $append;
        //dd($this->appends);
    }

    /**
     * Enable searchable, sortable and withable scopes
     *
     * @param Builder $builder query builder
     * @param array $query
     */
    public function scopePimp(Builder $builder, $query = [], $sort = [], $relations = [], $select = null)
    {
        $query = $query ?: array_except(Input::all(), [$this->sortParameterName, $this->withParameterName]);
        $builder->selector($select)->filtered($query)->sorted($sort)->withRelations($relations);
    }

    public function scopeFetch($builder)
    {
        $req = app('Illuminate\Http\Request');
        $no_paginate = $req->input('no_paginate');
        $per_page = $req->input('per_page');
        $includes = $req->input('include');

        $data =  ($no_paginate) ?
            $builder->get() : $builder->paginate($per_page);

        return $this->includeArray($includes, $data);
    }

    public function scopeFetchSingle($builder, $id)
    {
        $req = app('Illuminate\Http\Request');
        $includes = $req->input('include');

        $data = $builder->findOrFail($id);

        return $this->includeSingle($includes, $data);
    }

    private function includeSingle($includes, $item)
    {
        if(!is_array($includes)) {
            $includes = explode(',',$includes);
        }

        return $this->applyIncludes($includes, $item);
    }

    private function includeArray($includes, $items)
    {
        if(!is_array($includes)) {
            $includes = explode(',',$includes);
        }

        foreach ($items as $key => $item) {
            $items[$key] = $this->applyIncludes($includes, $item);
        }

        return $items->toArray();
    }

    public function applyIncludes($includes, $item)
    {
        foreach ($includes as $include) {
            if (strpos($include, '.') !== false) {
                //$this->iterateNested($include, $item);
            } else {
                if (!is_null($item->{$include})) {
                    $item->{$include} = $item->{$include};
                }
            }
        }

        return $item;
    }

    public function iterateNested($include, $item, $key=null)
    {

        $exploded = $this->explodeNestedItem($include);
        $num = count($exploded);
        $count = 0;

        // iterating through each value exploded by dot
        foreach ($exploded as $key => $segment) {
            $last = (++$count === $num) ? true : false;

            /**
             * $last = if is last item of nested attribute
             * $key = key in array of working nested attribute
             * $segment = value in array of working nested attribute
             *
             * Possible solution: having the descriptors of where should be working
             * the value ($key) get the type of data and apply regarding if is a
             * array (recursive) or a single item on that key
             */
            if ($this->getItemAt($key, $item) instanceof Collection) {
                // many items to apply next include
            } else {
                // one item to apply next include
            }
        }
    }

    private function getItemAt($key, $item)
    {

    }

    private function iterateNestedOne($include, $item, $key, $segment)
    {
        $ex = $this->explodeNestedItem($include);

        $item->{$ex[$key]} = $item->{$ex[$key]};
        if($item->{$ex[$key]} instanceof Collection) {
            $this->iterateNestedMany($include, $item->{$ex[$key]}, $key, $ex[$key+1]);
        } else {
            if (end($ex) === $key) dd('okay');
            $this->iterateNestedOne($include, $item->{$ex[$key]}, $key, $ex[$key+1]);
        }
    }

    private function iterateNestedMany($include,$item, $key, $segment)
    {
        $ex = $this->explodeNestedItem($include);
        foreach ($item->{$segment} as $newItem) {
            if($item->{$ex[$key]} instanceof Collection) {
                $this->iterateNestedMany($include, $newItem, $key, $ex[$key]);
            } else {
                //dd(method_exists($item, 'get'.Str::camel($ex[$key+1]).'Attribute'));
                //if($item->{$ex[$key+1]} )
                //dd($include, $item, $newKey, $ex[$key+1]);
                $this->iterateNestedOne($include, $newItem, $key, $ex[$key]);
            }
        }
    }

    /**
     * @param $include
     * @return array
     */
    private function explodeNestedItem($include)
    {
        return explode('.', $include);
    }
}