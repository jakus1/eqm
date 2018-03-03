<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\ImportFinished;
use League\Csv\Reader;
use Log;
use Mail;
use Storage;
use App\Models\Member;

class ImportUploadedFile implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $fileWithPath;
	public $orgId;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($fileWithPath)
	{
		$this->fileWithPath = $fileWithPath;
		// $this->orgId = $orgId;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		if (Storage::disk('local')->exists($this->fileWithPath)) {
			$csv = Reader::createFromPath(storage_path('app/'.$this->fileWithPath), 'r');
			$csv->setHeaderOffset(0);
			$header = $csv->getHeader();
			$messageLines = [];
			foreach ($csv as $offset => $record) {
				if(empty($record['action'])){
					$messageLines[] = "Skipped record ".$offset.". No action was set.";
					continue;
				}
				if(strtolower($record['action']) == 'delete'){
					$member = Member::where('last',$record['Last Name'])->where('first',$record['First Name'])->first();
					if(!is_null($member)){
						$member->delete();
					}
					$messageLines[] = "Deleted record ".$offset."... ".$record['First Name']." ".$record['Last Name'].".";
					continue;
				}
				if(strtolower($record['action']) == 'dormant'){
					$member = Member::where('last',$record['Last Name'])->where('first',$record['First Name'])->first();
					if(!is_null($member)){
						$member->update(['status'=>'Dormant']);
					}
					$messageLines[] = "Record ".$offset." set as Dormant... ".$record['First Name']." ".$record['Last Name'].".";
					continue;
				}
				$member = Member::firstOrCreate(['last'=>$record['Last Name'],'first'=>$record['First Name']]);
				$phone = preg_replace("/[^0-9]/", "", $record['Phone'] );
				$member->update(['email'=>$record['Email'],'sms_phone'=>$phone,'status'=>'Active']);
				$messageLines[] = "Updated email and sms_phone for record ".$offset."...".$record['First Name']." ".$record['Last Name'].".";
				if(!empty($record['tags'])){
					$tags = [];
					if(str_contains($record['tags'], ' ')) {
						$tags = explode(" ",$record['tags']);
					} else {
						$tags[] = $record['tags'];
					}
					$member->tags()->delete();
					foreach($tags as $tag){
						$member->tags()->create(['tag'=>$tag]);
					}
					$messageLines[] = "Added tags:".implode(", ",$tags)." for record ".$offset."...".$record['First Name']." ".$record['Last Name'].".";
				}
			}
			Log::info('Import Notes'.print_r($messageLines, true));
			Mail::to('jake@barlowshomes.com')
				->send(new ImportFinished($messageLines));
		} else {
		}
	}
}
