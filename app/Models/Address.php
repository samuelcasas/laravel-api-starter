<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Address",
 *      required={"address"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="email address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="emaileable_id",
 *          description="emaileable_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="emaileable_type",
 *          description="emaileable_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Address extends Model
{
    use SoftDeletes;

    public $table = 'addresses';

    protected $geofields = array('location');

    protected $dates = ['deleted_at'];

    public $fillable = [
        'street',
        'extended',
        'city',
        'state',
        'zip',
        'country',
        'location',
        'primary',
        'type'
    ];

    protected $hidden = ['addressable_id','addressable_type'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'primary' => 'bool',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'address' => 'required',
        'type' => 'required'
    ];

    public function entity()
    {
        return $this->morphTo('addressable');
    }

    public function makePrimary()
    {
        $this->entity->addresses()->where('primary', 1)->update([ 'primary' => 0 ]);

        $this->update([ 'primary' => 1 ]);

        return $this->fresh();
    }

    public function setLocationAttribute($value) {
        $lat = $value['lat'];
        $lng = $value['lng'];
        if($lat && $lng) {
            $this->attributes['location'] = \DB::raw("POINT($lat,$lng)");
        }
    }

    public function getLocationAttribute($value){
        $loc = preg_replace('/[ ,]+/', ',', substr($value, 6), 1);
        $loc =explode(',',substr($loc,0,-1));

        return ['lat' => $loc[0], 'lng' => $loc[1]];
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',\DB::raw($raw));
    }
}
