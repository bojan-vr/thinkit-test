@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
@endpush
@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="text-center mt-4">
                        <h4>Noptification Data</h4>
                        <div class="h5 ">
                            <i class="ni business_briefcase-24 mr-2"></i>Name: {{$notification->name}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>created: {{$notification->created_at}}
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4 mt-4">
                        <h4>Noptification Preview</h4>
                        <iframe class="preview" srcdoc="{{$notification->content}}">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Crew List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('crew.create')}}" class="btn btn-sm btn-primary">Create Crew</a>
                                <a onclick="sendMail({{$notification->id}})" class="btn btn-danger">Send Mail</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notification->ranks as $rank)
                                    <tr>
                                        <td colspan="4" class='rank-row'>
                                            RANK: {{$rank->name}}
                                        </td>
                                    </tr>
                                    @foreach($rank->crew as $crew)
                                        <tr>
                                            <td>{{$crew->id}}</td>
                                            <td>{{$crew->name}}</td>
                                            <td>{{$crew->surname}}</td>
                                            <td>{{$crew->email}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
    <script>
        function sendMail($id) {
            swal({
                title: 'Send Mail?',
                text: "Are you sure you want to send mail?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success mr-5',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function () {
                let data = {
                    id: $id,
                    _token: "{{csrf_token()}}",
                };
                $.ajax({
                    url: '/notifications/send_mail/' + $id,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        swal("Success!", "Email Has been sent!", "success");
                    },
                    
                });

            }, function (dismiss) {
                if (dismiss === 'cancel') {
                }
            })
        };
    </script>
@endpush