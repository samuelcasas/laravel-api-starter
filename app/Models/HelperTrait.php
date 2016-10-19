<?php

namespace App\Models;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Builder;

trait HelperTrait
{
    use PimpableTrait;

    protected function getNotSearchableAttributes() {
        return ['page', 'per_page', 'sort', 'with', 'token', 'filter'];
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
}