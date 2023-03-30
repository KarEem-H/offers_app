<?php 
/**
 * Created by VsCode.
 * php version 8.0
 * Date: 25/2/23
 * Time: 01:30 م
 *
 * @category CodeSniffer
 * @author   karim <karim.hemida>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use App\Traits\globalMutators;
use Illuminate\Database\Eloquent\Builder;

/**
 * Offer
 */
class Offer extends Model
{

    use HasFactory, HasTranslations, globalMutators;

    public $table = 'offers';

    public $translatable = [
        'title', 'slug', 'small_description', 'description', 'meta_keywords',
        'meta_description', 'offer_note', 'campaign', 'meta_title'
    ];


    protected $appends = ['title_ar', 'slug_ar', 'status_readable', 'end_at_readable', 'start_at_readable'];

    protected $casts = [
        'start_at' => 'date:Y/m/d',
        'end_at' => 'date:Y/m/d',
    ];

    public $files = ['photo', 'facebook_image', 'twitter_image', 'top_offer_image'];

    public $dir = 'offers/';

    public $fillable = [
        'title',
        'slug',
        'small_description',
        'description',
        'photo',
        'top_offer_image',
        'meta_keywords',
        'meta_description',
        'meta_title',
        'top_offer',
        'price',
        'discount_price',
        'image_title',
        'image_alt',
        'order',
        'offer_note',
        'status',
        'show_home',
        'start_at',
        'end_at',
        'campaign',
        'featured',
        'offer_category_id',
        'facebook_image',
        'twitter_image',
        'facebook_description',
        'facebook_title',
        'twitter_title',
        'twitter_description',
        'mobile_category_id',
        'mobile_show',
        'bu_id',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title_ar' => 'required|string|max:80',
        'title_en' => 'required|string|max:80',
        'slug_ar' => 'required|string|max:255',
        'slug_en' => 'required|string|max:255',
        'small_description_ar' => 'required|string|max:160',
        'small_description_en' => 'required|string|max:160',
        'description_ar' => 'required|string|max:255',
        'description_en' => 'required|string|max:255',
        'photo' => 'required|max:5000|image|mimes:webp,jpeg,png,jpg,svg', // |dimensions:ratio=16/9
        'top_offer_image' => 'required|max:5000|image|mimes:webp,jpeg,png,jpg,svg', // |dimensions:ratio=1/1
        'facebook_image' => 'nullable|image|max:5000',
        'twitter_image' => 'nullable|image|max:5000',
        'twitter_title' => 'nullable|string|max:191',
        'twitter_description' => 'nullable|string',
        'facebook_title' => 'nullable|string|max:191',
        'facebook_description' => 'nullable|string',
        'meta_keywords_ar' => 'nullable|string|max:255',
        'meta_keywords_en' => 'nullable|string|max:255',
        'meta_description_ar' => 'nullable|string',
        'meta_description_en' => 'nullable|string',
        'price' => 'required|integer',
        'discount_price' => 'required|integer|lte:price',
        'image_title' => 'nullable|string|max:255',
        'image_alt' => 'nullable|string|max:255',
        'order' => 'nullable|integer',
        'offer_note_ar' => 'string',
        'offer_note_en' => 'string',
        'start_at' => 'required|date',
        'end_at' => 'required|date|after:start_at',
        'campaign_ar' => 'nullable|string',
        'campaign_en' => 'nullable|string',
        'offer_category_id' => 'nullable',
        'status' => 'nullable|boolean',
        'show_home' => 'nullable|boolean',
        'is_replace' => 'nullable|boolean',
        'top_offer' => 'nullable|integer|min:0|max:1',
        'featured' => 'nullable',
        'mobile_category_id' => 'integer|exists:mobile_categories,id',
        'mobile_branch_ids' => 'required|string',

    ];

    /**
     *  MobileBranches
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function mobileBranches()
    {
        return $this->belongsToMany(MobileBranch::class, 'offer_mobile_branch');
    }

    /**
     * CTA
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function cta()
    {
        return $this->morphMany(\App\Models\CTA::class, 'countable');
    }

    /**
     * Clinics
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function clinics()
    {
        return $this->belongsToMany(
            \App\Models\Clinic::class,
            'offers_relations',
            'offer_id',
            'clinic_id'
        )->where('status', 1);
    }

    /**
     * Services
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'offers_relations', 'offer_id', 'service_id');
    }

    /**
     * Doctors
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function doctors()
    {
        return $this->belongsToMany(\App\Models\Doctor::class, 'offers_relations', 'offer_id', 'doctor_id');
    }

    /**
     * Bookings
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'offer_id');
    }

    /**
     * Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\OfferCategory::class, 'offer_category_id');
    }
    /**
     * MobileCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function mobileCategory()
    {
        return $this->belongsTo(\App\Models\MobileCategory::class, 'mobile_category_id');
    }

    /**
     * BusinessUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function businessUnit()
    {
        return $this->belongsTo(\App\Models\BusinessUnit::class, 'bu_id');
    }

    /**
     * MobileBranch
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function mobileBranch()
    {
        return $this->belongsTo(MobileBranch::class);
    }

    /**
     * ScopeAvailable
     *
     * @param QueryBuilder $query // Query
     * 
     * @return QueryBuilder
     */
    public function scopeAvailable($query)
    {
        return $query->whereDate('start_at', '<=', \Carbon\Carbon::now()->toDateString())
            ->whereDate('end_at', '>=', \Carbon\Carbon::now()->toDateString())
            ->where('status', 1);
    }



    /**
     * ScopeTopOffer
     *
     * @param QueryBuilder $query    // Query
     * @param Boolean      $topOffer // Boolean
     * 
     * @return QueryBuilder
     */
    public function scopeTopOffer($query, $topOffer)
    {
        if ($topOffer) {
            return $query->where('top_offer', 1);
        }
    }

    /**
     * ScopeBusinesUnit
     *
     * @param QueryBuilder $q // Query
     * 
     * @return QueryBuilder
     */
    public function scopeBusinesUnit($q)
    {
        return $q->where('bu_id', request('bussinessUnit')->id);
    }
    


    /**
     * IsAvailable
     *
     * @return void
     */
    public function isAvailable()
    {
        if ($this->end_at && ($this->end_at < \Carbon\Carbon::now()->toDateString())) {
            $this->status = $this->status == 1 ? 0 : 0;
            $this->save();
        }
        return;
    }

    /**
     * GetOfferNoteArAttribute
     *
     * @return string
     */
    public function getOfferNoteArAttribute()
    {
        return optional(json_decode($this->attributes['offer_note']))->ar ?? '';
    }

    /**
     * GetOfferNoteEnAttribute
     *
     * @return string
     */
    public function getOfferNoteEnAttribute()
    {
        return optional(json_decode($this->attributes['offer_note']))->en ?? '';
    }

    /**
     * GetStartAtReadableAttribute
     *
     * @return string
     */
    public function getStartAtReadableAttribute()
    {
        return $this->start_at ? $this->start_at->diffForHumans() : '-';
    }

    /**
     * GetEndAtReadableAttribute
     *
     * @return string
     */
    public function getEndAtReadableAttribute()
    {
        return $this->end_at ? $this->end_at->diffForHumans() : '-';
    }

    /**
     * AvailableClinics
     *
     * @return AnonymousResourceCollection
     */
    public function availableClinics()
    {
        return $this->clinics->count() ?
            $this->clinics :
            Clinic::query()->where('status', 1)->get();
    }

    /**
     * GetDiscountPercentageAttribute
     *
     * @return int
     */
    public function getDiscountPercentageAttribute()
    {
        return $this->price > 0 ?
            intval(round(((($this->price - $this->discount_price) / $this->price) * 100), 1))
            : 0;
    }

    /**
     * GetPhotoAttribute
     *
     * @param string $photo // photo
     *
     * @return string
     */
    public function getPhotoAttribute($photo): string
    {
        return $photo ? url('storage/' . $photo) : "";
    }

    /**
     * GetTopOfferImageAttribute
     *
     * @param string $topOfferImage // topOfferImage
     *
     * @return string
     */
    public function getTopOfferImageAttribute($topOfferImage): string
    {
        return $topOfferImage ? url('storage/' . $topOfferImage) : "";
    }

}
