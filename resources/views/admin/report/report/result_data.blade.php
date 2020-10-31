<div class="row"> 
<div class="col-lg-12 table-responsive"> 
    <table class="table" id="village_ward_sample_table">
        <thead>
          <tr>
            @php
              $countr = 0;
              while ($countr < $tcols ){
                @endphp
                <th>{{ $qcols[$countr][0] }}</th>
                @php
                $countr = $countr+1;
              }
            @endphp
          </tr>
        </thead>
        <tbody>
          @foreach ($villagewards as $villageward)
          <tr>
            @foreach ($villageward as $value)
              <td>{{ $value }}</td>  
            @endforeach
          </tr> 
          @endforeach
        </tbody>
      
    </table>
</div>
</div> 