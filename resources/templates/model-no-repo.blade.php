##php namespace {{ $namespace or ''}}\Models;

use Cubicle7\Mvmnt\Models\MvmntModel;
use Carbon\Carbon;

class {{ $Model or ''}} extends MvmntModel
{

	// protected $connection = 'mysql-live';

	public static function boot() {
		parent::boot();
		static::creating(function(${{ $model or ''}}) { }); // returning false will cancel the operation
		static::created(function(${{ $model or ''}}) { });
		static::updating(function(${{ $model or ''}}) { }); // returning false will cancel the operation
		static::updated(function(${{ $model or ''}}) { });
		static::saving(function(${{ $model or ''}}) { });  // returning false will cancel the operation
		static::saved(function(${{ $model or ''}}) { });
		static::deleting(function(${{ $model or ''}}) { }); // returning false will cancel the operation
		static::deleted(function(${{ $model or ''}}) { });	
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

	{!! $content or '' !!}

	/*##############################################################################################
	scopes
	##############################################################################################*/

	/**
	 * Scope to search certain columns for a given string
	 *
	 * by Jake
	 *
	 * {{'@param'}}  $q string
	 * {{'@return'}} collection
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
	 * {{'@param'}}  
	 * {{'@return'}} query
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
	//  * {{'@param'}}  string  $value
	//  * {{'@return'}} string
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
	 * {{'@param'}}  $q
	 * {{'@return'}} result
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