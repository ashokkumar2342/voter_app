<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\ReportType;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function PrintVoterList()
    {
        
        return view('admin.report.index');
    } 
    public function PrintVoterListGenerate(Request $request)
    {
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
             'pagenumPrefix' => '',
            'pagenumSuffix' => '',
            'nbpgPrefix' => ' कुल ',
            'nbpgSuffix' => ' पृष्ठों का पृष्ठ'
         ]); 
          
      if ($request->report==1) {  
       $voterReports= DB::select(DB::raw("select `a`.`code`, `a`.`name_e`, `a`.`name_l`, `ap`.`part_no`,(Select Count(*) From `voters` where `assembly_part_id` = `ap`.`id` ) as `Total_Votes`,(Select Count(*) From `voters` where `assembly_part_id` = `ap`.`id` and `village_id` <> 0) as `Mapped_Votes`from `assemblys` `a`Inner Join `assembly_parts` `ap` on `ap`.`assembly_id` = `a`.`id`Order by `a`.`code`, `ap`.`part_no`;"));
       
      $html = view('admin.report.report1',compact('voterReports'));
      }
      elseif ($request->report==2) {
      $voterReports= DB::select(DB::raw("select `a`.`code`, `a`.`name_e`, `a`.`name_l`, `ap`.`part_no`, `v`.`name_e`, `v`.`name_l`from `assemblys` `a`Inner Join `assembly_parts` `ap` on `ap`.`assembly_id` = `a`.`id`Left Join `villages` `v` on `v`.`id` = `ap`.`village_id`Order by `a`.`code`, `ap`.`part_no`;"));
      $html = view('admin.report.report2',compact('voterReports'));
      }
      elseif ($request->report==3) {
      $voterReports= DB::select(DB::raw("select `a`.`code`, `a`.`name_e`, `a`.`name_l`, `ap`.`part_no`, `v`.`name_e`, `v`.`name_l`from `assemblys` `a`Inner Join `assembly_parts` `ap` on `ap`.`assembly_id` = `a`.`id`Inner Join `villages` `v` on `v`.`id` = `ap`.`village_id`Order by `v`.`name_e`, `a`.`code`, `ap`.`part_no`;"));
      $html = view('admin.report.report3',compact('voterReports'));
      }
      elseif ($request->report==4) {
      $voterReports= DB::select(DB::raw("select `v`.`name_e`, `v`.`name_l`, `wv`.`ward_no`, (Select Count(*) From `voters` where `ward_id` = `wv`.`id` ) as `Total_Votes`from `villages` `v`Inner Join `ward_villages` `wv` on `wv`.`village_id` = `v`.`id`Order By `v`.`name_e`, `wv`.`ward_no`;"));
      $html = view('admin.report.report4',compact('voterReports'));
      }
      
      $mpdf->WriteHTML($html); 
      $mpdf->Output();
    }

    ///--------------------------------report--------report----------------------------

    public function Report($value='')
    {
      $reportTypes=ReportType::OrderBy('id','ASC')->get();
      return view('admin.report.report.index',compact('reportTypes'));  
    }
    

    public function ReportGenerateExcel(Request $request)
    {
      // dd($request);
      $report_type = $request->report_type_id;
      $user=Auth::guard('admin')->user();  
      $user_role = $user->role_id;
      $user_id = $user->id;
      if ($user_role==1){
        $condition = "";
      }elseif($user_role==2){
        $condition = " Where `v`.`districts_id` in (select `district_id` from `user_district_assigns` where `user_id` = $user_id) ";
      }elseif($user_role==3){
        $condition = "";
      }elseif($user_role==4){
        $condition = "";
      }

      if ($report_type == 1){
        $tcols = 5;
        $qcols = array(
          array('Block Name'),
          array('Village Name (E)'),
          array('Village Name (H)'),
          array('Total Wards'),
          array('Zila Parishad Ward No.')
          ); 
        $villagewards=DB::
        select(DB::raw("select `b`.`name_e` as `block_name`, `v`.`name_e`, `v`.`name_l`, (Select Count(*) From `ward_villages` `wv` Where `wv`.`village_id` = `v`.`id`) as `twards`, `wz`.`ward_no` as `zp_wardno`
        from `villages` `v`
        Inner Join `blocks_mcs` `b` on `b`.`id` = `v`.`blocks_id`
        Left Join `ward_zp` `wz` on `wz`.`id` = `v`.`zp_ward_id` $condition Order By `b`.`name_e`, `v`.`name_e`;"));
      }elseif ($report_type == 2){
        $tcols = 8;
        $qcols = array(
          array('Block Name'),
          array('Village Name'),
          array('Ward No.'),
          array('PS Ward No.'),
          array('Male'),
          array('Female'),
          array('Third'),
          array('Total')
          ); 
        $villagewards=DB::
        select(DB::raw("select `b`.`name_e` as `block_name`, `v`.`name_e`, `wv`.`ward_no`, `wps`.`ward_no` as `ps_wardno`,
          (Select Count(`id`) from `voters` where `status` in (0,1,3) and `gender_id` = 1 and `ward_id` = `wv`.`id`) as `tmale`,
          (Select Count(`id`) from `voters` where `status` in (0,1,3) and `gender_id` = 2 and `ward_id` = `wv`.`id`) as `tfemale`,
          (Select Count(`id`) from `voters` where `status` in (0,1,3) and `gender_id` = 3 and `ward_id` = `wv`.`id`) as `third`,
          (Select Count(`id`) from `voters` where `status` in (0,1,3) and `ward_id` = `wv`.`id`) as `tvote`
          from `ward_villages` `wv`
          Inner Join `villages` `v` on `v`.`id` = `wv`.`village_id`
          Inner Join `blocks_mcs` `b` on `b`.`id` = `v`.`blocks_id`
          Left Join `ward_ps` `wps` on `wps`.`id` = `v`.`ps_ward_id` $condition
          Order By `b`.`name_e`, `v`.`name_e`, `wv`.`ward_no`;"));
      }

      
      return view('admin.report.report.result_data',compact('villagewards', 'report_type', 'tcols', 'qcols'));  
    }
    


    public function ReportGeneratePDF(Request $request)
    {
        $user=Auth::guard('admin')->user();

        $voterReports= DB::select(DB::raw("select `v`.`name_e`, `v`.`name_l`, `wv`.`ward_no`, (Select Count(*) From `voters` where `ward_id` = `wv`.`id` ) as `Total_Votes`from `villages` `v`Inner Join `ward_villages` `wv` on `wv`.`village_id` = `v`.`id`Order By `v`.`name_e`, `wv`.`ward_no`;"));
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
             'pagenumPrefix' => '',
            'pagenumSuffix' => '',
            'nbpgPrefix' => ' कुल ',
            'nbpgSuffix' => ' पृष्ठों का पृष्ठ'
         ]); 
         $html = view('admin.report.report.result_pdf',compact('voterReports'));
         $mpdf->WriteHTML($html); 
         $mpdf->Output(); 
      
    }


    public function voterCardPrint($value='')
    {
      return view('admin.cardprint.index');  
    }
    public function voterCardPrintGenerate(Request $request)
    {
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
             'pagenumPrefix' => '',
            'pagenumSuffix' => '',
            'nbpgPrefix' => ' कुल ',
            'nbpgSuffix' => ' पृष्ठों का पृष्ठ'
         ]);
         //statrt----barcode
         // $value=$request->voter_card_no;
         // $barcode = new BarcodeGenerator();
         // $barcode->setText($value);
         // $barcode->setType(BarcodeGenerator::Code128);
         // $barcode->setScale(2);
         // $barcode->setThickness(25);
         // $barcode->setFontSize(10);
         // $code = $barcode->generate();
         // $data = base64_decode($code);
        
         //end--barcode
         $html = view('admin.cardprint.print',compact('voterReports')); 
         $mpdf->WriteHTML($html); 
         $mpdf->Output();  
    } 
}
