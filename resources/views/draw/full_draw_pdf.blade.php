<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Quarter Draw Result</title>

<style>

@page {
   /* margin: 100px 40px 60px 40px;*/
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
}

/* HEADER */

/*.header {
    position: fixed;
    top: -100px;
    left: 0;
    right: 0;
   text-align: center;
}*/

.header {
    position: fixed;
    top: -100px;
    left: 0;
    right: 0;
    text-align: center;
    /* padding-left: 70px; */
}

.header-table,
.header-table td,
.header-table th {
    border: none !important;
}

/* FOOTER */

/* .footer {
    position: fixed;
    bottom: -40px;
    left: 0;
    right: 0;
    text-align: right;
    font-size: 10px;
} */

/* TABLE */

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

th, td {
    padding: 6px;
    text-align: center;
}

thead {
    display: table-header-group;
}


.report-date {
    text-align: right;
}

.batch-details {
    margin-top: 5px;
    text-align: left;
    margin-bottom : 5px;
}
.logo {
    position: absolute;
    left: 0;
    top: 0;
    width: 60px;
    height: auto;
}
</style>

</head>

<body>

<!-- HEADER -->


   
   
    
<div class="batch-details">
        <b>Batch Id:</b> {{ $batch_no }} ({{ $draw_date}}) <br>
        <b>Title:</b> {{ $batch_title }} <br>
        <b>Quarter Type:</b> {{ $quarter_type }}
    </div>
   


<!-- FOOTER -->
<!-- FOOTER -->
<!-- <div class="footer">
    Page <span class="pagenum"></span> / <span class="pagecount"></span>
</div> -->



<table>

<thead>
<tr>
    <th>Sr. No.</th>
    <th>Applicant Details</th>
    <th>Flat No.</th>
</tr>
</thead>

<tbody>

@foreach($results as $index => $row)

<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $row->appln_name ?? '' }}</td> 
    <td>{{ $row->premise_no }}</td>
</tr>

@endforeach

</tbody>

</table>

</body>
</html>