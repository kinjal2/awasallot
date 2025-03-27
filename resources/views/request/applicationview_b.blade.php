<!-- resources/views/invoice.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: 'ind_gu_1_001';
           
        }
        .main{
            font-size: 18pt; 
        }
        .normal{
            font-size: 12pt; 
            font-weight: bold; 
        }
        table {
		border-collapse: collapse !important;
		border-style: solid;
		border: 1px solid black !important;
		background:#FFFFFF;
		font-size: 12px !important;
		margin: 8px !important;
		padding:8px !important;
		text-align:center;
		width:100% !important;
	}
	table.border_zero {
		border: 0px !important;
		font-size:13px !important;
	}
	td {
		font-family:ind_gu_1_001;
		border: 1px solid black;
		text-align:left;
		padding:8 !important;
	}
    td.border_zero {
		border: 0px;
		text-align:left !important; 
	}
	tr.border_zero {
		border: 0px;
	}	
	td.title_data {
		text-align:left !important; 
		border-style: solid;
		border: 1px solid black;		
	}
    tr {
		border-style: solid;
		border: 1px solid black;
		text-align:center;
		padding:8 !important;
	}
	.mypdf_table 
{ 
	width:100%;
} 
.gr_th
{
	border: 1px solid black;
	text-align:center;
	padding:6 !important;
}
.appr_gr
{
	border: 0.5px solid black; 
	font-size:14px; 
	text-align:center;
}
.bunchDiv_div
{ 
	text-align:left;
	font-size: 12px;
	font-weight: bold;
	width:100%;
	float:left;
}
.hundred_td
{
	width:100%; 
	text-align:left;
}
.noborder
{
	border:none !important;
}
.nopadding
{
	padding:none !important;
}
.nobottomborder
{
	border-bottom:none !important;
}
.font_gujarati_color
{
	color:blue;
	font-size: 15px;
	font-weight:bold !important;
}
.extra_padding20TD
{
	padding:20px !important;
}
.extra_padding15TD
{
	padding:15px !important;
}
.deputy_fonts_right
{
	font-weight:bold;
	font-size:14px;
	text-align:right;
}
.divisional_fonts_left
{
	font-weight:bold;
	font-size:14px;
	text-align:left;
}
.rectangle 
{
	height: 120px;
	width: 100px;
	border:1px solid black;
}
.image-cell {
            text-align: center;
            vertical-align: left;
        }
    </style>
    
</head>
<body> <meta charset="UTF-8">
    <div class="invoice-box">
    <table  >
        <colgroup>
            <col width="5%" />
            <col width="35%" />
            <col width="10%" />
            <col width="25%" />
            <col width="10%" />
            <col width="25%" />
        </colgroup>
        <tr>
        <tr>
                <th colspan="5" style="text-align: center;">પરિશિષ્‍ટ - બ</th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: center;">ગાંધીનગરમાં ઉચ્‍ચ કક્ષાની સરકારી વસવાટ મેળવવા માટે સરકારી કર્મચારી કે અધિકારીએ કરવાની અરજી </th>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;ક્વાર્ટર કેટેગરી </th>
                <td colspan="3">{{$quartertype }}</td>
            </tr>
            <tr>
                <th>1</th>
                <th>&nbsp;નામ(પુરેપુરૂ)</th>
                <td colspan="3">
                {{$name }}
                </td>
            </tr>
					<tr>
                <th></th>
                <th> જન્મ તારીખ</th>
                <td colspan="4">
                    {{ $birth_date }}
                </td>
            </tr>
            <tr>
                <th>2</th>
                <th>&nbsp;( અ ) હોદ્દો</th>
                <td colspan="3">
                    {{$designation }}
                
                </td>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?</th>
                <td colspan="3">
                    {{$is_dept_head != '' ? $is_dept_head =='Y' ? "Yes":"No":"No"; }}
                </td>
            </tr>
            <tr>
                <th>3</th>
                <th>&nbsp;કચેરી </th>
                <td>
                    {{$officename }}
                </td>
		<td>&nbsp;<strong>કચેરી નું સરનામું</strong></td>
		<td>
		    {{$officeaddress }}
		</td>
            </tr>
                
            <tr>
		<th>4</th>
                <th>&nbsp;<strong>કચેરી ફોન નંબર</strong></th>
                <td colspan="3">{{$officephone }}</td>
		
            </tr>
            <tr>
                <th>5</th>
                <th>&nbsp;( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો)  </th>
                <td colspan="3">
                    {{$salary_slab }}
                
                </td>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;( બ ) અરજીની તારીખે મળતો મૂળ પગાર  (As per 7<sup>th</sup> pay)</th>
                <td colspan="3">
                    {{$basicpay }}
                </td>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp; (ક) સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્ </th>
                <td colspan="3">
                    {{$appointment_date }}
                </td>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;( ડ ) નિવ્રૂત્તિ ની તારીખ</th>
                <td colspan="3">
                    {{$retirement_date }}
                </td>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;( ઇ ) જી.પી.એફ. ખાતા નંબર</th>
                <td colspan="3">
                    {{$gpfnumber }}
                </td>
            </tr>
            
    
            <tr>
                <Th >6</Th>
                <th colspan="4">&nbsp;ગાંધીનગરમાં અત્યારે જે કક્ષાના વસવાટમાં રહેતા હો તેની માહિતી નીચે પ્રમાણે આપવી.  </th>
	    </tr>
	    <tr>
		<th></th>
		<th></th>
                <td><strong>&nbsp;( ક ) વસવાટની કક્ષા </strong></td>
                <td colspan="2" >
                    {{$prv_quartertype }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ખ ) સેકટર નં. </strong></td>
                <td colspan="2">
                    {{ $prv_area }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ગ ) બ્લોક નં. </strong></td>
                <td colspan="2">
                    {{$prv_blockno }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ઘ ) યુનિટ  </strong></td>
                <td colspan="2">
                    {{$prv_unitno }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ચ) સકયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.  </strong></td>
                <td colspan="2">
                    {{$prv_details; }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( છ ) કઇ તારીખથી સદર વસવાટનો ઉપભોગ કરો છો ? (કબજો લીધા તારીખ)  </strong></td>
                <td colspan="2">
                   {{$prv_possession_date }}
                </td>
            </tr>
            
            <tr>
                <Th >7</Th>
                <th colspan="4">&nbsp;અગાઉ ઉચ્ચલ કક્ષાનું વસવાટ ફાળવવામાં આવેલ હતું કે કેમ ?   </th>
	    </tr>
	    <tr>
		<th></th>
		<th></th>
                <td><strong>&nbsp;( ક ) વસવાટની કક્ષા </strong></td>
                <td colspan="2">
                    {{$hc_quartertype }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ખ ) સેકટર નં. </strong></td>
                <td colspan="2">
                   {{$hc_area }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ગ ) બ્લોક નં. </strong></td>
                <td colspan="2">
                    {{$hc_blockno }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ઘ ) યુનિટ  </strong></td>
                <td colspan="2">
                    {{$hc_unitno }}
                </td>
            </tr>
            <tr>
                <Th ></Th>
                <th ></th>
                <td><strong>&nbsp;( ચ) કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.  </strong></td>
                <td colspan="2">
                    {{$hc_details }}
                </td>
            </tr>
            
            <tr>
                <th>8</th>
                <th colspan="3">&nbsp;આ સાથે સામેલ રાખેલ ઉચ્ચગ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.</th>
                <td >
			હા
                </td>
            </tr>
           
	</table>
	<table width="100%" >
	    <colgroup>
		<col width="5%" />
		<col width="15%" />
		<col width="25%" />
		<col width="55%" />
	    </colgroup>
	    <tr style="height: 60px;">
                <td colspan="4"></td>
            </tr>
	   
            <tr >
                <td colspan="4" style="text-align:right;">કર્મચારી/અધિકારી ની સહી</td>
                
            </tr>
	    <tr style="height: 60px;">
                <td colspan="4"></td>
            </tr>
	    <tr>
		<td></td>
		<td>સ્થળ</td>
		<td colspan='2'>ગાંધીનગર</td>
	    </tr>
	    <tr>
		<td></td>
		<td>તારીખ</td>
		<td colspan="2">{{  $requestdate }}</td>
	    </tr>
	    <tr style="height: 60px;">
		<td></td>
		<td colspan="2">વિભાગ/કચેરીના વડાનો અભિપ્રાય <br /> (આસન-પ માં દર્શાવેલ વિગતો ભરી છે તે અંગે અભિપ્રાય જણાવવો).  </td>
		<td></td>
	    </tr>
			<tr > <td  rowspan="4" class="image-cell">
                    @if ($imageData)
                        <img src="data:image/jpeg;base64,{{ base64_encode($imageData) }}" width="50" height="50" alt="CouchDB Image">
                    @else
                        <p>Image not found</p>
                    @endif
                </td>/tr>
	    <tr style="height: 100px;" >
		<td colspan="4" style="text-align: right;vertical-align: bottom;">(વિભાગ/કચેરીના વડાની સહી અને સિક્કો ) 	</td>
	    </tr>
	    <tr>
		<td colspan="4">
		    <hr />
		</td>
	    </tr>
	
	    <tr >
		<td colspan="4" style="text-align: center"><b>સૂચના</b></td>
	    </tr>
	    <tr>
		<td>૧.</td>
		<td colspan="3">જે કર્મચારી જેઓ કચેરીના વડા નથી, તેમણે તેમની અરજી તેમના વિભાગ/કચેરીના વડા મારફતે મોકલવી અને જો તેઓ પોતે જ વિભાગ/કચેરીના વડા હોય તો તે બાબત સ્પષ્‍ટ પણે અરજીમાં જણાવવી. </td>
	    </tr>
	    <tr>
		<td>૨.</td>
		<td colspan="3">અરજી મળ્યા પછી ફાળવણી સત્તાધિકારી તે તપાસશે અને જો તે બરાબર માલુમ પડશે તો યોગ્ય પ્રતિક્ષાયાદીમાંથી અરજી મળ્યા તારીખ પ્રમાણે કર્મચારીના નામની નોંધણી કરવામાં આવશે અને તેમને નોંધણી નંબર અને કઇ કક્ષામાં છે, તેની જાણ કરવામાં આવેશે. </td>
	    </tr>
	    <tr>
		<td>૩.</td>
		<td colspan="3">સેકટરની પસંદગી આપવામાં આવશે નહી, વસવાટની ફાળવણી ક્રમ પ્રમાણે કરવામાં આવશે. વસવાટ ફાળવણી વખતે ઉપલબ્ધ સેકટરમાં જે વસવાટ ફાળવવામાં આવે તે તેમણે સ્વીકારવાનું રહેશે અને જો તે સ્વીકારવામાં આવશે નહી તો તેમણે/તેણીનો એક વર્ષ સુધી તે હકક જતો રહેશે. એક વર્ષ પછી તે/તેણી ઉચ્‍ચ કક્ષાના વસવાટ માટે ફરી અરજી કરી શકશે. ઉચ્‍ચ કક્ષાનું વસવાટ મેળવવા માટે ફકત બે જ પ્રયત્નો આપવામાં આવશે.  </td>
	    </tr>
	</table>
	
    </div>
</body>
</html>

