<?php

namespace App\Http\Controllers;

use App\Model\VoterImage;
use App\Model\VoterListMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
   
    public function barcode(Request $request)
    {  
      try { 
        $results = VoterImage::findOrFail(22); 
          // Closures include ->first(), ->get(), ->pluck(), etc.
      } catch(\Illuminate\Database\ModelNotFoundException $ex){ 
        dd($ex->getMessage()); 
        // Note any method of class PDOException can be called on $ex.
      }
        // foreach ([1,2] as $val) {
        //     //code 
        //     try { 
        //        $file =$request->file;
        //        $imagedata = file_get_contents($file);
        //        $base64 = base64_encode($imagedata);
                
        //        $voterimage =new VoterImage();  
        //        if ($val==2) {
        //           $voterimage->voter_id = 'सोनिया';
        //        }else{
        //          $voterimage->voter_id = 1;
                
        //        }
        //        $voterimage->image = 'सोनिया^'; 
        //        $voterimage->saveOrFail();
        //     }
        //     catch (ModelNotFoundException $exception) {
        //         // add error
        //         continue;
        //     }
        // }
      // try {
        
         
       // return redirect()->back();
       
       // $input = $request->barcode; 
       
       // if (strlen($input)==0) {
       //   echo 'no input';
       //   exit;
       // }

       // $datas = explode("\n", str_replace("\r", "", $input)); 
       // foreach ($datas as $key => $value) {
       //   $barcode =$value;
       //   $name = $barcode.".jpg";
 
       //   $url ='https://barcode.tec-it.com/barcode.ashx?data='.$barcode.'&code=Code128&dpi=96&dataseparator=';
 
       //   $url ='https://barcode.tec-it.com/barcode.ashx?data='.$barcode.'&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&&dpi=96&imagetype=Jpg&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0';
 
       //   $file = file_put_contents( $name, file_get_contents($url) );

       //   if(!$file){
       //       return "ERROR: Failed to write data to ".$name.", check permissions\n";
       //   }
       //   else
       //   {
                       
       //   $path = $name;
       //   $type = pathinfo($path, PATHINFO_EXTENSION);
       //   $data = file_get_contents($path);
       //   $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); 
       //   $data = base64_decode(base64_encode($data));
       //     $image_name= $name;     
       //     $path = Storage_path() . "/app/public/barcode/" . $image_name;
       //     file_put_contents($path, $data);  
       //     if ($value!=null) {
       //         sleep(1); 
       //     }
            
       //   }  

       //  } 
       //  return redirect()->back(); 

    
    }

     public function barcodeShow(Request $reqeust)
    { return $request->all();
       $datas = VoterImage::get(); 

      //  $voterListMaster=VoterListMaster::where('status',1)->first(); 
      //  $PrepareVoterListSave= DB::select(DB::raw("call up_process_voterlist ('$request->ward')"));  
      //  $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$request->ward;")); 
      //  $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $request->ward;"));
      // $voterReports = DB::select(DB::raw("select `hpsn`.`print_sr_no`,`v`.`voter_card_no`, case `source` when 'V' then concat('*', `ap`.`part_no`, '/', `v`.`sr_no`) Else 'New' End as `part_srno`, `v`.`name_l`, case `v`.`relation` When 'F' then 'पिता' When 'H' Then 'पति' End as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l`, `vi`.`image` from `history_print_sr_no` `hpsn` inner join `voters` `v` on `v`.`id` = `hpsn`.`voter_id` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `hpsn`.`gender_id` LEFT JOIN `voter_image` `vi` on `vi`.`voter_id` = `v`.`id` 
      //    where `hpsn`.`supliment_no` = 1 And `hpsn`.`ward_id` =$request->ward And `hpsn`.`status` in (0,1,3) Order By `hpsn`.`print_sr_no`; ")); 
     
      // $image=$data->image;
      // $image=Storage_path('1.png');
     

         
        // $path=Storage_path('fonts/');
        // $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir']; 
        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata']; 
        //  $mpdf = new \Mpdf\Mpdf([
        //      'fontDir' => array_merge($fontDirs, [
        //          __DIR__ . $path,
        //      ]),
        //      'fontdata' => $fontData + [
        //          'frutiger' => [
        //              'R' => 'FreeSans.ttf',
        //              'I' => 'FreeSansOblique.ttf',
        //          ]
        //      ],
        //      'default_font' => 'freesans',
        //      'pagenumPrefix' => '',
        //     'pagenumSuffix' => '',
        //     'nbpgPrefix' => ' कुल ',
        //     'nbpgSuffix' => ' पृष्ठों का पृष्ठ'
        //  ]);
          

          
        //  $html = view('pdf',compact('datas')); 
        //  $mpdf->WriteHTML($html); 
        //  $mpdf->Output(); 
        // return view('pdf');
    } 

    public function barcodeFirst()
    {

      foreach ([1,2,3] as $val) {
          //code 
          try { 
              
              
             $voterimage =new VoterImage();  
             if ($val==2) {
                $voterimage->voter_id = 'सोनिया';
             }else{
               $voterimage->voter_id = 1;
              
             }
             $voterimage->image = 'सोनिया^'; 
             $voterimage->saveOrFail();
          }
          catch (\Exception $ex) {
              // add error
            
              continue;
          }
      }




      // try { 
      //   $cards = DB::select("SELECT
      //           voter_image.id as id
      //       FROM voter_imagea");
      //   dd($cards);
        
      //     // Closures include ->first(), ->get(), ->pluck(), etc.
      // } catch(\Exception $ex){ 
      //   dd($ex->getMessage()); 
      //   // Note any method of class PDOException can be called on $ex.
      // }

  }
}
