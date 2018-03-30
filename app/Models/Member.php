<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Models\TagTrait;
use Carbon\Carbon;

class Member extends Model
{
	use TagTrait, Notifiable, SoftDeletes;

	public static function boot() {
		parent::boot();
		static::creating(function($member) { }); // returning false will cancel the operation
		static::created(function($member) { });
		static::updating(function($member) { }); // returning false will cancel the operation
		static::updated(function($member) { });
		static::saving(function($member) { });  // returning false will cancel the operation
		static::saved(function($member) { });
		static::deleting(function($member) { }); // returning false will cancel the operation
		static::deleted(function($member) { });	
	}

	/*##############################################################################################
	Properties
	##############################################################################################*/

	// Don't forget to fill this array
	public static $rules = [
		'create' => [
			// 'name' => 'required',
		],
		'update' => [
			// 'name' => 'required',
		]
	];

	protected $appends = [
		// 'accessor'
	];

	// protected $primary_controller = \App\Http\Controllers\[Models]Controller::class;

	protected $dates = [];
	
	public function newQuery()
	{
		return parent::newQuery();
	}

	protected $table = 'members';
	protected $softDelete = true;
	protected $fillable = [
		'first',
		'last',
		'email',
		'status',
		'sms_phone',
		'description'
	];

	/*##############################################################################################
	Relationships
	##############################################################################################*/

    public function messages()
	{
		return $this->hasMany(\App\Models\Message::class);
	}

	public function addMessage($subject, $body) {
		return $this->messages()->create(compact('subject', 'body'));
	}

	/*##############################################################################################
	scopes
	##############################################################################################*/

	/**
	 * Scope to search certain columns for a given string
	 *
	 * by Jake
	 *
	 * @param  $q string
	 * @return collection
	 */
	public function scopeBySearch($query,$q){

		$query->where(function($qry) use ($q) {
			$qry->where('id',$q)
				// ->orWhere('another_column', 'like', '%' . $q . '%')
				// ->orWhere('name', 'like', '%' . $q . '%')
				;
		});
	}

	/**
	 * Scope to search for 'active' members
	 * by Richard
	 *
	 * @param 
	 * @return collection
	 */
	public function scopeActive($query) {
		return $query->where('status', '=', 'active');
	}

	/**
	 * Scope to order records by the most recently changed
	 *
	 * by Jake
	 *
	 * @param  
	 * @return query
	 */
	public function scopeMostRecent($query){
		$query->orderBy('updated_at','desc')
			->orderBy('created_at','desc');
	}

	
	/*##############################################################################################
	Accessors
	##############################################################################################*/

	// // following is an accessor that relies on a lazy loaded relationship
	// /**
	//  * Arrayify the tasks
	//  *
	//  * @param  string  $value
	//  * @return string
	//  */
	// public function getSomethingAttribute()
	// {
	// 	if((isset($this->relations['somethings']))&&(count($this->relations['somethings']) > 0)){
	// 		$somethings = $this->somethings;
	// 		$somethinglist = $somethings->pluck('name','id');
	// 		return $somethinglist->all();
	// 	}
	// 	return [];
	// }
	
	/*##############################################################################################
	Mutators
	##############################################################################################*/
	
	/*##############################################################################################
	Other Methods
	##############################################################################################*/

	/**
	 * Default search sent to the ElasticSearch engine
	 *
	 * by Jake
	 *
	 * @param  $q
	 * @return result
	 */
	public static function defaultSearch($q)
	{
		return self::elasticSearch('query_string',$q,[
			'fields' => ['name^5'],
			// 'fuzziness' => 'auto',
			'default_operator' => 'AND'
		]);
	}
    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return '1'.$this->sms_phone;
	}
}