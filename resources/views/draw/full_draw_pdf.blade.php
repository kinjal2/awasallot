<!DOCTYPE html>
<html>
<head>
    <title>Quarter Draw Result</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        .header { text-align: center; margin-bottom: 10px; }
        .date { text-align: right; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h3>Quarter Allotment Draw Result</h3>
</div>

<div class="date">
    {{ $generated_at }}
</div>
<div >
    Title : {{ $batch_title }} <br/> Quater Type: {{$quarter_type}}
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
            <td>general</td>
            <td>{{ $row->premise_no }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>