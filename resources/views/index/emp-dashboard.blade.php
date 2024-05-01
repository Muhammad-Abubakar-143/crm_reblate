@extends('layouts.master')
@section('title')
    Employee Dashboard
@endsection
@section('css')
    <!-- jsvectormap css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
    Employee Dashboard
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <style>
            .welcome-box {
                background-color: #ffffff;
                border-bottom: 1px solid #ededed;
                position: relative;
                margin: -30px -30px 30px;
                padding: 20px;
            }




            .time-list .dash-stats-list {
                flex-flow: column wrap;
                flex-grow: 1;
                padding: 0 15px;
            }

            .time-list .dash-stats-list h4 {
                color: #1f1f1f;
                font-size: 21px;
                font-weight: 700;
                line-height: 1.5;
                margin-bottom: 0;
            }

            .time-list .dash-stats-list p {
                color: #777;
                font-size: 13px;
                font-weight: 600;
                line-height: 1.5;
                margin-bottom: 0;
                text-transform: uppercase;
            }

            ul li {
                list-style: none;
            }

            .timesheet-right {
                color: #8E8E8E;
                font-size: 13px;
                float: right;
                margin-top: 7px;

            }


            .punch-info .punch-hours {
                border: 3px solid #fca311;
                max-width:250px;
                padding: 20px;
                margin: 0 auto;
                border-radius: 12px;
                position: relative;
                text-align: center;
            }



            .punch-hours span {
                font-weight: 500;
                transform: translate(-50%, -50%);
                font-size: 30px;
                color: #14213d;
            }

            .view-class-more {

                font-size: 16px;
                text-align: center;
                display: block;
                /* margin: 0px; */
                margin-top: 17px;

            }

            .timeliner {
               margin: 0 auto;
                letter-spacing: 0.2px;
                position: relative;
                padding-top: 20px;
                margin-left:10px;
                padding-bottom: 0;
                list-style: none;
                text-align: left;

            }

            @media (max-width: 767px) {
                .timeliner {
                    max-width: 98%;
                    padding: 25px;
                }
            }

            .timeliner h1 {
                font-weight: 300;
                font-size: 1.4em;
            }

            .timeliner h2,
            .timeliner h3 {
                font-weight: 600;
                font-size: 1rem;
                margin-bottom: 10px;
            }

            .timeliner .event {

                position: relative;
            }

            @media (max-width: 767px) {
                .timeliner .event {
                    padding-top: 30px;
                }
            }

            .timeliner .event:last-of-type {
                padding-bottom: 0;
                margin-bottom: 0;
                border: none;
            }

            .timeliner .event:before,
            .timeliner .event:after {
                position: absolute;
                display: block;
                top: 0;
            }

            .timeliner .event:before {
                left: -207px;
                content: attr(data-date);
                text-align: right;
                font-weight: 100;
                font-size: 0.9em;
                min-width: 120px;
            }

            @media (max-width: 767px) {
                .timeliner .event:before {
                    left: 0px;
                    text-align: left;
                }
            }

            .timeliner .event:after {
                -webkit-box-shadow: 0 0 0 3px #fca311;
                box-shadow: 0 0 0 3px #fca311;
                left: -23.6px;
                background: #fff;
                border-radius: 50%;
                height: 6px;
                width: 6px;
                content: "";
                top: 10px;
            }

            @media (max-width: 767px) {
                .timeliner .event:after {
                    left: -31.8px;
                }
            }

            .rtl .timeliner {
                text-align: right;
                border-bottom-right-radius: 0;
                border-top-right-radius: 0;
                border-bottom-left-radius: 4px;
                border-top-left-radius: 4px;
                border-right: 3px solid #727cf5;
            }

            .rtl .timeliner .event::before {
                left: 0;
                right: -170px;
            }

            .rtl .timeliner .event::after {
                left: 0;
                right: -55.8px;
            }


            /* CSS for styling the chart container */
            #line_chart {
                width: 100%;
                height: 400px;
            }
        </style>

        <div class="row mt-2">
            <div class="card">
                <div class="card-body d-flex justify-content-lg-between align-items-center flex-wrap gap-3">
                    <div class="col-md-3 d-flex align-items-center flex-wrap">

                        @if ($emp_det->Emp_Image != '' && file_exists($emp_det->Emp_Image) )
                            <img src="{{ $emp_det->Emp_Image }}"
                                style="width:120px;height:120px;border-radius:100%; object-fit:cover;" alt="">
                        @else
                        <img class="img-fluid rounded-circle" style="width:100px;height:100px; object-fit: cover;"
                        src="{{ url('user.png') }}">
                        @endif
                        <div class="welcome-det ms-3 text-dark fw-bolder">
                            <h3 style="font-size: 20px; color:#14213d">Welcome, </h3>
                            <span class="fw-bolder"
                                style="font-size: 20px; color:#fca311;">{{ isset($emp_det->Emp_Full_Name) && $emp_det->Emp_Full_Name ? $emp_det->Emp_Full_Name : 'Guest' }}</span>
                        </div>

                    </div>

                    <div class="">
                        <h3 style="font-size: 20px; color:#14213d">Designation:</h3>
                        <span class="fw-semibold "
                            style="color:#fca311; font-size: 20px;">{{ isset($emp_det->Emp_Designation) && $emp_det->Emp_Designation ? $emp_det->Emp_Designation : '' }}</span>
                    </div>
                    <div class="">
                        <h3 style="font-size: 20px; color:#14213d">Shift:</h3>
                        <span class="fw-semibold" style="color:#fca311; font-size: 20px;">
                            {{ isset($emp_det->Emp_Shift_Time) && $emp_det->Emp_Shift_Time ? $emp_det->Emp_Shift_Time : '' }}
                        </span>

                    </div>
                    <div>
                        <h3 style="font-size: 20px; color:#14213d">Today's Date</h3>
                        <span class="fw-bold" style="color:#fca311; font-size: 15px;">
                            {{ isset($t_date) ? $t_date : '' }}
                        </span>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 col-xl-4 col-sm-12">
                <div class="card overflow-hidden">
                    <div class="card-body overflow-hidden" style='padding-bottom:12px;'>
                        <div class="position-relative" style="z-index: 10">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class=" font-size-header mb-0" style='color:#000;'>Attendance </h3>

                            </div>
                            <div class="row px-2" >
                                <div class="col-md-4" style='width:33%'>
                                    <h3 style="color: #14213d;">
                                        @if (isset($total_present_day) && $total_present_day != '')
                                            {{ $total_present_day }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                    <p style="color:#14213d;font-size: 16px;">Total <br> Present</p>
                                </div>
                                <div class="col-md-4" style='width:33%'>
                                    <h3 style='color:red;'>
                                        @if (isset($absent_days) && $absent_days != '')
                                            {{ $absent_days }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                    <p style="color:#14213d; font-size: 16px;">Total <br> Absent </p>
                                </div>
                                <div class="col-md-4" style='width:33%'>
                                    <h3 style='color:orange;'>{{ $total_leaves }}</h3>
                                    <p style="color:#14213d; font-size: 16px;">Total <br> Leaves</p>
                                </div>
                                <div class="col-md-4" style='width:33%'>
                                    <h3 style='color:red;'>0</h3>
                                    <p style="color:#14213d; font-size: 16px;">Pending <br> Approval</p>
                                </div>
                                <div class="col-md-4" style='width:33%'>
                                    <h3 style='color:#14213d;'>22</h3>
                                    <p style="color:#14213d; font-size: 16px;">Working <br> Days</p>
                                </div>
                                <div class="col-md-4" style='width:33%'>
                                    <h3 style='color:red;'>2000</h3>
                                    <p style="color:#14213d; font-size: 16px;">Loss of <br> Pay</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-4 justify-content-between">
                            <div class="w-100 d-flex justify-content-between position-relative" style="z-index: 10;">
                                <button type="button" class="reblateBtn px-3 py-2" data-toggle="modal"
                                    data-target="#exampleModal">Apply for Leave</button>
                                <a href="/leave-records" class="reblateBtn px-3 py-2">Leave Records</a>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header pb-0">
                                            <h5 class="modal-title" id="exampleModalLabel">Leave Application form</h5>
                                            <button type="button" class="close"
                                                style="border: none; background-color: transparent;" data-dismiss="modal"
                                                aria-label="Close">
                                                <span class="fs-3" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="leaveForm" action="">
                                                <div id="messageBox"></div>
                                                <div class="form-group mt-3">
                                                    <label for="date">Date</label>
                                                    <input type="date" class="form-control inputboxcolor"
                                                        style="border: 1px solid #ced4da;" id="date" name="date">
                                                    <span class="text-danger" id="dateBox" style="display: none">Please
                                                        Select
                                                        a date!</span>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="reason">Reason:</label>
                                                    <textarea class="form-control inputboxcolor" style="border: 1px solid #ced4da; resize: none; height: 100px;"
                                                        id="reason" name="reason" placeholder="Reason:" rows="5"></textarea>
                                                    <span class="text-danger" id="reasonBox" style="display: none">Please
                                                        Write a
                                                        reason!</span>
                                                </div>

                                            </form>
                                            <button type="submit" class="reblateBtn px-3 py-2 mt-3"
                                                onclick="submitForm(event)">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class=" font-size-header mb-0" style='color:#000;'>Today's Activity </h3>
                        </div>
                        <div id="content">
                            <ul class="timeliner d-grid gap-3" style="grid-template-columns: 1fr 1fr;" >
                                <li class="event mb-1">
                                    <h4 class="mb-1" style="color: #14213d">Check In</h4>
                                    @if (session()->has('check_in_time') && session('check_in_time') != '')
                                        <p class="mb-1">{{ session('check_in_time') }}</p>
                                    @else
                                        <p class="mb-1">No Check In</p>
                                    @endif
                                </li>
                                <li class="event mb-1">
                                    <h4 class="mb-1" style="color: #14213d">Break Start</h4>
                                    @if (session()->has('break_start_time') && session('break_start_time') != '')
                                        <p class="mb-1">{{ session('break_start_time') }}</p>
                                    @else
                                        <p class="mb-1">No Break Start</p>
                                    @endif
                                </li>
                                <li class="event mb-1">
                                    <h4 class="mb-1" style="color: #14213d">Break End</h4>
                                    @if (session()->has('break_end_time') && session('break_end_time') != '')
                                        <p class="mb-1">{{ session('break_end_time') }}</p>
                                    @else
                                        <p class="mb-1">No Break End Time</p>
                                    @endif
                                </li>
                                <li class="event mb-1">
                                    <h4 class="mb-1" style="color: #14213d">Check Out</h4>
                                    @if (session()->has('check_out_time') && session('check_out_time') != '')
                                        <p class="mb-1">{{ session('check_out_time') }}</p>
                                    @else
                                        <p class="mb-1">No Checkout</p>
                                    @endif
                                </li>
                                <li class="event mb-1">
                                    <h4 class="mb-1" style="color: #14213d">Overtime <br/> Start</h4>
                                    @if (session()->has('overtime_start') && session('overtime_start') != '')
                                        <p class="mb-1">{{ session('overtime_start') }}</p>
                                    @else
                                        <p class="mb-1">No Overtime Start</p>
                                    @endif
                                </li>
                                <li class="event mb-1">
                                    <h4 class="mb-1" style="color: #14213d">Overtime <br/> End</h4>
                                    @if (session()->has('overtime_end') && session('overtime_end') != '')
                                        <p class="mb-1">{{ session('overtime_end') }}</p>
                                    @else
                                        <p class="mb-1">No Overtime End</p>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-xl-4 col-sm-12">
                <div class="card">
                    <div class="card-body" >
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class=" font-size-header mb-0" style='color:#000;'>Timesheet </h3>

                        </div>
                        <div class="punch-info">
                            <div class="punch-hours">
                                @if(session()->has('total_over_time') && session('total_over_time')!='')
                                   <span>{{session('total_over_time')}}</span>
                                @elseif(session()->has('total_hours') && session('total_hours') != '')
                                    <span>{{ session('total_hours') }}</span>
                                @else
                                    {{-- <span>0 hrs</span> --}}

                                    <span id="timer" class="text-center timer">00:00:00</span>

                                    {{-- <div id="timer" class="text-center timer">00:00:00</div> --}}
                                @endif
                            </div>



                            @if (isset($day_message) && $day_message != '')
                                <span class="text-center text-danger">{{ $day_message }}</span>
                            @endif
                            @if (isset($check_in_already_message) && $check_in_already_message != '')
                                <span class="font-text text-danger">{{ $check_in_already_message }}</span>
                            @endif
                            @if (isset($success_message) && $success_message != '')
                                <span class="text-center green-text">{{ $success_message }}</span>
                            @endif

                            <div class="break-time d-flex align-items-center justify-content-between mb-3" style='margin-top:25px;'>
                                <p class="mb-0 font-size-15" >Target Working Hours</p>
                                <p class="mb-0 font-size-15" >7:00 / Day</p>
                            </div>
                            @if (session()->has('attendence_status') && session('attendence_status') === true)
                                    <div>
                                        <span style="color:#3e7213;font-size:16px;"> <svg xmlns="http://www.w3.org/2000/svg"
                                            width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="#3e7213"
                                                d="M.41 13.41L6 19l1.41-1.42L1.83 12m20.41-6.42L11.66 16.17L7.5 12l-1.43 1.41L11.66 19l12-12M18 7l-1.41-1.42l-6.35 6.35l1.42 1.41z" />
                                        </svg> Attendence Marked Successfully!</span>
                                    </div>

                                    @if ( session()->has('overtime_status') && session('overtime_status') === true)
                                    <div>
                                        <span style="color:#3e7213;font-size:16px;"> <svg xmlns="http://www.w3.org/2000/svg"
                                            width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="#3e7213"
                                                d="M.41 13.41L6 19l1.41-1.42L1.83 12m20.41-6.42L11.66 16.17L7.5 12l-1.43 1.41L11.66 19l12-12M18 7l-1.41-1.42l-6.35 6.35l1.42 1.41z" />
                                        </svg> Over time marked!</span>
                                    </div>

                                        @elseif( session()->has('show_over_time_end') && session('show_over_time_end') === false)
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <a class="reblateBtn px-4 py-2 w-md" href="/overtime-start" >Overtime Start
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                                        viewBox="0 0 21 21">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="m11.5 13.535l-3-3.035l3-3m7 3h-10" />
                                                            <path
                                                                d="M16.5 8.5V5.54a2 2 0 0 0-1.992-2l-8-.032A2 2 0 0 0 4.5 5.5v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3" />
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>

                                        </div>
                                        @elseif( session()->has('show_over_time_end') && session('show_over_time_end') === true)
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <a class="reblateBtn px-4 py-2 w-md" href="/overtime-end" >Overtime End
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                                        viewBox="0 0 21 21">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="m11.5 13.535l-3-3.035l3-3m7 3h-10" />
                                                            <path
                                                                d="M16.5 8.5V5.54a2 2 0 0 0-1.992-2l-8-.032A2 2 0 0 0 4.5 5.5v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3" />
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>

                                    @endif



                            @else
                                <div class="d-flex flex-wrap justify-content-between gap-4 align-items-center">

                                        @if (session()->has('show_check_out') && session('show_check_out') === true)
                                            <a class="reblateBtn px-4 py-2 w-md" href="javascript:void()" onclick="checkOut()"   >Checking Out
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                                    viewBox="0 0 16 16">
                                                    <g fill="currentColor" fill-rule="evenodd">
                                                        <path
                                                            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                                        <path
                                                            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                                    </g>
                                                </svg>
                                            </a>
                                        @else
                                            <a class="reblateBtn px-4 py-2" href="/check-in">Checking In
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                                    viewBox="0 0 21 21">
                                                    <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="m11.5 13.535l-3-3.035l3-3m7 3h-10" />
                                                        <path
                                                            d="M16.5 8.5V5.54a2 2 0 0 0-1.992-2l-8-.032A2 2 0 0 0 4.5 5.5v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3" />
                                                    </g>
                                                </svg>
                                            </a>
                                        @endif


                                    @if (session()->has('show_break_end') && session('show_break_end') === true)
                                        <a class="reblateBtn px-4 py-2" href="/break-end">Break End
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                                viewBox="0 0 16 16">
                                                <g fill="currentColor" fill-rule="evenodd">
                                                    <path
                                                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                                    <path
                                                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                                </g>
                                            </svg>
                                        </a>
                                    @else
                                        <a class="reblateBtn px-4 py-2" href="/break-start" >BreakStart
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                                viewBox="0 0 16 16">
                                                <g fill="currentColor" fill-rule="evenodd">
                                                    <path
                                                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                                    <path
                                                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                                </g>
                                            </svg>
                                        </a>
                                    @endif


                                </div>
                            @endif
                            <div class="view-class-more">
                                <a href="/view-attendence" style="color:#fca311;">View Attendence</a>
                            </div>


                        </div>



                    </div>
                </div>

            </div>

        </div>
        <!-- END ROW -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="bar_chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartDiv"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- END ROW -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex" style="background-color: #e3e3e3">
                        <h4 class="card-title mb-0 flex-grow-1">Tasks</h4>

                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr style="border-bottom: 1px solid #e3e3e3;">

                                        <th>Task Title</th>
                                        <th>Task Date</th>
                                        {{-- <th>Tasks</th> --}}
                                        <th>Task Status</th>
                                        <th>Assigned By</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="row-hover" style="border-bottom: 1px solid #e3e3e3;">
                                        {{-- {{count($latest_tasks)}} --}}
                                        @if (count($latest_tasks) >= 1)
                                            @foreach ($latest_tasks as $task)
                                    <tr>
                                        <td>{{ $task->task_title }}</td>
                                        <td>{{ $task->task_date }}</td>
                                        <td>
                                            @if ($task->task_status == 'completed')
                                                <span
                                                class="badge badge-soft-success font-size-12">{{ $task->task_status }}</span>
                                            @elseif ($task->task_status == 'in-progress')
                                                <span
                                                class="badge badge-soft-warning font-size-12">{{ $task->task_status }}</span>
                                            @else
                                                <span
                                                class="badge badge-soft-danger font-size-12">{{ $task->task_status }}</span>

                                            @endif
                                            </td>
                                        <td>{{ $task->assigned_by }}</td>
                                        {{-- <td>{{$task->task_title}}</td> --}}
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center" style="height: 175px">
                                            <h3>No Task Assigned</h3>
                                        </td>
                                    </tr>
                                    @endif
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pt-3">
                            <a href="/view-emp-tasks-each" class="w-md">View All</a>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex " style="background-color: #e3e3e3">
                        <h4 class="card-title mb-0 flex-grow-1">Task Report</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive simplebar-scrollable-y simplebar-scrollable-x" data-simplebar="init"
                            style="max-height: 220px;">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content" style="height: auto; overflow: scroll;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                <table
                                                    class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <tr style="border-bottom: 1px solid #e3e3e3;">

                                                            <th>Project Name</th>
                                                            <th>Description</th>
                                                            <th>Deadline</th>
                                                            <th>Assigned By</th>
                                                            <th>See Details</th>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task1</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task2</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task3</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task4</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task5</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task6</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task7</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>






                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 440px; height: 469px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="width: 395px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 273px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <a href="#" class=" w-md">View All</a>
                        </div> <!-- enbd table-responsive-->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex " style="background-color: #e3e3e3">
                        <h4 class="card-title mb-0 flex-grow-1">Projects</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive simplebar-scrollable-y simplebar-scrollable-x" data-simplebar="init"
                            style="max-height: 220px;">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content" style="height: auto; overflow: scroll;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                <table
                                                    class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <tr style="border-bottom: 1px solid #e3e3e3;">

                                                            <th>Project Name</th>
                                                            <th>Description</th>
                                                            <th>Deadline</th>
                                                            <th>Assigned By</th>
                                                            <th>See Details</th>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task1</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task2</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task3</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task4</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task5</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task6</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task7</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 440px; height: 469px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="width: 395px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 273px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <a href="#" class=" w-md">View All</a>
                        </div> <!-- enbd table-responsive-->
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex " style="background-color: #e3e3e3">
                        <h4 class="card-title mb-0 flex-grow-1">Projects Report</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive simplebar-scrollable-y simplebar-scrollable-x" data-simplebar="init"
                            style="max-height: 220px;">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content" style="height: auto; overflow: scroll;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                <table
                                                    class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <tr style="border-bottom: 1px solid #e3e3e3;">

                                                            <th>Project Name</th>
                                                            <th>Description</th>
                                                            <th>Deadline</th>
                                                            <th>Assigned By</th>
                                                            <th>See Details</th>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task1</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task2</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task3</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task4</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task5</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task6</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-muted mb-0 font-size-14">Task7</h6>
                                                            </td>
                                                            <td style="width: 20px;">#MB2540</td>
                                                            <td><span
                                                                    class="badge badge-soft-danger font-size-12">Deadline</span>
                                                            </td>
                                                            <td>
                                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                                                                    class="avatar-xs rounded-circle me-2" alt="...">
                                                                Neal Matthews
                                                            </td>
                                                            <td>
                                                                <a href="#">see more</a>
                                                            </td>
                                                        </tr>






                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 440px; height: 469px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="width: 395px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 273px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <a href="#" class=" w-md">View All</a>
                        </div> <!-- enbd table-responsive-->
                    </div>
                </div>
            </div>
        </div>

        <!-- END ROW -->


        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script type="text/javascript">
            const chartDiv = document.getElementById('chartDiv');

            new Chart(chartDiv, {
                type: 'bar',
                data: {
                    labels: ['Presents', 'Absents', 'Leaves'],
                    datasets: [{
                        label: 'Attendance',
                        data: [<?php echo $total_present_day; ?>, <?php echo $absent_days; ?>, <?php echo $total_leaves; ?>],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(255, 205, 86, 0.5)',

                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'x',
                }
            });
            const chartId2 = document.getElementById('bar_chart');

            new Chart(chartId2, {
                type: 'bar',
                data: {
                    labels: ['Completed', 'Pending', 'In Progress'],

                    datasets: [{
                        label: 'Tasks',
                        data: [<?php echo $completed_count; ?>, <?php echo $pending_count; ?>, <?php echo $in_progress_count; ?>],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(255, 205, 86, 0.5)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                }
            });
        </script>


        <script>
            // Function to update the current time
            function updateCurrentTime() {
                const now = new Date();
                let hours = now.getHours();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // 0 should be displayed as 12
                const minutes = pad(now.getMinutes());
                const seconds = pad(now.getSeconds());
                document.getElementById('timer').innerText = hours + ":" + minutes + ":" + seconds +
                    " " + ampm;
            }

            // Function to pad single digit numbers with leading zeros
            function pad(num) {
                return (num < 10) ? '0' + num : num;
            }

            // Update current time immediately when the page loads
            updateCurrentTime();

            // Update current time every second
            setInterval(updateCurrentTime, 1000);

            function submitForm(event) {
                event.preventDefault();

                var dateValue = document.getElementById('date').value;
                var reasonValue = document.getElementById('reason').value;
                var dateBox = document.getElementById('dateBox');
                var reasonBox = document.getElementById('reasonBox');
                var messageBox = document.getElementById('messageBox');

                dateBox.style.display = "none";
                reasonBox.style.display = "none"; // Corrected line

                if (dateValue === '') {
                    dateBox.style.display = "block";
                    return;
                }
                if (reasonValue === '') {
                    reasonBox.style.display = "block";
                    return;
                }

                var formData = {
                    _token: '{{ csrf_token() }}',
                    date: dateValue,
                    reason: reasonValue
                };

                $.ajax({
                    type: 'POST',
                    url: '/apply-for-leave',
                    data: formData,
                    success: function(response) {
                        // console.log('AJAX request successful');

                        $('#messageBox').text(response.message);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message :
                            'An error occurred';

                        $('#messageBox').text(errorMessage); // Set the error message from the server response
                    }
                });
            }

            function checkOut() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to check out!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#FF5733', // Red color for "Yes"
                    cancelButtonColor: '#4CAF50', // Green color for "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the task
                        $.ajax({
                            url: '/check-out/',
                            method: 'GET', // Use the DELETE HTTP method
                            success: function() {
                                // Provide user feedback
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'check out marked!',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload(); // Refresh the page
                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle errors, you can display an error message to the user
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while checking out the user!',
                                    icon: 'error'
                                });
                            }
                        });

                    }
                });
            }

        </script>
    @endsection
    @section('scripts')
        <!-- apexcharts -->
        {{-- <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script> --}}

        <!-- Vector map-->
        {{-- <script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script> --}}
        {{-- <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script> --}}

        <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @endsection
