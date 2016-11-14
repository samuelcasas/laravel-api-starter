<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

class IncludeParser
{
    private $includes;
    private $item;

    public function __construct($includes, $item)
    {
        $this->includes = $includes;
        $this->item = $item;
    }

    public function process()
    {
        $this->iterate();

        return $this->item;
    }

    private function iterate()
    {
        foreach ($this->includes as $include) {
            if (strpos($include, '.') !== false) {
                $this->iterateNested($include, $this->item);
            } else {
                if ($result = $this->item->{$include}) {
                    $this->item->{$include} = $this->item->{$include};
                }
            }
        }
    }

    /**
     * @param $include
     */
    private function iterateNested($include, $item, $key=false)
    {
        if($key){
            dd('has key', $key);
        } else {
            foreach (explode('.', $include) as $key => $segment) {
                if(method_exists($item, $segment)){
                    $item->{$segment}();
                }
                $val = $item->{$segment};

                if ($val instanceof Collection) {
                    $this->iterateNested($include, $val, $key);
                }
            }
        }
    }

    private function parseIterated($segments)
    {
        foreach ($segments as $segment) {

        }
    }
}