@extends('layouts.master')
@section('title')
    {{$title}}
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
{{$title}}
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">



                        <div class="row d-flex justify-content-between mb-5">
                            <h4 class="card-title" style="width:50%">{{$title}}</h4>
                            <div style="width: 13%">


                                 @if (auth()->user()->user_type == 'admin')
                                     <a href="/add-new-client" class="reblateBtn w-75" style="padding:10px;text-align:center"><span
                                        style="width: 15px; height: 15px; margin-right: 5px;"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                        </svg></span> Add New</a>
                                 @endif

                                 @if (auth()->user()->user_type == 'employee' || auth()->user()->user_type == 'manager')
                                                    @if (Session::has('clients_access'))
                                                        @php
                                                            $clients_access = Session::get('clients_access');
                                                            // Convert to an array if it's a single value
                                                            if (!is_array($clients_access)) {
                                                                $clients_access = explode(',', $clients_access);
                                                                // Remove any empty elements resulting from the explode function
                                                                $clients_access = array_filter($clients_access);
                                                            }
                                                        @endphp
                                                   @endif

                                                   @if (is_array($clients_access) && in_array('all', $clients_access) || in_array('create', $clients_access) )
                                                        <a href="/add-new-client" class="reblateBtn w-75" style="padding:10px;text-align:center"><span
                                        style="width: 15px; height: 15px; margin-right: 5px;"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                        </svg></span> Add New</a>
                                                   @endif

                                @endif

                            </div>
                        </div>
                        {{-- <p class="card-title-desc">The Buttons extension for DataTables
                            provides a common set of options, API methods and styling to display
                            buttons on a page that will interact with a DataTable. The core library
                            provides the based framework upon which plug-ins can built.
                        </p> --}}

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th> ID</th>
                                    <th>  Name</th>
                                    <th> Project</th>
                                    <th> Project Type</th>
                                    <th> Client Email</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>

                            <tbody id="table-body">
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($rec as $client)
                                    <tr>

                                        <td>{{ $count }}</td>
                                        {{-- <td>{{ ( $emp->Emp_Code < 10) ? '00'.$emp->Emp_Code : $emp->Emp_Code }}sols</td> --}}
                                        <td><a href="{{ Route('view-client-detail', $client->client_id) }}">{{ $client->client_name }} </a></td>
                                        <td>{{ $client->project_name }} </a></td>
                                        <td>{{ $client->project_type }} </a></td>
                                        <td>{{ $client->client_email }}</td>

                                        <td class="text-nowrap">
                                            <div class="d-flex gap-3">
                                                @if (auth()->user()->user_type == 'employee' || auth()->user()->user_type == 'manager')
                                                    @if (Session::has('clients_access'))
                                                        @php
                                                            $clients_access = Session::get('clients_access');
                                                            // Convert to an array if it's a single value
                                                            if (!is_array($clients_access)) {
                                                                $clients_access = explode(',', $clients_access);
                                                                // Remove any empty elements resulting from the explode function
                                                                $clients_access = array_filter($clients_access);
                                                            }
                                                        @endphp
                                                        {{-- update --}}
                                                        @if (is_array($clients_access) && in_array('update', $clients_access) || in_array('all', $clients_access) )
                                                            <a href="{{ Route('update_client', $client->client_id)}}" data-toggle="tooltip" class="btn btn-success btn-sm"
                                                                data-original-title="Edit">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>

                                                            @elseif (is_array($clients_access) &&   in_array('all', $clients_access) || in_array('delete', $clients_access))
                                                             </a>
                                                                <a href="javascript:void()" onclick="deleteClient({{ $client->id }})" class="btn btn-danger btn-sm"
                                                                data-toggle="tooltip" data-original-title="Close">
                                                                <i class="mdi mdi-delete"></i>
                                                            </a>


                                                            @else
                                                            no action allowed
                                                        @endif

                                                    @endif
                                                    @else
                                                    <a href="{{ Route('update_client', $client->client_id)}}" data-toggle="tooltip" class="btn btn-success btn-sm"
                                                        data-original-title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                        <a href="javascript:void()" onclick="deleteClient({{ $client->id }})" class="btn btn-danger btn-sm"
                                                        data-toggle="tooltip" data-original-title="Close">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                               @endif
                                            </div>
                                        </td>
                                        @php $count++;  @endphp
                                    </tr>
                                @endforeach
                            </tbody>



                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <script>
            // Function to confirm deletion with SweetAlert
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'The Client would be removed from the database!',
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
                            url: '/delete-client/'+id,
                            method: 'GET', // Use the DELETE HTTP method
                            success: function() {
                                // Provide user feedback
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'The Client has been deleted.',
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
                                    text: 'An error occurred while deleting the client!',
                                    icon: 'error'
                                });
                            }
                        });

                    }
                });
            }

            function deleteClient(id) {
                confirmDelete(id);
            }

            $(document).ready(function() {
                $('#datatable-buttons').DataTable({
                    dom: "<'container-fluid'" +
                        "<'row'" +
                        "<'col-md-8'l>" +
                        "<'col-md-4 text-right'f>" +
                        ">" +
                        "<'row dt-table'" +
                        "<'col-md-12'tr>" +
                        ">" +
                        "<'row'" +
                        "<'col-md-7'i>" +
                        "<'col-md-5 text-right'p>" +
                        ">" +
                        ">",
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    buttons: [
                        'excel', 'print'
                    ],

                });
            });

        </script>
    @endsection
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
        {{-- <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script> --}}
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
