@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Settings </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Setting</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Settings</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-2">
                            <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4"
                                        role="tab" aria-controls="home" aria-selected="true">General Setting</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab"
                                        aria-controls="contact" aria-selected="false">Footer Setting</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab5" data-toggle="tab" href="#contact5" role="tab"
                                        aria-controls="contact" aria-selected="false">API Setting</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab6" data-toggle="tab" href="#contact6" role="tab"
                                        aria-controls="contact" aria-selected="false">Appearance </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-10">
                            <div class="tab-content tab-bordered no-padding" id="myTab2Content">
                                <div class="tab-pane  fade show active" id="home4" role="tabpanel"
                                    aria-labelledby="home-tab4">
                                    @include('admin.system-setting.cards.general-setting')
                                </div>

                                <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                                    @include('admin.system-setting.cards.footer-setting')
                                </div>

                                <div class="tab-pane fade" id="contact5" role="tabpanel" aria-labelledby="contact-tab5">
                                    @include('admin.system-setting.cards.api-setting')
                                </div>
                                <div class="tab-pane fade" id="contact6" role="tabpanel" aria-labelledby="contact-tab6">
                                    @include('admin.system-setting.cards.appearance')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
