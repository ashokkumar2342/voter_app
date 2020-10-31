<?php

namespace App\Console\Commands;

use App\Admin;
use App\Helper\MyFuncs;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\DefaultValue;
use App\Model\History;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class MysqlDataTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysqldata:transfer';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mysqldata Transfer ';

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
    public function handle()
    {   
      $serverName=getenv('DB_HOST_2');
      $database=getenv('DB_DATABASE_2');
      $username=getenv('DB_USERNAME_2');
      $passward=getenv('DB_PASSWORD_2'); 
      $serverName =$serverName;
      $options = array(  "UID" =>$username,  "PWD" =>$passward,  "Database" =>$database, "CharacterSet" => "UTF-8");
      $conn = sqlsrv_connect($serverName, $options); 
      if( $conn === false )
      {
      echo "Could not connect.\n";
      die( print_r( sqlsrv_errors(), true));
      }
      
      $query = "Truncate Table [District]"; 
      $result = sqlsrv_query($conn,$query); 

      $query = "Truncate Table [Block]"; 
      $result = sqlsrv_query($conn,$query); 

      $query = "Truncate Table [Panchayat]"; 
      $result = sqlsrv_query($conn,$query); 

      $query = "Truncate Table [b02]"; 
      $result = sqlsrv_query($conn,$query); 

      echo "Porting Stared.".date("d-m-y H:i:s")."\n";

      $districts=DB::
        select(DB::raw("select `d`.`id`, `s`.`code` as `scode`, `s`.`name_e` as `sname`, `d`.`name_e`, `d`.`code` 
          from `districts` `d`
          Inner Join `states` `s` on `s`.`id` = `d`.`state_id`;"));

      foreach ($districts as $district) {
        echo "Porting District '$district->name_e'.\n";
        if(strlen($district->scode)>2){
          die( "length of State Code cannot be more than 2.\n");
        }
        if(strlen($district->code)>2){
          die( "length of District Code cannot be more than 2.\n");
        }
        $query = "Insert Into [District] ([State_code], [State_Name], [DisttName], [DisttCode], [flag]) Values ('$district->scode', '$district->sname', '$district->name_e', '$district->code', 'Y')"; 
        $result = sqlsrv_query($conn,$query);


        $blocks=DB::
          select(DB::raw("Select `bl`.`id`, `bl`.`code` as `blcode`, `bl`.`name_l` as `blname_l`, `d`.`code`, `d`.`name_e`, `bl`.`name_e` as `blname_e` From `blocks_mcs` `bl` Inner Join `districts` `d` On `d`.`id` = `bl`.`districts_id` where `bl`.`districts_id` = '$district->id';"));

        foreach ($blocks as $block) {
          echo "Porting Block '$block->blname_e'.\n";
          if(strlen($block->blcode)>2){
            die( "length of Block Code cannot be more than 2.\n");
          }
        
          $query = "Insert Into [Block] ([CODE], [desc1], [distt], [disttcode], [NAme_eng]) Values ('$block->blcode', N'$block->blname_l', '$block->name_e', '$block->code', '$block->blname_e')"; 
          $result = sqlsrv_query($conn,$query);


          $villages=DB::
            select(DB::raw("select `vl`.`id`, `bl`.`code` as `blcode`, `vl`.`code` as `vlcode`, `vl`.`name_e`, `vl`.`name_l`, `d`.`code` as `dcode` from `villages` `vl` inner join `blocks_mcs` `bl` on `bl`.`id` = `vl`.`blocks_id` inner join `districts` `d` on `d`.`id` = `vl`.`districts_id` where `vl`.`blocks_id` = $block->id;"));

          foreach ($villages as $village) {
            echo "Porting Village '$village->name_e'.\n";
            if(strlen($village->vlcode)>3){
              die( "length of Panchayat Code cannot be more than 3.\n");
            }
        
            $query = "Insert Into [Panchayat] ([BLOCK], [V_CODE], [NAME], [HNAME], [PCODE], [disttcode]) Values ('$village->blcode', '$village->vlcode', '$village->name_e', N'$village->name_l', '$village->vlcode', '$village->dcode')"; 
            $result = sqlsrv_query($conn,$query);


            $voters=DB::
            select(DB::raw("select `ac`.`code`, `wv`.`ward_no`, `ap`.`part_no`, `vd`.`sr_no`, `vd`.`house_no_e`,
              `vd`.`name_e`, `vd`.`father_name_e`, `vd`.`voter_card_no`, `vd`.`age`, `g`.`code` as `gcode`, `rl`.`code` as `rcode`, `vd`.`name_l`, `vd`.`father_name_l`, `vd`.`house_no`, `vd`.`print_sr_no`, `vd`.`mobile_no` 
              from `voters` `vd` Inner Join `assemblys` `ac` on `ac`.`id` = `vd`.`assembly_id` inner join `assembly_parts` `ap` on `ap`.`id` =`vd`.`assembly_part_id` Inner Join `relation` `rl` on `rl`.`id` = `vd`.`relation` inner Join `genders` `g` on `g`.`id` = `vd`.`gender_id` inner Join `ward_villages` `wv` on `wv`.`id` = `vd`.`ward_id` Where `vd`.`status` in (0,1,2) And `vd`.`village_id` = $village->id;"));

            foreach ($voters as $voter) {
        
              $query = "Insert Into [b02] ([DisttCode], [AC_NO], [Block_Code], [GP_Code],
              [GP_Ward], [PART_NO], [SLNOINPART], [HOUSE_NO], 
              [FM_NAME], [RLN_FM_NM], [IDCARD_NO], [SEX],
              [AGE], [status], [name_eng], [fname_eng],
              [Rln], [numric_hno], [srn], [mobileno], [uflag]
              ) 
                Values ('$district->code', '$voter->code', '$block->blcode', '$village->vlcode',
                '$voter->ward_no', '$voter->part_no', '$voter->sr_no', '$voter->house_no_e',
                N'$voter->name_l', N'$voter->father_name_l', '$voter->voter_card_no', '$voter->gcode',
                '$voter->age', 'O', '$voter->name_e', '$voter->father_name_e',
                '$voter->rcode', '$voter->house_no', '$voter->print_sr_no', '$voter->mobile_no', 0
                )"; 
              $result = sqlsrv_query($conn,$query);

            }

          }


        }


      }

      echo "Porting Successfully.".date("d-m-y H:i:s")."\n";

      sqlsrv_close($conn);
      
       
     }     
       
}
