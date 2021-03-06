@extends('layouts.app')

@section('content')
<div class="content p-3">
    

        <style>
        table {
          font-family: arial, sans-serif;
          color: black;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
        </style>
        
        @role('Registrar')
        {!! Form::open(['method' => 'GET', 'route' => ['goTo_enrollment.index'] ]) !!}
            {{Form::submit(' &larr; Enrollees',['class' => 'btn btn-link p-0'])}}
        {!! Form::close() !!}
        @endrole
        @role('Finance')
        {!! Form::open(['method' => 'GET', 'route' => ['finance.index'] ]) !!}
            {{Form::submit(' &larr; Back',['class' => 'btn btn-link p-0'])}}
        {!! Form::close() !!}
        @endrole

    
{{-- details on student --}}
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">ID: </label>
                <div class="col-sm-10 form-control" readonly>{{ $student->person->id }} </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Student No: </label>
                <div class="col-sm-10 form-control" readonly>{{ $student->id }} </div>
            </div>
                    
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name: </label>
                <div class="col-sm-10 form-control" readonly>{{ $student->full_name()}} </div>
            </div>
            <div class="form-group row">
                @forelse ($student->EnrolledProgramme as $ep )
                    <label class="col-sm-2 col-form-label">Programme: </label>
                    <div class="col-sm-2 form-control mb-3" readonly>{{ $ep->description }} </div>
                    <div class="col-sm-4 form-control mb-3" readonly>{{ $ep->Programme->name}} </div>
                    <div class="col-sm-4 form-control mb-3" readonly>{{ $ep->statusText()}} </div>
                @empty
                    <h1>no enrolled programme</h1>
                @endforelse
                
            </div>
        <div>

            <table>
                <td valign='top' width="600">
                    <h4><b> Statement of Account Summary </b></h4>
                    <span><b> S.Y. {{ $acadPeriod->acadYear }} {{ $acadPeriod->acadSemText() }}  </b></span>
                    <table>
                        <tbody>
                            
                            <tr>
                                <td style="font-weight:bold">CURRENT DUE:</td>
                                <td style="text-align:right;">{{ $currDue ?? "0.00"}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold" colspan="2">LESS</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;padding-left: 30px">OVERBALANCE:</td>
                                <td style="text-align:right">{{ $overbalance ?? "0.00"}} </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;padding-left: 30px">ADJUSTMENTS:</td>
                                <td style="text-align:right">{{ $adj ?? "0.00"}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;padding-left: 30px">PAYMENTS:</td>
                                <td style="text-align:right">{{ $totalPay ?? "0.00"}} </td>
                            </tr>
                            <tr>
                               
                                <td style="font-weight:bold; font-size: 14px; color: red">BALANCE:</td>
                                <td style="font-weight:bold; font-size: 14px; text-align:right; color: red">{{ $balance ??"0.00"}}</td>
                                
                            </tr>
                        </tbody>
                        
                    </table>
                </td>

                <td valign="top" width="400">
                    <h4>Breakdown of Fees</h4>
                    
                    
                        <table>
                                <tbody>
                                    <tr>
                                        <td><strong>TUITION FEE</strong></td>
                                        <td style="text-align:right"><strong>{{ $unitsFee ?? "0.00"}}</strong></td>
                                    </tr>


                                    <tr>
                                    <td><strong>MISCELLANEOUS FEES</strong></td>
                                        <td style="text-align:right">
                                            @if ($isGrad)
                                                <strong>{{ number_format($fees->totalMisc() + $fees->totalGradFee() + $totalLabFee,2) }}</strong>
                                            @else
                                                <strong>{{  number_format($fees->totalMisc() + $totalLabFee,2)}}</strong>
                                            @endif
                                        </td>
                                    
                                    @if ($isGrad)
                                        <tr>
                                            <td style="padding-left: 30px;">GRADUATION FEE</td>
                                            <td style="text-align:right"> {{ number_format($fees->gradfee,2)}}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 30px;">RETREAT FEE</td>
                                            <td style="text-align:right"> {{ number_format($fees->retreatfee,2)}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="padding-left: 30px;">LABORATORY FEE</td>
                                        <td style="text-align:right"> {{ number_format($totalLabFee,2) ?? "0.00"}}</td> 
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 30px;">A-DCB STUDENT ACTIVITIES</td>
                                        <td style="text-align:right"> {{ number_format($fees->misc_dcb,2) }}</td>
                                    </tr><tr>
                                        <td style="padding-left: 30px;">A-DEVELOPMENT FEE</td>
                                        <td style="text-align:right"> {{ number_format($fees->misc_devfee,2) }}</td>
                                    </tr><tr>
                                        <td style="padding-left: 30px;">A-ENERGY FEE</td>
                                        <td style="text-align:right">{{number_format($fees->misc_energyfee,2)  }}</td>
                                    </tr><tr>
                                        <td style="padding-left: 30px;">A-FACILITIES IMPROVEMENTS</td>
                                        <td style="text-align:right">{{ number_format($fees->misc_facimp,2) }}</td>
                                    </tr><tr>
                                    <td style="padding-left: 30px;">A-GUIDANCE &amp; COUNSELLING</td>
                                    <td style="text-align:right">{{ number_format($fees->misc_guidfee,2) }}</td>
                                    </tr><tr>
                                    <td style="padding-left: 30px;">A-INFORMATION TECHNOLOGY FEE</td>
                                    <td style="text-align:right">{{ number_format($fees->misc_ITfee,2)}}</td>
                                    </tr>
                                    <tr>
                                    <td style="padding-left: 30px;">A-INST RES/STUDENT INFO SYS FEE</td>
                                    <td style="text-align:right">{{ number_format($fees->misc_inst,2)}}</td>
                                    </tr>
                                    <tr>
                                    <td style="padding-left: 30px;">A-LIBRARY</td>
                                    <td style="text-align:right">{{ number_format($fees->misc_studIns,2) }}</td>
                                    </tr>
                                    <tr>
                                    <td style="padding-left: 30px;">A-MEDICO DENTAL</td>
                                    <td style="text-align:right">{{ number_format($fees->misc_medfee,2) }}</td>
                                    </tr>
                                    <tr>
                                    <td style="padding-left: 30px;">A-REGISTRATION FEE-OLD</td>
                                    <td style="text-align:right">{{ number_format($fees->regFee,2) }}</td>
                                    </tr>
                                    <tr>
                                    <td style="font-size: 14px;color:blue;"><strong>TOTAL TUITION FEE</strong></td>
                                    <td style="text-align:right;font-size: 14px;color:blue;"><strong>
                                        {{  $totalTuition ?? "0.00"}}
                                    </strong></td>
                                    </tr>
                                </tbody>
                        </table>
                </td>
                
            </table>
           
            <div class="d-flex flex-row">
                <!-- show next button if this is not the latest acadPeriod -->
                @if( App\Models\AcadPeriod::find( ($acadPeriod->id) -1) != null 
                    && $student->StudentUpdateFirst->acadPeriod_id != $acadPeriod->id)
                <div class="p-2">
                    {!! Form::open(['method' => 'GET', 'route' => ['balance', 'id' => $student->person_id] ]) !!}
                        {!! Form::hidden('acadPeriod_id', $acadPeriod->id - 1) !!}
                        {!! Form::hidden('prev', true) !!}
                        {{Form::submit('&larr; Prev',['class' => 'btn btn-link'])}}
                    {!! Form::close() !!}
                </div>
                @endif
                @if(!($acadPeriod->id == $student->StudentUpdateLatest->acadPeriod_id))
                    <div class="p-2"> 
                    {!! Form::open(['method' => 'GET', 'route' => ['balance', 'id' => $student->person_id] ]) !!}
                        {!! Form::hidden('acadPeriod_id', $acadPeriod->id + 1) !!}
                        {!! Form::hidden('next', true) !!}
                        {{Form::submit('Next &rarr;',['class' => 'btn btn-link'])}}
                    {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection