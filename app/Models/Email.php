<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Email",
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
class Email extends Model
{
    use SoftDeletes;

    public $table = 'emails';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'address',
        'primary',
        'type'
    ];

    protected $hidden = ['emaileable_id','emaileable_type'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'address' => 'string',
        'emaileable_id' => 'integer',
        'emaileable_type' => 'string',
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
        return $this->morphTo('emaileable');
    }

    public function makePrimary()
    {
        $this->entity->emails()->where('primary', 1)->update([ 'primary' => 0 ]);

        $this->update([ 'primary' => 1 ]);

        return $this->fresh();
    }
}
