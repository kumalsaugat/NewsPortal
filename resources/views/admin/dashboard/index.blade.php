@extends('layouts.app')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ Breadcrumbs::render('dashboard') }}</h3>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->


    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row"> <!--begin::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <div class="row">
                                <div class="col-6">
                                    <h3 id="dynamic-count">{{ $totalCategories }}</h3>
                                    <p id="dynamic-label">Total Category</p>
                                </div>
                                <div class="col-6 text-end" style="z-index: +999;">
                                    <a class="icon" href="javascript:void(0)" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateCounter('Total Category', {{ $totalCategories }})">Total
                                                Category</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateCounter('Total Active', {{ $totalActiveCategories }})">Total
                                                Active Category</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateCounter('Total Inactive', {{ $totalInactiveCategories }})">Total
                                                Inactive Category</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" fill="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
                        </svg>
                        <a href="{{ route('news-category.index') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div> <!--end::Small Box Widget 1-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <div class="row">
                                <div class="col-6">
                                    <h3 id="dynamic-count-news">{{ $totalNews }}</h3>
                                    <p id="dynamic-label-news">Total News</p>
                                </div>
                                <div class="col-6 text-end" style="z-index: +999;">
                                    <a class="icon" href="javascript:void(0)" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateCounterNews('Total News', {{ $totalNews }})">Total
                                                News</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateCounterNews('Total Active', {{ $totalActive }})">Total
                                                Active News</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateCounterNews('Total Inactive', {{ $totalInactive }})">Total
                                                Inactive News</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" fill="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M4 3h16a1 1 0 011 1v16a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 011-1.732V4a1 1 0 011-1zm15 2H5v14h14V5zM7 7h8v2H7V7zm0 4h8v2H7v-2zm0 4h4v2H7v-2z" />
                        </svg>
                        <a href="{{ route('news.index') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div> <!--end::Small Box Widget 2-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <div class="row">
                                <div class="col-6">
                                    <h3 id="dynamic-count-news">{{ $totalUsers }}</h3>
                                    <p id="dynamic-label-news">Total Users</p>
                                </div>
                            </div>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg>
                        <a href="{{ route('user.index') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div> <!--end::Small Box Widget 2-->
                </div> <!--end::Col-->
            </div> <!--end::Row--> <!--begin::Row-->
        </div> <!--end::Container-->
    </div>

    <script>
        function updateCounter(label, count) {
            // Update the number and label
            document.getElementById('dynamic-count').textContent = count;
            document.getElementById('dynamic-label').textContent = label;
        }

        function updateCounterNews(label, count) {
            // Update the number and label
            document.getElementById('dynamic-count-news').textContent = count;
            document.getElementById('dynamic-label-news').textContent = label;
        }
    </script>
@endsection
