<!-- Staus 1 : 'Pending-Downward' -->
<!-- Staus 2 : 'Sent to Next Level' -->
<!-- Staus 2 : 'Pending to Upward' -->
<table class="table table-bordered" id="align">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>Task Name</th>
            <th>Assigened by</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows['tableData'] as $row)
    <tr>
        @php
        $stakeholder_Name = App\Http\Controllers\BaseController::getusername($row['stakeholder_id']);
        $id = Crypt::encrypt($row['government_task_id']);
        @endphp
        <td>{{$loop->iteration}}</td>
        <td>{{ $row['task_name']}}</td>
        <td>{{$stakeholder_Name}}</td>
        @if($row['Status']=="1")
        <td class="text-white"><span class="badge2 success rounded-pill text-bg-warning downward">Pending<i class="fa fa-level-down" aria-hidden="true"></i></span></td>
        @elseif($row['Status']=="2")
        <td sclass="text-white"><span class="badge2 warning rounded-pill text-bg-success">Sent</span></td>
        @elseif($row['Status']=="3")
        <td class="text-white"><span class="badge2 danger rounded-pill text-bg-warning downward">Pending<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
        @elseif($row['task_status']=="4")
        <td class="text-white"><span class="badge2 success rounded-pill text-bg-success downward">Approved<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
        @endif
        <td>
            @if($row['Status']=="1" || $row['task_status'] == "3")
            <div class="d-flex align-items-center justify-content-center"><a type="button" href="{{route('instruction.appointment',[$id,'edit'])}}" title="Edit" class="btn btn-link"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a></div>
            @elseif($row['Status']=="2" || $row['Status'] == "4")
            <div class="d-flex align-items-center justify-content-center"><a type="button" href="{{route('instruction.appointment',[$id,'show'])}}" title="View" class="btn btn-link"><i class="fas fa-eye" style="color: blue !important"></i></a></div>

            @endif
        </td>
    </tr>
        @endforeach
    </tbody>
</table>