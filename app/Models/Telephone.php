<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Telephone",
 *      required={"number"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          description="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="telephoneable_id",
 *          description="telephoneable_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="telephoneable_type",
 *          description="telephoneable_type",
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
class Telephone extends Model
{
    use SoftDeletes;

    public $table = 'telephones';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'number',
        'primary'
    ];

    protected $hidden = ['telephoneable_id','telephoneable_type'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'number' => 'string',
        'telephoneable_id' => 'integer',
        'telephoneable_type' => 'string',
        'primary' => 'bool',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'number' => 'required'
    ];

    public function entity()
    {
        return $this->morphTo('telephoneable');
    }

    public function makePrimary()
    {
        $this->entity->telephones()->where('primary', 1)->update([ 'primary' => 0 ]);

        $this->update([ 'primary' => 1 ]);

        return $this->fresh();
    }
}
