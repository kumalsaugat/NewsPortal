@extends('layouts.app')

@section('content')

    <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row g-4"> <!--begin::Col-->

                <div class="col-md-12"> <!--begin::Quick Example-->
                    <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Create News Category</div>
                        </div> <!--end::Header--> <!--begin::Form-->
                        <form> <!--begin::Body-->
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <div id="emailHelp" class="form-text">
                                        We'll never share your email with anyone else.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="inputGroupFile02">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>

                                <div class="mb-3">
                                    <label for="state" class="form-label">State:</label>
                                    <select class="form-select" id="state">
                                        <option selected disabled value="">Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>


                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div> <!--end::Body--> <!--begin::Footer-->
                            <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
                        </form> <!--end::Form-->
                    </div> <!--end::Quick Example--> <!--begin::Input Group-->


                </div> <!--end::Col--> <!--begin::Col-->


            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->





@endsection

