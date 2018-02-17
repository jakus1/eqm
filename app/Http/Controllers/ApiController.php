<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Member;
use App\Models\Communication;
use App\Models\Message;
use App\Models\Tag;
#end_model_uses

use App\Traits\ApiCtrl\MemberTrait;
use App\Traits\ApiCtrl\CommunicationTrait;
use App\Traits\ApiCtrl\MessageTrait;
use App\Traits\ApiCtrl\TagTrait;
#end_trait_uses

class ApiController extends BaseController
{

	use MemberTrait;
	use CommunicationTrait;
	use MessageTrait;
	use TagTrait;
	#end_traits_uses
}
