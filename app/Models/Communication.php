<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Communication extends Model
{

	// protected $connection = 'mysql-live';

	public static function boot() {
		parent::boot();
		static::creating(function($communication) { }); // returning false will cancel the operation
		static::created(function($communication) { });
		static::updating(function($communication) { }); // returning false will cancel the operation
		static::updated(function($communication) { });
		static::saving(function($communication) { });  // returning false will cancel the operation
		static::saved(function($communication) { });
		static::deleting(function($communication) { }); // returning false will cancel the operation
		static::deleted(function($communication) { });	
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

	protected $table = 'communications';
	protected $softDelete = true;
	protected $fillable = [
		'body'
	];

	/*##############################################################################################
	Relationships
	##############################################################################################*/
	
	public function messages()
	{
		return $this->hasMany(\App\Models\Messages::class);
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
}