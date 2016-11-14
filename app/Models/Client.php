<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Client",
 *      required={"name", "prefix"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="prefix",
 *          description="prefix",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
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
class Client extends Model
{
    use SoftDeletes, HelperTrait, SoftCascadeTrait, Telephoneable;

    protected $softCascade = ['contacts','quotes'];
    public $table = 'clients';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'name',
        'prefix'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'prefix' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'prefix' => 'required|unique:clients,prefix' // todo unique between user scope
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function getContactsCountAttribute()
    {
        return (int) $this->contacts()->count();
    }

    public function getQuotesCountAttribute()
    {
        return (int) $this->quotes()->count();
    }
}
