<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Item",
 *      required={"quote_id", "quantity", "description", "price", "user_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="quote_id",
 *          description="quote_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="order",
 *          description="order",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="quantity",
 *          description="quantity",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          description="price",
 *          type="number",
 *          format="float"
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
class Item extends Model
{
    use SoftDeletes;

    public $table = 'items';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'quote_id',
        'order',
        'quantity',
        'description',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'quote_id' => 'integer',
        'order' => 'integer',
        'description' => 'string',
        'user_id' => 'integer',
        'quantity' => 'float',
        'price' => 'float',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'quote_id' => 'required|exists:quotes,id',
        'quantity' => 'required',
        'description' => 'required',
        'price' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function quote()
    {
        return $this->belongsTo(\App\Models\Quote::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getSubtotalAttribute()
    {
        return (float) $this->attributes['price'] * $this->attributes['quantity'];
    }
}
