<!-- resources/views/invoice.blade.php -->

<!DOCTYPE html>
<html>

<head>
  <title>{{$user_id.'_'.$name}}</title>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'shruti';

    }

    .image-cell {
      text-align: center;
      vertical-align: left;
    }

    .page-break {
      page-break-before: always;
    }

    h2 {
      font-size: 14px;
      line-height: 1.5;
      margin: 0;
    }

    h3 {
      font-size: 16px;
      line-height: 1.5;
      margin: 0;
    }

    h5 {
      font-size: 12px;
      line-height: 1.5;
      margin: 0;
    }

    table,
    th,
    td {
      border: 0px;
      line-height: 1.2;
      border-collapse: collapse;
    }

    .border-tbl_bdr {
      border: 1px solid #cccccc !important;
    }

    .border-tbl_bdr_td td {
      border: 1px solid #003b64 !important;
      font-size: 12px;
      padding: 5px;
    }

    .border-tbl_bdr_td_left td {
      border: 1px solid #003b64 !important;
      font-size: 11px;
      text-align: left;
      padding: 3px;
    }

    .border-tbl_bdr_td th {
      border: 1px solid #003b64 !important;
      font-size: 12px;
      padding: 5px;
    }

    .bg-dark {
      background: #4e3f2e;
      color: #fff;
    }

    .bg-light {
      background: #00bbf0;
      color: #fff;
    }

    .bg-light1 {
      background: #dfca11;
      color: #fff;
    }

    .text-red {
      color: #b0070d;
    }

    .text-blue {
      color: #022869;
    }

    .text-center {
      text-align: center;
    }

    .text-left {
      text-align: left;
    }

    .text-right {
      text-align: right;
    }

    .top-right {
      text-align: right;
      font-weight: bold;
      font-size: 14px;
    }

    .top-right span {
      text-transform: uppercase;
    }

    .font-12 tr td {
      font-size: 10px;
      text-align: center;
    }

    .font-13 tr td {
      font-size: 13px;
      padding: 10px 5px;
    }

    .mt-5 {
      margin-top: 10px;
    }

    .mt-25 {
      margin-top: 25px;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .capitazile {
      text-transform: capitalize !important;
    }

    .padd-3 tr td {
      padding: 7px;
      vertical-align: top;
    }

    .block_head tr {
      background: #4690ff;
      color: #ffff;
    }

    .steper tr:nth-child(even) {
      background-color: rgb(226, 226, 226);
    }

    .steper_new tr:nth-child(odd) {
      background-color: rgb(226, 226, 226);
    }
  </style>

</head>

<body>
  <header>
    <table cellspacing="0" cellpadding="0" style="width:100%; border-bottom: 0px !important;" class="padd-3 font-13 text-b text-center">
      <tr>
        <td>પરિશિષ્ટ - અ</td>
      </tr>
      <tr>
        <td>{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }} માં સરકારી વસવાટ મેળવવા માટે સરકારી કર્મચારી કે અધિકારી એ કરવા ની અરજી
        </td>
      </tr>
    </table>
  </header>
  <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b text-center">

    <tr>
      <td>વિભાગ-૧</td>
    </tr>

  </table>

  <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b steper border-tbl_bdr">
    <thead class="block_head">

    </thead>
    <tbody>
      <tr>
        <td style="width:5%; ">1)</td>
        <td style="width:40%;">નામ(પુરેપુરેરૂ)</td>
        <td>:</td>
        <td>{{$name}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( અ ) હોદ્દો</td>
        <td>:</td>
        <td>{{ $designation }}</td>
      </tr>
      <tr>
        <td></td>
        <td>(બ ) પોતે કચેરી વિભાગના વડા છે કે કેમ?</td>
        <td>:</td>
        <td>{{$is_dept_head}}</td>
      </tr>
      <tr>
        <td>2)</td>
        <td>( અ ) જે વિભાગ/કચેરી માં કામ કરતા હોય તેનુ નામ</td>
        <td>:</td>
        <td>{{$officename}}<br /> {{$officeaddress}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( બ ) જ્યાંથી બદલી થઈ નેઆવ્યા હોય પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને કચેરી નું નામ હોદ્દો (બદલી/પ્રતિનિયુક્તિ ના આદેશની પ્રમાણિત નકલ બિડાણ કરવી)</td>
        <td>:</td>
        <td>{{ $old_designation }}</td>
      </tr>
      <!-- <tr>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; કચેરી નું નામ</td>
        <td>:</td>
        <td>{{$old_office}}</td>
      </tr> -->
      <tr>
        <td></td>
        <td>( ક ) {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }} ખાતે હાજર થયા તારીખ</td>
        <td>:</td>
        <td>{{$deputation_date}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( ડ ) વતન નું સરનામું</td>
        <td>:</td>
        <td>{{$address}}</td>
      </tr>
      <tr>
        <td></td>
        <td>(ઇ) જન્મ તારીખ</td>
        <td>:</td>
        <td>{{ $date_of_birth}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( ફ ) નિવ્રૂત્તિ ની તારીખ</td>
        <td>:</td>
        <td>{{ $date_of_retirement}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( જી ) જી.પી.એફ./સી.પી.એફ ખાતા નંબ</td>
        <td></td>
        <td>{{$gpfnumber}}</td>
      </tr>
      <tr>
        <td>3)</td>
        <td>સરકારી નોકરી માં મૂળ નિમણુંકની તારીખ</td>
        <td>:</td>
        <td>{{$appointment_date}}</td>
      </tr>
      <tr>
        <td>4)</td>
        <td>( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો)</td>
        <td>:</td>
        <td>{{ $salary_slab }}</td>
      </tr>
      <tr>
        <td></td>
        <td>( બ ) ખરેખર રે મળતો પગાર (છેલ્લા માસના પગારની સ્લીપ બિડવી.)</td>
        <td>:</td>
        <td>{{$actual_salary}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( ૧ ) મૂળ પગાર</td>
        <td>:</td>
        <td>{{$basic_pay }}</td>
      </tr>
      <tr>
        <td></td>
        <td>( ૨ ) પર્સનલ પગાર</td>
        <td>:</td>
        <td>{{ $personal_salary}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( ૩ ) સ્પેશ્યલ પગાર</td>
        <td>:</td>
        <td>{{$special_salary}}</td>
      </tr>
      <tr>
        <td></td>
        <td>( ૪ ) પ્રતિનિયુક્તિ ભથ્થું</td>
        <td>:</td>
        <td>{{$deputation_allowance}}</td>
      </tr>
      <tr>
        <td></td>
        <td>કુલ રૂ</td>
        <td>:</td>
        <td>{{$totalpay}}</td>
      </tr>
      <tr>
        <td>5)</td>
        <td>( અ ) પરણિત / અપરણિત</td>
        <td>:</td>
        <td>{{$maratial_status}}</td>
      </tr>
      <tr>
        <td>6)</td>
        <td colspan="3">આ પહેલા ના સ્થ્ળે સરકારશ્રી એ વસવાટ ની સવલત આપી હોય તો</td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;( અ ) કોલોની નું નામ/ રીક્વીઝીશન કરેલ મકાન ની વિગત</td>
        <td>:</td>
        <td>{{$prv_area_name}}</td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;( બ ) વસવાટ ના ક્વાર્ટરનો નંબર તથા કેટેગરી</td>
        <td>:</td>
        <td>{{$prv_building_no}} - {{$prv_quarter_type}}</td>
      </tr>
      <!-- <tr>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;( ક-૧ )વસવાટ ની કેટેગરી</td>
        <td>:</td>
        <td>{{$prv_quarter_type}}</td>
      </tr> -->
      <tr>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;(ક-૨) માસિક ભાડું</td>
        <td>:</td>
        <td>{{$prv_rent}}</td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;( ડ ) {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }}નું મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે કેમ?</td>
        <td>:</td>
        <td>{{$prv_handover}}</td>
      </tr>
    </tbody>
  </table>

  <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 border-tbl_bdr font-13 text-b steper_new">
    <tr>
      <td>7)</td>
      <td>અગાઉ {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }} માં મકાન મેળવવા, અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ હોય તો તારીખ, નંબર, બ્લોક વિગેરેની સંદર્ભ માહિતી આપવી.(લાગુ ન પડતુ હોય ત્યાં “ના” લખવુ)</td>
      <td>:</td>
      <td>{{ $have_old_quarter == 'Y' ? $old_quarter_details : 'N' }}</td>
    </tr>
    <!-- <tr>
      <td></td>
      <td>તારીખ, નંબર, બ્લોક વિગેરે વિગત</td>
      <td>:</td>
      <td>{{$old_quarter_details}}</td>
    </tr> -->
    <tr>
      <td>8)</td>
      <td> શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબલના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરી નાં વડાનું પ્રમાણપત્ર આ સાથે સામેલ કરવું</td>
      <td>:</td>
      <td>{{ $is_scst == 'Y' ? $scst_info : 'N'}}</td>
    </tr>
    <!-- <tr>
      <td></td>
      <td colspan="3">વિગત : N/A</td>
    </tr> -->
    <tr>
      <td>9)</td>
      <td>{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }} ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથેનો સંબંધ(સગાઈ) અને મકાન ની વિગત</td>
      <td>:</td>
      <td>{{ $relative_details }}</td>
    </tr>
    <!-- <tr>
      <td></td>
      <td colspan="3">વિગત : {{$relative_details}}</td>
    </tr> -->
    <tr>
      <td>10)</td>
      <td>{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn'))) }} ખાતે માતા/પિતા. પતિ/પત્ની વિગેરે લોહી ની સગાઈ જેવા જે સંબંધીને મકાન ફાળવેલ છે કે કેમ? જો હા, તો તેની વિગત જેવી કે નામ, સેકટર, બ્લોક નાંબર વિગેરે</td>
      <td>:</td>
      <td>{{$is_relative_householder == 'Y' ? $relative_house_details : 'N'}}</td>
    </tr>
    <!-- <tr>
      <td></td>
      <td colspan="3">વિગત :{{$relative_house_details}}</td>
    </tr> -->
    <tr>
      <td>11)</td>
      <td>{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn'))) }} શહેર ની હદમાં અથવા સચિવાલયથી ૧૦ કિલોમીટરની હદ માં અથવા {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn'))) }} શહેરની હદમાં જુના ગામડાઓમાં
        રહેઠાણ તેમની અથવા તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંક નું મકાન છે? જો હા, તો તેમનો સાથેનો સંબંધ(સગાઈ) અને મકાન ક્યાં છે તે જણાવવુ.</td>
      <td>:</td>
      <td>{{$have_house_nearby == 'Y' ? $nearby_house_details : 'N'}}</td>
    </tr>
    <tr>
      <td>12)</td>
      <td colspan="3">આપ કયા વિસ્તારમાં સરકારી આવાસ મેળવવા ઇચ્છો છો ? (શક્ય હોય તો ફાળવવામાં આવશે.) <br>
      Choice 1 : {{ getAreaDetailsByCode($choice1) }} <br> Choice 2 : {{ getAreaDetailsByCode($choice2) }} <br> Choice 3 : {{ getAreaDetailsByCode($choice3) }}
    </td>
    </tr>
    <tr>
      <td>13)</td>
      <td>જો જાહેરહિતાર્થે બદલી થઈ ને {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn'))) }} આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને પાત્ર હોય તેમળે ત્યાં સુધી તરત નીચેની કક્ષાનું વસવાટ ફાળવી આપવા વિનંતી છે? </td>
      <td>:</td>
      <td>{{$downgrade_allotment}}</td>
    </tr>
    <tr>
      <td>14)</td>
      <td>સરકારશ્રી વખતોવખત મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા હું સંમત છું.</td>
      <td>:</td>
      <td>હા</td>
    </tr>
    <tr>
      <td>15)</td>
      <td>મારી બદલી એક વિભાગ માાંથી બીજા વિભાગમાં થાય અથવા {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn'))) }}થી અન્ય સ્થળે થાય તો તે અંગેની જાણ તુરત કરીશ</td>
      <td>:</td>
      <td>હા</td>
    </tr>
    <tr>
      <td>16)</td>
      <td colspan="3"> હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;">{{ $name }}</span> &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label></td>

    </tr>
  </table>
  <!-- <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b mt-25">
    <tr>
      <td>તા. {{-- $requestdate --}}</td>
      <td class="text-right"><b>કર્મચારી/અધિકારી ની સહી</b></td>
    </tr>
    <tr>
      <td colspan="2">બિડાણની વિગતો</td>
    </tr>
  </table>

  <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b mt-25">
    </table> -->



  <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b text-center">
    <tr>
      <td><b>વિભાગ-૨</b></td>
    </tr>
    <tr>
      <td><b>વિભાગ/કચેરીના વડાનો અભિપ્રાય</b></td>
    </tr>
  </table>

  <table cellspacing="0" cellpadding="0" style="width:70%;" class="padd-3 font-13 ">
    <tr>
      <td style="width: 70%;">
        <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b steper_new ">
          <tr>
            <td style="width: 3%;">1)</td>
            <td style="width: 70%;">આસન ૪ માં દર્શાવેલ પગાર બરાબર છે?</td>
            <td>:</td>
            <td>No</td>
          </tr>
          <tr>
            <td>2)</td>
            <td>કર્મચારી કાયમી/ હંગામી / વર્કચાર્જ છે ?</td>
            <td>:</td>
            <td>No Data</td>
          </tr>
          <tr>
            <td>3)</td>
            <td>કર્મચારી પ્રતિનિયુકત પર આવેલ છે ? જો હા, તો કેટલા સમય માટે ?</td>
            <td>:</td>
            <td>No Data</td>
          </tr>
          <tr>
            <td>4)</td>
            <td>કર્મચારી નોકરી એક વર્ષથી વધુ છે ?</td>
            <td>:</td>
            <td>No Data</td>
          </tr>
          <tr>
            <td>5)</td>
            <td>(અ) નવી નિમણુંક અંગે અરજી મોકલ્યાની તારીખથી એક વર્ષથી વધુ નોકરીમાં ચાલુ રહેશે ?</td>
            <td>:</td>
            <td>No Data</td>
          </tr>
          <tr>
            <td></td>
            <td>(બ) કર્મચારી સિલેક્શન કમિટી મારફત આવેલ છે? જો હા તો તેનુ નામ દર્શાવવું (ઓર્ડરની નકલ બિડાણ કરવી.)</td>
            <td>:</td>
            <td>No Data</td>
          </tr>
          <tr>
            <td></td>
            <td>(ક) નિમણુંક આદેશ નિયમિત છે ?</td>
            <td>:</td>
            <td>No Data</td>
          </tr>

        </table>
      </td>
      <td style="width: 30%;">
        <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b">
          <tr>
            <td class="" style="vertical-align: top;">
              @if ($imageData)
              <?php
              // Optionally, determine the file type based on the image data or extension
              $imageType = (strpos($imageData, 'PNG') !== false) ? 'image/png' : 'image/jpeg';
              ?>
              <img style="width: 150px;" src="data:{{$imageType}};base64,{{ base64_encode($imageData) }}" alt="CouchDB Image">
              <!-- <img style="width: 150px;" src="data:image/jpeg;base64,{{ base64_encode($imageData) }}"  alt="CouchDB Image"> -->
              @else
              <p>Image not found</p>
              @endif
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table cellspacing="0" cellpadding="0" style="width:100%; margin-top: -3px;" class="padd-3 font-13  text-b steper">
    <tr class="font-11">
      <td style="width: 10%;">6)</td>
      <td style="width:30%;"> નામ:</td>
      <td style="width:57%;">{{$name}}<br> તા.{{ $deputation_date}} ના રોજ {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }} હાજર થયેલ છે.</td>
    </tr>
    <tr>
      <td style="width: 3%;">7)</td>
      <td>કચેરીનો ફોન નંબર</td>
      <td>{{$office_phone}}</td>
    </tr>
    <tr>
      <td colspan="3" style="font-size: 13px; line-height:2;"><br><br>નોંધ:- મકાન મેળવવા માટેની અરજી મોકલતા પહેલા જો કર્મચારીને વગર નોટીસે છુટા કરી શકાય તેમ હોય અરજી તેમની કચેરીમાં જ દફતરે કરવી. અરજી મોકલતી વખતે મળતા પગારની વિગતો જે કર્મચારીએ આસન ૪ માં જણાવેલ છે. તેની ચકાસણી કરીને મોકલવી. (૨) સાતમા પગારપચ મુજબની તાજેતરની પગાર સ્લિપની નકલ સામેલ રાખવી. (૩) <b><u>સરકારી આવાસ ફાળવણીના પ્રવર્તમાન નિયમોનુસાર સરકારી આવાસ ધરાવતા તેમજ ઓનલાઇન અરજી કરેલ હોય તેવા કર્મચારીની બદલી/અવસાન/રાજીનામું વગેરે પ્રસંગોએ અધિક્ષક ઇજનેરશ્રીની કચેરી, પાટનગર યોજના વર્તુળ, બ્લોક નં.૧૧/૨, ડૉ.જીવરાજ મહેતા ભવન, ગાંધીનગરને એલ.પી.સી.ની નકલ સહિત તેની જાણ ફરજીયાત કરવાની રહેશે.</u></b></td>
    </tr>
  </table>

  <!-- <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b mt-25">
      <tr>
        <td>તારીખ : 01/11/2022 <br> કચેરીનો ગોળ સિક્કો</td>
        <td class="text-right">વિભાગ/કચેરીના વડાની સહી અનેસિકકો</td>
      </tr>
    </table> -->

</body>

</html>