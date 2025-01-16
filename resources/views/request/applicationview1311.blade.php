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
        
   <td colspan="6" style="text-align: center;" class='main'>પરિશિષ્ટ - અ</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;" class='normal'>ગાંધીનગર માં સરકારી વસવાટ મેળવવા માટે સરકારી કર્મચારી કે અધિકારી એ કરવા ની અરજી</td>
        </tr>
        <tr>
            <td></td>
            <td class='normal'>ક્વાર્ટર કેટેગરી </td>
            <td colspan="4">{{ $quartertype}}
            </td>
        </tr>
        <tr>
                <th>1</th>
                <th class='normal'>નામ(પુરેપુરૂ)</th>
                <td colspan="4">{{$name}}</td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( અ ) હોદ્દો</th>
                <td colspan="4">{{ $designation }}</td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?</th>
               
                <td colspan="4">{{$is_dept_head}}
                </td>
            </tr>
            <tr>
                <th>2</th>
                <th class='normal'>( અ ) જે વિભાગ/કચેરીમાં કામ કરતા હોય તેનુ નામ</th>
                <td colspan="4">{{$officename}}<br/> {{$officeaddress}}</td>
            </tr>   
            <tr>
                <th></th>
                <th class='normal'>( બ ) જ્યાંથી બદલી થઈ ને આવ્યા હોય /પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને કચેરી નું નામ</th>
                <td><strong>હોદ્દો</strong></td>
                <td>{{ $old_desg }}</td>
                <td class='normal'><strong>કચેરી નું નામ</strong></td>
                <td>{{$old_office}}</td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ક ) જો નવી નિમણૂંક હોય તો કઇ તારીખ થી</th>
                <td colspan="4">{{$deputation_date}}</td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ડ ) વતન નું સરનામું</th>
                <td colspan="4">
                    {{$address}}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ઈ ) નિવ્રૂત્તિ ની તારીખ</th>
                <td colspan="4">
                    {{ $date_of_retirement}}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ફ ) જી.પી.એફ. ખાતા નંબર</th>
                <td colspan="4">
                   {{$gpfnumber}}
                </td>
            </tr>
            <tr>
                <th>3</th>
                <th class='normal'>સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્ </th>
                <td colspan="4">
                  {{$appointment_date}}
                </td>
            </tr>
    
            <tr>
                <th>4</th>
                <th class='normal'>( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો)  </th>
                <td colspan="4">{{ $salary_slab }}</td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( બ ) ખરેખર મળતો પગાર</th>
                <td colspan="4">
                  {{$actual_salary}}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ૧ ) મૂળ પગાર</th>
                <td colspan="4">
                    {{$basic_pay }}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ૨ ) પર્સનલ પગાર</th>
                <td colspan="4">
                    {{ $personal_salary}}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ૩ ) સ્પેશ્યલ પગાર</th>
                <td colspan="4">
                    {{$special_salary}}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>( ૪ ) પ્રતિનિયુક્તિ ભથ્થું</th>
                <td colspan="4">
                    {{$deputation_allowance}}
                </td>
            </tr>
            <tr>
                <th></th>
                <th class='normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; કુલ પગાર રૂ.</th>
                <td colspan="4">
                    {{$totalpay}}
                </td>
            </tr>
           <tr>
                <th>5</th>
                <th class='normal'>( અ ) પરણિત/અપરણિત  </th>
                <td colspan="4">{{$maratial_status}}</td>
            </tr>
            
            <tr>
                <Th >6</Th>
                <th class='normal'>આ પહેલા ના સ્થ્ળે સરકારશ્રીએ વસવાટ ની સવલત આપી હોય તો </th>
                <Td colspan="4" ></Td>
            </tr>
            <tr>
            <th></th>
            <th></th>
            <td class='normal'><strong>( અ ) કોલોની નું નામ/રીક્વીઝીશન કરેલ મકાન ની વિગત</strong></td>
            <td>{{$prv_area_name}}</td>
            <td class='normal'><strong>( બ ) વસવાટ નો ક્વાર્ટર નંબર</strong></td>
            <td>{{$prv_building_no}}</td>
        </tr>
        <tr>
        <th></th>
        <th></th>
        <td class='normal'><strong>( ક-૧ )વસવાટ ની કેટેગરી</strong></td>
        <td>{{$prv_quarter_type}}</td>
        
        <td class='normal'><strong>(ક-૨) માસીક ભાડું</strong></td>
        <td>{{$prv_rent}}</td>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <td class='normal'><strong>( ડ ) મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે કેમ્?</strong></td>
        <td colspan="3">{{$prv_handover}} </td>
    </tr>
    <tr>
    <th>7</th>
    <th class='normal'>અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે?</th>
    <td>{{$have_old_quarter}}</td>
    <td class='normal'><strong>તારીખ, નંબર, બ્લોક વિગેરે વિગત </strong></td>
    <td colspan="2">{{$old_quarter_details}}</td>
</tr>
<tr>
<th>8</th>
<th class='normal'>શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરીનાં વડાનું પ્રમાણપત્ર સામેલ કરવું</th>
<td>{{-- $is_stsc --}}</td>
<td class='normal'><strong>વિગત </strong></td>
<td colspan="2">{{-- $stsc_details --}}</td>
</tr>
<tr>
<th>9</th>
<th class='normal'>ગાંધીનગર ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથે નો સંબંધ અને મકાન ની વિગત</th>
<td>{{$is_relative}}</td>
<td class='normal' ><strong>વિગત </strong></td>
<td colspan="2"> {{$relative_details}}</td>
</tr>
<tr>
                <th>10</th>
                <th class='normal'>ગાંધીનગર ખાતે માતા/પિતા. પતિ/પત્ની વિગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે?</th>
                <td>{{$is_relative_householder}}</td>
                <td class='normal'><strong>વિગત </strong></td>
                <td colspan="2">{{$relative_house_details}}</td>
            </tr>
            <tr >
            <th>11</th>
            <th class='normal'>ગાંધીનગર શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા ગાંધીનગર ની હદ માં આવતા ગમડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું મકાન છે?</th>
            <td>{{$have_house_nearby}}</td>
            <td class='normal'><strong>વિગત </strong></td>
            <td colspan="2">{{$nearby_house_details}}</td>
        </tr>
        
        <tr>
            <th>12</th>
            <th colspan="3" class='normal'>જો બદલી થઈ ને ગાંધીનગર આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચી કક્ષાનું વસવાટ ફાળવી આપવા વિનંતી છે?</th>
            <td colspan="2">{{$downgrade_allotment}}</td>
        <tr>
        <th>13</th>
        <th colspan="3" class='normal'>સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા હું સંમત છુ?</th>
        <td colspan="2">હા</td>
    </tr>
    <tr>
        <th>14</th>
        <th colspan= "3" class='normal'>મારી બદલી થાય તો તે અંગે ની જાણ તુરત કરીશ</th>
        <td colspan="2">હા</td>
    </tr>
    <tr>
    <td colspan="6"></td>
</tr>
<tr >
    <td colspan="4" style="text-align:right;" class='normal'><strong>કર્મચારી/અધિકારી ની સહી</strong></td>
    <td colspan="2"></td>
    
</tr>
<tr >
<td colspan="6">&nbsp;&nbsp;</td>

</tr>
<tr>
<td></td>
<td colspan="5" style="text-align: left">તા.&nbsp;{{-- $requestdate --}}</td>
</tr>
<tr>
<thcolspan="6"  class='normal'>બિડાણની વિગતો -</th>
</tr>
<tr>
<tr>
                <td colspan="6" class="normal">વિભાગ-૨</td>
            </tr>
            <tr>
                <td colspan="6" class="normal">વિભાગ/કચેરીના વડાનો અભિપ્રાય</td>
            </tr>
            <tr>
                <td>1</td>
                <td class="normal">આસન ૪ માં દર્શાવેલ પગાર બરાબર છે?</td>
			 <td colspan="9" rowspan="6" class="image-cell">
                    @if ($imageData)
                        <img src="data:image/jpeg;base64,{{ base64_encode($imageData) }}" width="50" height="50" alt="CouchDB Image">
                    @else
                        <p>Image not found</p>
                    @endif
                </td>
				</tr> 
            <tr>
                <td>2</td>
                <td class="normal">કર્મચારી કાયમી/ હંગામી / વર્કચાર્જ છે ?</td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td class="normal">કર્મચારી પ્રતિનિયુકત પર આવેલ છે ? જો હા, તો કેટલા સમય માટે ?</td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td class="normal">કર્મચારી નોકરી એક વર્ષથી વધુ છે ?</td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td class="normal">(અ) નવી નિમણુંક અંગે અરજી મોકલ્યાની તારીખથી એક વર્ષથી વધુ નોકરીમાં ચાલુ રહેશે ?</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="normal">(બ) કર્મચારી પી.એસ.સી. મારફત /સીલેકશન કમીટી મારફત આવેલ છે ? (ઓર્ડરની નકલ બિડાણ કરવી.)</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="normal">(ક) નિમણુંક આદેશ નિયમિત છે ?</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <th>6</th>
                <th colspan="5" style="text-align:left;" class='normal'>નામ:{{ $name; }} તા. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ના રોજ ગાંધીનગર હાજર થયેલ છે. </th>
            </tr>
            <tr>
                <th>7</th>
                <th class='normal'>કચેરીનો ફોન નંબર </th>
                <td colspan="4"></td>
            </tr>
            <tr>
                <th class='normal'>નોધં.</th>
                <td colspan="5" class='normal'>મકાન મેળવવા માટેની અરજી મોકલતા પહેલા જો કર્મચારીને વગર નોટીસે છુટા કરી શકાય તેમ હોય તો અરજી તેમની કચેરીમાં જ દફતરે કરવી. અરજી મોકલતી વખતે કર્મચારીને ખરેખર મળતા પગારની વિગતો જે કર્મચારીએ આસન ૪ માં જણાવેલ છે. તેની ચકાસણી કરીને મોકલવી. (ર) પાંચમાં પગારપંચ મુજબની માહે માર્ચ-ર૦૦૯ ની પ્રમાણિત પગાર સ્લીપની નકલ સામેલ રાખવી. </td>
            </tr>
            <tr>
                <th colspan="4" style="text-align:right" class='normal'>વિભાગ/કચેરીના વડાની સહી</th>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th colspan="6" style="text-align:right">&nbsp;</th>
            </tr>
            <tr>
                
             
            </tr>
                               
    </table>
    </div>
</body>
</html>

