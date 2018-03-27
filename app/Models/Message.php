<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{

	// protected $connection = 'mysql-live';

	public static function boot() {
		parent::boot();
		static::creating(function($message) { }); // returning false will cancel the operation
		static::created(function($message) { });
		static::updating(function($message) { }); // returning false will cancel the operation
		static::updated(function($message) { });
		static::saving(function($message) { });  // returning false will cancel the operation
		static::saved(function($message) { });
		static::deleting(function($message) { }); // returning false will cancel the operation
		static::deleted(function($message) { });	
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

	protected $table = 'messages';
	protected $softDelete = true;
	protected $fillable = [
		'body'
	];

	/*##############################################################################################
	Relationships
	##############################################################################################*/
	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function communication()
	{
		return $this->belongsTo(\App\Models\Communication::class);
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