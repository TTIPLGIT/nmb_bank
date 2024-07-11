<table class="table table-bordered" id="align">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>Task Name</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows['tableData'] as $row)
        <tr>

            <td>{{$loop->iteration}}</td>
            <td>{{$row['task_name']}}</td>
            <td>{{$row['created_at']}}</td>
            @if($row['status'] == 'Active')
            <td class="text-white"><span class="badge2 warning rounded-pill text-bg-warning downward">{{$row['status']}}</span></td>
            @elseif($row['status']=='Approved')
            <td class="text-white"><span class="badge2 success rounded-pill text-bg-warning downward">{{$row['status']}}</span></td>
            @else
            <td class="text-white"><span class="badge2 success rounded-pill text-bg-warning downward">{{$row['status']}}</span></td>
            @endif
            <td>
                @php $id = Crypt::encrypt($row['id']); @endphp


                <div class="d-flex align-items-center justify-content-center">
                    <a type="button" data-toggle="modal" data-target="#cocModal{{$loop->iteration}}" title="Chain of Custody" class="btn btn-link"><img width="30" src="{{asset('assets/images/customIcons/coc.png')}}"></a>
                    @if($row['status'] == 'Active')
                    <a type="button" href="{{route('instruction.appointment',[$id,'show'])}}" title="View" class="btn btn-link"><i class="fas fa-eye" style="color: blue !important"></i></a>
                    @elseif($row['status'] == 'Approved')
                    <a type="button" href="{{route('instruction.appointment',[$id,'show'])}}" title="View" class="btn btn-link"><i class="fas fa-eye" style="color: blue !important"></i></a>
                    <a type="button" data-toggle="modal" data-target="#templates" data-file='{{"/userdocuments/instructionReport/document_" . $row["id"] . ".pdf"}}' title="View" class="btn btn-link fileView"><i class="fa fa-file-text-o" style="color: blue !important"></i></a>
                    @else
                    <a type="button" href="{{route('instruction.appointment',[$id,'edit'])}}" title="View" class="btn btn-link"><i class="fas fa-edit" style="color: blue !important"></i></a>

                    @endif
                </div>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>