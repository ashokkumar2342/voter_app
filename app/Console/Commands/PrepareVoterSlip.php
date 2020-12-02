<?php

namespace App\Console\Commands;

use App\Admin;
use App\Helper\MyFuncs;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlocksMc;
use App\Model\DefaultValue;
use App\Model\History;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use App\Model\VoterListProcessed;
use App\Model\WardVillage;
use App\Model\MainPageDetails;
use App\Model\PollingBooth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrepareVoterSlip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preparevoterslip:generate {district_id} {block_id}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'preparevoterslip generate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    //\Log::info(date('Y-m-d H:i:s'));
    public function handle()
    { 
        
    ini_set('max_execution_time', '3600');
    ini_set('memory_limit','999M');
    ini_set("pcre.backtrack_limit", "100000000");
    $district_id = $this->argument('district_id'); 
    $block_id = $this->argument('block_id'); 
    $blockcode=BlocksMc::find($block_id); 
    // $VoterListProcessed=VoterListProcessed::where('district_id',$district_id)->where('block_id',$block_id)->where('village_id',$village_id)->where('ward_id',$ward_id)->where('voter_list_master_id',$voterListMaster->id)->where('booth_id',$booth_id)->first();


    $dirpath = Storage_path() . '/app/voterslip/'.$block_id;
    @mkdir($dirpath, 0755, true);
    $filepath = Storage_path() . '/app/voterslip/'.$block_id .'/'.$block_id.'.pdf';

    $voterReports=Voter::get()->take(20);
    $path=Storage_path('fonts/');
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir']; 
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata']; 
    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
                 __DIR__ . $path,
             ]),
             'fontdata' => $fontData + [
                 'frutiger' => [
                     'R' => 'FreeSans.ttf',
                     'I' => 'FreeSansOblique.ttf',
                 ]
             ],
             'default_font' => 'freesans',
         ]);
    $html = view('admin.master.PrepareVoterSlip.slip',compact('voterReports'));
    $mpdf->WriteHTML($html);
    $mpdf->Output($filepath, 'F');
     

    }

     
    
       
}
