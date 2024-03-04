@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('page-title')
    {{ $title }}
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">update your info!</p>
                        <br>
                        <h4>Personal Details
                            <hr>
                        </h4>


                        <div class="form-floating mb-3">
                            @isset($emp_data->Emp_Image)

                                <a href="{{ asset($emp_data->Emp_Image) }}" target="_blank">
                                    <img src="{{ asset($emp_data->Emp_Image) }}" style="width:150px;height:150px">
                                </a>
                            @endisset

                        </div>


                        <form method="post" action="/update-emp-info" enctype="multipart/form-data">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" id="close-now">
                                    {{ session('success') }}
                                    <a type="button" onclick="hideNow()" class="close" data-dismiss="alert"
                                        aria-label="Close" style="float: right;">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                            @endif


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingFirstnameInput"
                                            type="text" placeholder="Employee Name" name="employee_name"
                                            value="{{ isset($emp_data->Emp_Full_Name) ? $emp_data->Emp_Full_Name : old('employee_name') }}" >

                                        <label for="">Full Name <span class="text-danger">*</span></label>
                                        @error('employee_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" placeholder="0333-3333333" type="tel"
                                            name="employee_phone"
                                            value="{{ isset($emp_data->Emp_Phone) ? $emp_data->Emp_Phone : old('employee_phone') }}">
                                        <label for="">Phone # <span class="text-danger">*</span></label>
                                        @error('employee_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" placeholder="employee email"
                                        value="{{ isset(auth()->user()->emp_email) ? auth()->user()->emp_email : '' }}"
                                            type="email" name="employee_email" disabled>
                                        @error('employee_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Email address <span class="text-danger">*</span></label>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <textarea name="employee_address" placeholder="Employee Address" class="form-control">{{ isset($emp_data->Emp_Address) ? $emp_data->Emp_Address : old('employee_address') }}</textarea>
                                        @error('employee_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Home address <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">

                                        <input class="form-control" type="file" name="employee_img" accept="image/*">
                                        @error('employee_img')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Image </label>
                                    </div>
                                </div>
                            </div>



                            {{-- company details
                            <br>
                            <h4>Company Details
                                <hr>
                            </h4> --}}

                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control " placeholder="Employee code: 200sols"
                                            value="{{ isset(auth()->user()->emp_code) ? auth()->user()->emp_code : '' }}"
                                            type="text" name="employee_code" disabled>

                                        <label for="">Emp Code <span class="text-danger">*</span></label>
                                        @error('employee_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control " placeholder="department"
                                            value="{{ isset($emp_data->department) ? $emp_data->department : old('employee_department') }}"
                                            type="text" name="employee_department">
                                        <label for="">Emp Department <span class="text-danger">*</span></label>
                                        @error('employee_department')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" placeholder="Employee Designation"
                                            name="employee_designation"
                                            value="{{ isset($emp_data->Emp_Designation) ? $emp_data->Emp_Designation : old('employee_designation') }}">
                                        @error('employee_designation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <label for="">Emp Designation <span class="text-danger">*</span></label>

                                    </div>
                                </div>
                                @if (!isset($emp_data->Emp_Shift_Time))
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-control" name="employee_shift_time" id="">
                                                <option value="" selected disabled>Select Time Shift</option>
                                                <option value="Morning"
                                                    {{ old('employee_shift_time') === 'Morning' ? 'selected' : '' }}>
                                                    Morning Shift</option>
                                                <option value="Night"
                                                    {{ old('employee_shift_time') === 'Morning' ? 'selected' : '' }}>Night
                                                    Shift</option>
                                            </select>
                                            @error('employee_shift_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <label for="">Emp Shift Time <span
                                                    class="text-danger">*</span></label>

                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                            value="{{ isset($emp_data->Emp_Joining_Date) ? $emp_data->Emp_Joining_Date : old('employee_joining_date') }}"
                                            placeholder="Employee Joining Date" name="employee_joining_date"
                                            type="date">
                                        @error('employee_joining_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Emp Joining Date <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- company details --}}
                            <br>
                            <h4>
                                Emergency Contact Details
                                <hr>
                            </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control " placeholder="Employee code: 200sols"
                                            value="{{ isset($emp_data->Emp_Relation) ? $emp_data->Emp_Relation : old('employee_relation') }}"
                                            type="text" name="employee_relation">
                                        @error('employee_relation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Relation <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control " placeholder="department"
                                            value="{{ isset($emp_data->Emp_Relation_Name) ? $emp_data->Emp_Relation_Name : old('employee_relative_name') }}"
                                            type="text" name="employee_relative_name">

                                        @error('employee_relative_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Name <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                            value="{{ isset($emp_data->Emp_Relation_Phone) ? $emp_data->Emp_Relation_Phone : old('employee_relative_phone_num') }}"
                                            placeholder="0333-3333333" name="employee_relative_phone_num" type="tel">
                                        @error('employee_relative_phone_num')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="">Phone # <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <textarea name="employee_relative_address" placeholder="Employee Address" class="form-control">{{ isset($emp_data->Emp_Relation_Address) ? $emp_data->Emp_Relation_Address : old('employee_relative_address') }}</textarea>
                                        @error('employee_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for=""> Address <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            {{-- company details --}}
                            <br>
                            <h4>
                                Back Account Details
                                <hr>
                            </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                            value="{{ isset($emp_data->Emp_Bank_Name) ? $emp_data->Emp_Bank_Name : old('employee_bank_name') }}"
                                            placeholder="0333-3333333" name="employee_bank_name" type="text">

                                        <label for="">Bank Name </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                            value="{{ isset($emp_data->Emp_Bank_IBAN) ? $emp_data->Emp_Bank_IBAN : old('employee_bank_iban') }}"
                                            placeholder="0333-3333333" name="employee_bank_iban" type="text">

                                        <label for="">Bank IBAN # </label>
                                    </div>
                                </div>
                            </div>




                            <div>
                                <button type="submit" class="btn btn-primary  w-md"
                                    style="background-color: #14213D ; border-color: #fff;">{{ $btn_text }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <script>
            function hideNow() {
                var divElement = document.getElementById('close-now');
                divElement.style.display = 'none';
            }
        </script>
    @endsection
    @section('scripts')
        <!-- bs custom file input plugin -->
        <script src="{{ URL::asset('build/libs/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

        <script src="{{ URL::asset('build/js/pages/form-element.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection