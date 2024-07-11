<!-- Status
1=> Pending
2=>submitted
3=>Approved
4=>Rejeted -->
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
        @foreach($rows['instructionData'] as $row)
        @php $assignedName = App\Http\Controllers\BaseController::getusername($row['assigned_by']);
        $id = Crypt::encrypt($row['government_task_id']);
        @endphp
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{ $row['task_name']}}</td>
        <td>{{$assignedName}}</td>

        @if($row['task_status']=="1")
        <td class="text-white"><span class="badge2 success rounded-pill text-bg-warning downward">Pending<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
        @elseif($row['task_status']=="2")
        <td sclass="text-white"><span class="badge2 warning rounded-pill text-bg-success">Submitted</span></td>
        @elseif($row['task_status']=="3")
        <td class="text-white"><span class="badge2 danger rounded-pill text-bg-warning downward">Approved<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
        @elseif($row['task_status']=="4")
        <td class="text-white"><span class="badge2 success rounded-pill text-bg-success downward">Approved<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
        @endif

        @if($row['task_status']=="1" || $row['task_status']=="4")
        <td>
            <div class="d-flex align-items-center justify-content-center"><a type="button" href="{{route('instruction.taskSubmission',[$id,'edit'])}}" title="Edit" class="btn btn-link"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a></div>
        </td>
        @elseif($row['task_status']=="2" || $row['task_status']=="3")
        <td>
            <div class="d-flex align-items-center justify-content-center"><a type="button" href="{{route('instruction.taskSubmission',[$id,'show'])}}" title="View" class="btn btn-link"><i class="fas fa-eye" style="color: blue !important"></i></a></div>
        </td>
        @endif
        </tr>
        @endforeach
    </tbody>
</table>