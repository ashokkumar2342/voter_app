<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        
        return view('admin.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportGenerate(Request $request)
    {
      $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->setPrintHeader(FALSE); 
      $pdf->SetCreator(PDF_CREATOR); 
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
      $pdf->setFontSubsetting(true); 
      $pdf->SetFont('freesans', '', 11, '', true); 
      $pdf->AddPage();
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
      
      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='',$html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      ob_end_clean(); 
      $pdf->Output();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
