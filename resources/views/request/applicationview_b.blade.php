<!-- resources/views/invoice.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>{{$user_id.'_'.$name}}</title>
    <style>
        body {
            font-family: 'ind_gu_1_001';
        }

.image-cell {
            text-align: center;
            vertical-align: left;
        }
      .page-break {page-break-before: always;}
      h2 {font-size : 14px; line-height: 1.5; margin: 0;}
      h3 {font-size : 16px; line-height: 1.5; margin: 0;}
      h5 {font-size : 13px; line-height: 1.5; margin: 0;}
      table, th, td {border: 0px;line-height:1.2;border-collapse: collapse;}
      .border-tbl_bdr{border: 1px solid #cccccc !important;}
      .border-tbl_bdr_td td{border: 1px solid #003b64 !important; font-size: 12px; padding: 5px;}
      .border-tbl_bdr_td_left td{border: 1px solid #003b64 !important; font-size: 11px; text-align:left; padding: 3px;}
      .border-tbl_bdr_td th{border: 1px solid #003b64 !important; font-size: 12px; padding: 5px;}
      .bg-dark{background:#4e3f2e; color:#fff;}
      .bg-light{background:#00bbf0; color:#fff;}
      .bg-light1{background:#dfca11; color:#fff;}
      .text-red{color:#b0070d;}
      .text-blue{color:#022869;}
      .text-center{text-align:center;}
      .text-left{text-align:left;}
      .text-right {text-align:right;}
      .top-right{text-align: right; font-weight: bold;font-size: 14px;}
      .top-right span{text-transform: uppercase;}
      .font-12 tr td{font-size: 10px; text-align: center;}
      .font-13 tr td{font-size: 13px;padding: 10px 5px;}
      .mt-5{margin-top:10px;}
      .mt-25{margin-top:25px;}
      .uppercase{text-transform: uppercase;}
      .capitazile{text-transform: capitalize !important;}
      .padd-3 tr td { padding: 7px; vertical-align: top;}
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
<body> <meta charset="UTF-8">
    <div class="invoice-box">
    <header>
        <table cellspacing="0" cellpadding="0" style="width:100%; border-bottom: 0px !important;" class="padd-3 font-13 text-b text-center">
        <tr><td>પરિશિષ્ટ - બ</td></tr>
        <tr><td>{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }}માં ઉચ્‍ચ કક્ષાની સરકારી વસવાટ મેળવવા માટે સરકારી કર્મચારી કે અધિકારીએ કરવાની અરજી </td></tr>
        </table>
    </header>
    <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b steper border-tbl_bdr">
        <tr>
            <td style="width:5%; " >1)</td>
            <td style="width:70%;">નામ(પુરેપુરૂ)</td>
            <td>:</td>
            <td>{{$name}}</td>
        </tr>
        <tr>
            <td></td>
            <td>ક્વાર્ટર કેટેગરી</td>
            <td>:</td>
            <td>{{$quartertype }}</td>
        </tr>
        <tr>
            <td></td>
            <td> જન્મ તારીખ</td>
            <td>:</td>
            <td>{{ $date_of_birth }}</td>
        </tr>
         <tr>
            <td>2</td>
            <td>( અ ) હોદ્દો</td>
            <td>:</td>
            <td>{{ $designation }}</td>
        </tr>
        <tr>
            <td></td>
            <td>(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?</td>
            <td>:</td>
            <td>{{$is_dept_head != '' ? $is_dept_head =='Y' ? "Yes":"No":"No"; }}</td>
        </tr>
        <tr>
            <td></td>
            <td>(ક) કચેરી</td>
            <td>:</td>
            <td>{{$officename }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ડ )કચેરી નું સરનામું</td>
            <td>:</td>
            <td>{{$officeaddress }}</td>
        </tr>
        <tr>
            <td>3</td>
            <td>કચેરી ફોન નંબર</td>
            <td>:</td>
            <td>{{ $officephone }}</td>
        </tr>
        <tr>
            <td>4</td>
            <td>( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો)</td>
            <td>:</td>
            <td>{{$salary_slab }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( બ ) અરજીની તારીખે મળતો મૂળ પગાર  (As per 7<sup>th</sup> pay)</td>
            <td>:</td>
            <td> {{$basic_pay }}</td>
        </tr>
        <tr>
            <td></td>
            <td>(ક) સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્</td>
            <td>:</td>
            <td>{{$appointment_date }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ડ ) નિવ્રૂત્તિ ની તારીખ</td>
            <td>:</td>
            <td> {{$date_of_retirement }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ઇ ) જી.પી.એફ. ખાતા નંબર</td>
            <td>:</td>
            <td> {{$gpfnumber }}</td>
        </tr>
        <tr>
            <td>5</td>
            <td colspan="3">{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }}માં અત્યારે જે કક્ષાના વસવાટમાં રહેતા હો તેની માહિતી નીચે પ્રમાણે આપવી.</td>
        </tr>
        <tr>
            <td></td>
            <td>( ક ) વસવાટની કક્ષા </td>
            <td>:</td>
            <td>{{$prv_quarter_type }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ખ ) સેકટર નં.</td>
            <td>:</td>
            <td>{{ $prv_area_name }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ગ ) બ્લોક નં.</td>
            <td>:</td>
            <td> {{$prv_blockno }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ઘ ) યુનિટ</td>
            <td>:</td>
            <td>{{$prv_unitno }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ચ) કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.</td>
            <td>:</td>
            <td> {{$prv_details; }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( છ ) કઇ તારીખથી સદર વસવાટનો ઉપભોગ કરો છો ? (કબજો લીધા તારીખ)</td>
            <td>:</td>
            <td>{{$prv_possession_date }}</td>
        </tr>
        <tr>
            <td>6</td>
            <td colspan="3">અગાઉ ઉચ્ચલ કક્ષાનું વસવાટ ફાળવવામાં આવેલ હતું કે કેમ ?</td>
        </tr>
        <tr>
            <td></td>
            <td>( ક ) વસવાટની કક્ષા</td>
            <td>:</td>
            <td>{{$hc_quarter_type }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ખ ) સેકટર નં.</td>
            <td>:</td>
            <td>{{$hc_area }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ગ ) બ્લોક નં.</td>
            <td>:</td>
            <td>{{$hc_blockno }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ઘ ) યુનિટ </td>
            <td>:</td>
            <td> {{$hc_unitno }}</td>
        </tr>
        <tr>
            <td></td>
            <td>( ચ) કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.</td>
            <td>:</td>
            <td>{{$hc_details }}</td>
        </tr>
        <tr>
            <td>7</td>
            <td>આપ કયા વિસ્તારમાં સરકારી આવાસ મેળવવા ઇચ્છો છો ? (શક્ય હોય તો ફાળવવામાં આવશે.)</td>
            <td>:</td>
            <td>
			Choice 1 : {{ isset($choice1) ? getAreaDetailsByCode($choice1) : 'N/A' }} <br> Choice 2 : {{ isset($choice2) ? getAreaDetailsByCode($choice2) : 'N/A' }} <br> Choice 3 : {{ isset($choice3) ? getAreaDetailsByCode($choice3) : 'N/A' }} 
			</td>
        </tr>
        <tr>
            <td>8</td>
            <td>આ સાથે સામેલ રાખેલ ઉચ્ચ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.</td>
            <td>:</td>
            <td>હા</td>
        </tr>
        <tr>
            <td>9</td>
            <td>હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;">{{ $name }}</span>  &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label></td>
            <td>:</td>
            <td>હા</td>
        </tr>
    </table>

     <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b">
        <tr><td colspan="3" class="text-right">કર્મચારી/અધિકારી ની સહી</td></tr>
        <tr><td style="width: 10%;">સ્થળ</td><td style="width: 2%;">:<td>{{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }}</td></tr>
        <tr><td>તારીખ</td><td>:</td><td>{{  $request_date }}</td></tr>
        <tr><td colspan="3" style="padding-top: 30px;">વિભાગ/કચેરીના વડાનો અભિપ્રાય</td></tr>
        <tr><td colspan="3"></td></tr>
        <tr><td colspan="3">(આસન-પ માં દર્શાવેલ વિગતો ભરી છે તે અંગે અભિપ્રાય જણાવવો).</td></tr>
        <tr><td colspan="3">
            @if ($imageData)
                        <img src="data:image/jpeg;base64,{{ base64_encode($imageData) }}" width="50" height="50" alt="CouchDB Image">
                    @else
                        <p>Image not found</p>
                    @endif
        </td></tr>
       <tr><td colspan="3" class="text-right"  style="padding-top: 30px;">(વિભાગ/કચેરીના વડાની સહી અને સિક્કો )</td></tr>
    </table>

    <table cellspacing="0" cellpadding="0" style="width:100%;" class="padd-3 font-13 text-b">
         <tr><td class="text-center" style="padding-top: 30px;" colspan="3"><h5>સૂચના</h5></td></tr>
        <tr>
		<td style="width: 5%;">૧.</td>
		<td colspan="2">જે કર્મચારી જેઓ કચેરીના વડા નથી, તેમણે તેમની અરજી તેમના વિભાગ/કચેરીના વડા મારફતે મોકલવી અને જો તેઓ પોતે જ વિભાગ/કચેરીના વડા હોય તો તે બાબત સ્પષ્‍ટ પણે અરજીમાં જણાવવી. </td>
	    </tr>
	    <tr>
		<td>૨.</td>
		<td colspan="2">અરજી મળ્યા પછી ફાળવણી સત્તાધિકારી તે તપાસશે અને જો તે બરાબર માલુમ પડશે તો યોગ્ય પ્રતિક્ષાયાદીમાંથી અરજી મળ્યા તારીખ પ્રમાણે કર્મચારીના નામની નોંધણી કરવામાં આવશે અને તેમને નોંધણી નંબર અને કઇ કક્ષામાં છે, તેની જાણ કરવામાં આવેશે. </td>
	    </tr>
	    <tr>
		<td>૩.</td>
		<td colspan="2">સેકટરની પસંદગી આપવામાં આવશે નહી, વસવાટની ફાળવણી ક્રમ પ્રમાણે કરવામાં આવશે. વસવાટ ફાળવણી વખતે ઉપલબ્ધ સેકટરમાં જે વસવાટ ફાળવવામાં આવે તે તેમણે સ્વીકારવાનું રહેશે અને જો તે સ્વીકારવામાં આવશે નહી તો તેમણે/તેણીનો એક વર્ષ સુધી તે હકક જતો રહેશે. એક વર્ષ પછી તે/તેણી ઉચ્‍ચ કક્ષાના વસવાટ માટે ફરી અરજી કરી શકશે. ઉચ્‍ચ કક્ષાનું વસવાટ મેળવવા માટે ફકત બે જ પ્રયત્નો આપવામાં આવશે.  </td>
	    </tr>

    </table>


    </div>
</body>
</html>

