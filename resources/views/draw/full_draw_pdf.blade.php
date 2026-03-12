<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Quarter Draw Result</title>

<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    margin-top: 140px;
    margin-bottom: 60px;
}

/* TABLE STYLE */

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

/* HEADER */

.header {
    position: fixed;
    top: -120px;
    left: 0;
    right: 0;
    text-align: center;
}

/* FOOTER */

.footer {
    position: fixed;
    bottom: -40px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 10px;
}

/* PAGE NUMBER */

.pagenum:before {
    content: counter(page);
}

.pagecount:before {
    content: counter(pages);
}

.report-date {
    text-align: right;
    margin-top: 5px;
}

.batch-details {
    margin-top: 5px;
}

</style>

</head>

<body>

<!-- HEADER (Appears on every page) -->
<div class="header">

    <h4>Roads & Buildings Department</h4>

    <h5>
        Quarter Allotment Draw Result<br>

        @if($draw_status=='final')
            Final Draw
        @elseif($draw_status=='verified')
            Demo Draw {{ $demo_run_count }} / 3
        @endif
    </h5>

    <div class="report-date">
        Report Generated On: <b>{{ $generated_at }}</b>
    </div>

    <div class="batch-details">
        <b>Batch Id:</b> {{ $batch_no }} <br>
        <b>Title:</b> {{ $batch_title }} <br>
        <b>Quarter Type:</b> {{ $quarter_type }}
    </div>

</div>


<!-- FOOTER (Appears on every page) -->
<div class="footer">
    Page <span class="pagenum"></span> / <span class="pagecount"></span>
</div>


<table>

<thead>
<tr>
    <th>Sr. No.</th>
    <th>Appl. No.</th>
    <th>Name & Address</th>
    <th>Category</th>
    <th>Flat No.</th>
</tr>
</thead>

<tbody>

@foreach($results as $index => $row)

<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $row->appln_name }}</td>
    <td>{{ $row->appln_name }}</td>
    <td>General</td>
    <td>{{ $row->premise_no }}</td>
</tr>

@endforeach

</tbody>

</table>

</body>
</html>