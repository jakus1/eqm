// [Model]Trait routes
Route::get('all-[models]/{q?}/{count?}', 'ApiController@getAll[Models]');
Route::get('[models]-by-parent/{parent_id}/{parent_type?}', 'ApiController@get[Models]ByParent');
Route::get('[models]-by-property/{property_name}/{property_value}', 'ApiController@get[Models]ByProperty');
Route::get('[model]/{id}', 'ApiController@get[Model]');
Route::post('[model]', 'ApiController@post[Model]');
Route::put('[model]/{id}', 'ApiController@put[Model]');
Route::delete('[model]/{[model]_id}', 'ApiController@delete[Model]');

