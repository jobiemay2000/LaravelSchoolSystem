@extends('layouts.app')

@section('content')
<div class="content px-3">
    {{-- header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Statement of Accounts</h1>
                        <span style="font-size: smaller;">
                            Finance
                        </span>
                        <hr>
                    </div>
                </div>
            </div>
        </section>
    {{-- /header --}}

    {{-- body --}}
        <div class="content px-3">
            <div class="clearfix"> @include('flash::message')</div>
            <div class="card">
                <div class="card-body p-10">
                    <div class="table-responsive">
                        <table class="table table-hover" id="enrollment-table">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Enrollment Status</th>
                                <th style="text-align: center;">RGC NO</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Programme</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                
                            @foreach($students  as $students )
                                
                                <tr>
                                    <td style="text-align: center;">
                                        {{-- finance should have a table data like this to tag student as enrolled --}}
                                        {!! Form::model($students, ['route' => ['update.enrollTag', $students->id], 'method' => 'patch']) !!}
                                    
                                        @switch($students->isEnrolled)
                                            @case(0)
                                                {!! Form::hidden('isEnrolled', 1) !!}
                                                {{Form::submit('Tag as Enrolled',['class' => 'btn btn-info btn-xs'])}}
                                                @break
                                            @default
                                                {!! Form::hidden('isEnrolled', 0) !!}
                                                {{Form::submit('Enrolled',['class' => 'btn btn-success btn-xs', 
                                                'onclick' => "return confirm('Are you sure you want to unenroll student?')"])}}
                                        @endswitch
                                            
                                        {!!Form::close()!!} 
                    
                                    </td>
            
                                    <td style="text-align: center;">
                                        {{ $students->StudentUpdateLatest->id }}
                                    </td>
                                    <td>
                                        {{ $students->person_id }}
                                    </td>
                                    <td>
                                        {{ $students->full_name() }}
                                        
                                    </td>
                                    <td>
                                        @forelse ($students->EnrolledProgramme as $course )
                                                <span class="p-1">{{ $course->Programme->name}}</span>
                                                <br>
                                        @empty
                                            No Course yet
                                        @endforelse
                                    
                                    </td>
                                    <td>
                                        @forelse ($students->EnrolledProgramme as $course )
                                                <span class="p-1">{{ $course->description}}</span>
                                                <br>
                                        @empty
                                            No Course yet
                                        @endforelse
                                    </td>
                                    <td>
                                        {{-- curriculum --}}
                                        {!! Form::open(['method' => 'GET', 'route' => 'courseProgramme.show' ]) !!}
                                            {!! Form::hidden('id', $students->person_id ) !!}   
                                            {{Form::submit('Curriculum' ,['class' => 'btn btn-link p-0 '])}}
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        {{-- pre reg --}}
                                        {!! Form::open(['method' => 'GET', 'route' => ['goTo_prereg' , 'id' => $students->person_id ] ]) !!}
                                            {!! Form::hidden('id', $students->person_id ) !!}
                                            {!! Form::hidden('acadYear', \App\Models\AcadPeriod::latest()->value('acadYear') ) !!}
                                            {!! Form::hidden('acadSem', \App\Models\AcadPeriod::latest()->value('acadSem') ) !!}    
                                            {{Form::submit('Prereg' ,['class' => 'btn btn-link p-0 '])}}
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        
                                        {!! Form::open(['method' => 'GET', 'route' => ['balance', 'id' => $students->person_id] ]) !!}
                                            {!! Form::hidden('acadPeriod_id', \App\Models\AcadPeriod::latest()->value('id')) !!}
                                            {{Form::submit('Balance',['class' => 'btn btn-link p-0'])}}
                                        {!! Form::close() !!}
                                        
                                    </td>
                                    <td>
                                        <a href="{{ route('payment.show', [$students->person_id]) }}"
                                            class='btn btn-link p-0'>
                                            History
                                        </a> 
                                    </td>
                                    <td>
                                        <a href="{{ route('goTo_payment', [$students->person_id]) }}"
                                        class='btn btn-info btn-xs'>
                                            Add Payment
                                        </a> 
                                    </td> 
                    
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    @push('scripts')
                        <script
                        src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
                        </script>
                        <script>
                            $(document).ready( function () {
                                $('#enrollment-table').DataTable();
                            
                            } );
                        </script>
                    @endpush
                    
                </div>

            </div>


            {{-- <div class="">
                
                <a href="{{ route('update.dues') }}" class="btn btn-primary float-right"
                onclick ="return confirm('All account due balance for the semester will be updated')"
                >Update Statement of Accounts</a> 
            </div> --}}

        </div>
    {{-- /body --}}
</div>
@endsection

