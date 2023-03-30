<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\globalMutators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Search;

/**
 * @SWG\Definition(
 *      definition="OfferCategory",
 *      required={"title"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="entity_id",
 *          description="entity_id",
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
class OfferCategory extends Model
{
    use HasFactory, HasTranslations, globalMutators, Search;

    public $table = 'offer_categories';
    protected $searchableKeys = ['title'];
    public $translatable = ['title'];
    public $appends = ['title_ar'];
    public $fillable = [
        'title',
        'bu_id',
        'status'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title_ar' => 'required|max:50',
        'title_en' => 'required|max:50',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function offers()
    {
        return $this->hasMany(\App\Models\Offer::class, 'offer_category_id');
    }

    public function scopeBusinesUnit($q)
    {
        return $q->where('bu_id', request('bussinessUnit')->id);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
