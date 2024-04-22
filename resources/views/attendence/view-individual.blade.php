@extends('layouts.master')
@section('title')
    View Attendence Details
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
    View Attendence Details
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <style>
            .att-statistics .stats-info {
                background-color: #fff;
                border: 1px solid #e5e5e5;
                text-align: center;
                border-radius: 4px;
                margin: 0 0 5px;
                padding: 15px;
            }

            .att-statistics .stats-info p {
                font-size: 12px;
                margin: 0 0 5px;
            }
        </style>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body" style="display: flex; align-items: center; justify-content: space-between;">
                        <!-- Using a dummy CDN link for the image -->
                        <a href="/view-tasks" class="position-absolute top-0 start-1 pt-2">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#14213d" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"></path>
                        </svg> --}}
                        </a>

                        <div class="d-flex align-items-center gap-3" style="margin-left: 15px;">
                            @if ($emp->Emp_Image != '' && file_exists($emp->Emp_Image))
                                <img class="img-fluid rounded-circle" style="width:100px;height:100px; object-fit: cover;"
                                    src="{{ url($emp->Emp_Image) }}">
                            @else
                                <img class="img-fluid rounded-circle" style="width:100px;height:100px; object-fit: cover;"
                                    src="{{ url('user.png') }}">
                            @endif

                            <div class="d-flex flex-column gap-1 ml-4">
                                <h5 class="card-title mb-0" style="font-size: 25px;">{{ $emp_name }}</h5>
                                <p class="card-text mb-1 ">{{ $emp->Emp_Designation }}</p>
                                <p class="card-text">{{ $emp->Emp_Shift_Time }}</p>
                                <p class="card-text">{{ $emp->Emp_Code }}</p>

                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center p-3 gap-2" style="">


                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">View Attendence Details</h4>
                        {{-- <p class="card-title-desc">The Buttons extension for DataTables
                                provides a common set of options, API methods and styling to display
                                buttons on a page that will interact with a DataTable. The core library
                                provides the based framework upon which plug-ins can built.
                            </p> --}}


                        <form action="/search-emp-details" method="post">
                            @csrf
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    {{-- <input placeholder="Select date" type="date" name="date_controller"
                                        class="form-control" value="{{ old('date_controller') }}">

                                     <span>
                                        @error('date_controller')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </span>
                                    --}}
                                    {{-- <input type="hidden" value=""> --}}
                                    <input type="text" name="daterange" value="" class="form-control" />
                                </div>



                                @if (isset($id) && $id != '')
                                    <input type="hidden" name="emp_search_date" value="{{ $id }}">
                                @endif



                                <div class="col-md-3">
                                    <button class="reblateBtn px-3 py-2">Search</button>
                                </div>
                        </form>



                        <!-- Bootstrap modal -->
                        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog"
                            aria-labelledby="updateModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Update Attendance</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form fields for updating attendance -->
                                        <form id="updateForm">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="text" class="form-control" id="date" name="date"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="checkIn">Check In Time</label>
                                                <input type="text" class="form-control" id="checkIn" name="checkIn">
                                            </div>
                                            <!-- Add more form fields for other attendance data -->
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>






                        {{-- <div class="col-md-3">
                                    <div class="card att-statistics">
                                        <div class="card-body">
                                            <h5 class="card-title">Statistics</h5>
                                            <div class="stats-list">
                                                <div class="stats-info">
                                                    <p>Today <strong>3.45 <small>/ 8 hrs</small></strong></p>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary w-31" role="progressbar"
                                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="stats-info">
                                                    <p>This Week <strong>28 <small>/ 40 hrs</small></strong></p>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning w-31" role="progressbar"
                                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="stats-info">
                                                    <p>This Month <strong>90 <small>/ 160 hrs</small></strong></p>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success w-62" role="progressbar"
                                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="stats-info">
                                                    <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger w-62" role="progressbar"
                                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="stats-info">
                                                    <p>Overtime <strong>4</strong></p>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info w-62" role="progressbar"
                                                            aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                    </div>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                {{-- <th> Emp ID</th> --}}
                                <th> Name</th>
                                {{-- <th> Date</th> --}}
                                <th> Day</th>
                                {{-- <th> Month</th> --}}
                                <th> Year</th>
                                <th> Check In</th>
                                <th> Check Out</th>
                                <th> Break Start</th>
                                <th> Break End</th>
                                <th> Total Time Worked</th>
                                {{-- <th> Over Time</th> --}}
                                @if (auth()->user()->user_type == 'admin')
                                    <th> Action</th>
                                @endif

                            </tr>
                        </thead>

                        <tbody id="table-body">

                            @foreach ($check_attendence as $emp)
                                <tr>

                                    @php
                                        // Parse the date string into a Carbon instance
                                        $carbonDate = \Carbon\Carbon::parse($emp->date);
                                        // Extract month name and year
                                        $monthName = $carbonDate->monthName;
                                        $year = $carbonDate->year;
                                        // Output the month name and year
                                        // echo "$monthName $year";
                                        // Extract day name
                                        $dayName = $carbonDate->englishDayOfWeek;
                                        $dayName = $carbonDate->dayName;
                                        $day_number = $carbonDate->format('j');
                                        $formattedDate = $carbonDate->format('j F Y');

                                                    // Convert time into 24-hour format and handle null values
            $check_in_time_24 = $emp->check_in_time ? \Carbon\Carbon::parse($emp->check_in_time)->format('H:i') : '';
            $check_out_time_24 = $emp->check_out_time ? \Carbon\Carbon::parse($emp->check_out_time)->format('H:i') : '';
            $break_start_24 = $emp->break_start ? \Carbon\Carbon::parse($emp->break_start)->format('H:i') : '';
            $break_end_24 = $emp->break_end ? \Carbon\Carbon::parse($emp->break_end)->format('H:i') : '';

                                        if($check_out_time_24 == null) {
                                            $break_start_24 = "";
                                        }

                                        if($break_start_24 == null) {
                                            $break_start_24 = "";
                                        }
                                        if($break_end_24 == null) {
                                            $break_end_24 = "";
                                        }



                                    @endphp

                                    {{-- <td>{{ $emp->emp_id }}</td> --}}
                                    <td>{{ $emp_name }}</td>
                                    {{-- <td>{{ $formattedDate }}</td> --}}
                                    @php
                                        if ($day_number < 10) {
                                            $day_number = '0' . $day_number;
                                        }
                                    @endphp



                                    <td>{{ $monthName }} {{ $day_number }} </td>
                                    {{-- <td>{{ $monthName }}</td> --}}
                                    <td>{{ $year }}</td>
                                    {{-- <td>{{ ( $emp->Emp_Code < 10) ? '00'.$emp->Emp_Code : $emp->Emp_Code }}sols</td> --}}
                                    {{-- <td><a href="{{ Route('view-client-detail', $client->client_id) }}">{{ $client->client_name }} </a></td> --}}
                                    <td>{{ $emp->check_in_time  ?? ''}} </a></td>
                                    <td>{{ $emp->check_out_time ?? '' }} </a></td>
                                    <td>{{ $emp->break_start ?? '' }}</td>
                                    <td>{{ $emp->break_end ?? ''}}</td>
                                    <td>{{ $emp->total_time }}</td>
                                    {{-- <td>0 Hrs</td> --}}
                                    @if (auth()->user()->user_type == 'admin')
                                        {{-- <td><a class="open-popup" href="#" data-emp-id="{{ $emp->emp_id }}"><svg xmlns="http://www.w3.org/2000/svg" width="1.2rem" height="1.2rem" viewBox="0 0 24 24"><path fill="currentColor" d="m14.06 9l.94.94L5.92 19H5v-.92zm3.6-6c-.25 0-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29m-3.6 3.19L3 17.25V21h3.75L17.81 9.94z"/></svg></a></td> --}}
                                        <form action="/show-update-attendence-form" method="post">
                                            @csrf
                                            <input type="hidden" value="{{ $emp->id }}" name="attendence_id">
                                            <input type="hidden" value="{{ $emp->emp_id }}" name="emp_id">
                                            <td>
                                                {{-- <button>Edit</button> --}}
                                                <a href="#emp_{{ $emp->id }}" data-toggle="modal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem"
                                                        viewBox="0 0 24 24">
                                                        <path fill="#14213d"
                                                            d="m14.06 9l.94.94L5.92 19H5v-.92zm3.6-6c-.25 0-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29m-3.6 3.19L3 17.25V21h3.75L17.81 9.94z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </form>
                                    @endif

                                    <!-- Bootstrap modal for the popup form -->
                                    <div class="modal fade" id="emp_{{ $emp->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Update Employee Attendance
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Your form content goes here -->
                                                    <p>Date: {{ $day_number }} {{ $monthName }}, {{ $year }}
                                                    </p>
                                                    <form id="editForm">
                                                        <div class="form-group mt-2">
                                                            <label for="editCheckIn">Check In Time</label>
                                                            <input type="time" class="form-control"
                               id="editCheckIn" name="checkInTime"
                               value="{{ $check_in_time_24 }}"> <!-- Corrected -->
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="editCheckOut">Check Out Time</label>
                                                            <input type="time" value="{{ $check_out_time_24 }}"
                                                                class="form-control" id="editCheckOut"
                                                                name="checkOutTime">
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="editBreakStart">Break Start</label>
                                                            <input type="time" value="{{ $break_start_24 }}"
                                                                class="form-control" id="editBreakStart"
                                                                name="breakStart">
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="editBreakEnd">Break End</label>
                                                            <input type="time" value="{{ $break_end_24 }}"
                                                                class="form-control" id="editBreakEnd" name="breakEnd">
                                                        </div>
                                                        <!-- Add more fields as needed -->
                                                        <button type="submit"
                                                            class="btn btn-primary mt-2">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </tr>
                            @endforeach
                        </tbody>



                    </table>
                </div>
            </div>
        </div> <!-- end col -->



        <script>
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                        opens: 'right'
                    },
                    function(start, end, label) {
                        var startDate = start.format('YYYY-MM-DD');
                        var endDate = end.format('YYYY-MM-DD');

                        // var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        // // alert(csrfToken);

                        // // AJAX request to send the selected dates to the controller
                        // $.ajax({
                        //     url: '/search-emp-details', // Update the URL to match your controller route
                        //     method: 'POST',
                        //     data: {
                        //         startDate: startDate,
                        //         endDate: endDate,
                        //         _token: csrfToken // Ensure CSRF token is included
                        //     },
                        //     success: function(response) {
                        //         // Handle success response if needed
                        //         console.log("Dates sent to controller successfully.");
                        //     },
                        //     error: function(xhr, status, error) {
                        //         // Handle error if any
                        //         console.error("Error sending dates to controller: " + error);
                        //     }
                        // });
                    });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Get the modal element
                var modal = document.getElementById("editModal");

                // Get the form fields within the modal
                var checkInField = document.getElementById("editCheckIn");
                var checkOutField = document.getElementById("editCheckOut");
                var breakStartField = document.getElementById("editBreakStart");
                var breakEndField = document.getElementById("editBreakEnd");

                // Get all edit links
                var editLinks = document.querySelectorAll(".edit-link");

                // Add click event listener to each edit link
                editLinks.forEach(function(link) {
                    link.addEventListener("click", function(event) {
                        event.preventDefault();

                        // Extract data from the clicked link's parent row
                        var row = link.closest("tr");
                        var empId = row.querySelector("td:nth-child(1)").innerText.trim();
                        var checkIn = row.querySelector("td:nth-child(5)").innerText.trim();
                        var checkOut = row.querySelector("td:nth-child(6)").innerText.trim();
                        var breakStart = row.querySelector("td:nth-child(7)").innerText.trim();
                        var breakEnd = row.querySelector("td:nth-child(8)").innerText.trim();

                        // Populate the form fields with the extracted data
                        checkInField.value = checkIn;
                        checkOutField.value = checkOut;
                        breakStartField.value = breakStart;
                        breakEndField.value = breakEnd;

                        // Show the modal
                        $(modal).modal("show");
                    });
                });

                // Handle form submission
                var editForm = document.getElementById("editForm");
                editForm.addEventListener("submit", function(event) {
                    event.preventDefault();
                    // Perform form submission using AJAX or any other method you prefer
                    // You can access form data using editForm.elements
                    // For example:
                    // var formData = new FormData(editForm);
                    // fetch('your-update-url', {
                    //     method: 'POST',
                    //     body: formData
                    // })
                    // .then(response => response.json())
                    // .then(data => {
                    //     console.log('Success:', data);
                    // })
                    // .catch((error) => {
                    //     console.error('Error:', error);
                    // });

                    // Close the modal after submission
                    $(modal).modal("hide");
                });
            });
        </script>
    @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @section('scripts')
        <!-- Required datatable js -->
        <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

        <script src="{{ URL::asset('build/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @endsection
