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
      $options = array(  "UID" =>$username,  "PWD" =>$passward,  "Database" =>$database);
      $conn = sqlsrv_connect($serverName, $options); 
      if( $conn === false )
      {
      echo "Could not connect.\n";
      die( print_r( sqlsrv_errors(), true));
      }
      
      $query = "INSERT INTO dbo.deletions (ST_CODE) VALUES('$value')"; 
      $result = sqlsrv_query($conn,$query); 
       
      sqlsrv_close($conn);
      
       
     }     
       
}
