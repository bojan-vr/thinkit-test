@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
@endpush
@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image mt-5">
                            <a href="#">
                                <img src="{{$ship->image}}" height="120px">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>
                <div class="card-body pt-0 pt-md-4 mt-4">
                    <div class="text-center">
                        <h3>
                            {{ $ship->name }}<span class="font-weight-light"></span>
                        </h3>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>serial number: {{$ship->serial_number}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>created: {{$ship->created_at}}
                        </div>
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
                                    <th scope="col">Rank</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ship->crew as $crew)
                                <tr id="crew-{{$crew->id}}">
                                  <th scope="row">
                                      {{$crew->id}}
                                  </th>
                                  <th scope="row">
                                      {{$crew->name}}
                                  </th>
                                  <td>  
                                      {{$crew->email}}
                                  </td>
                                  <td>
                                      {{ isset($crew->rank->name) ? $crew->rank->name : '' }}
                                  </td>
                                  <td>
                                    <a onclick="deleteCrew({{$crew->id}})" class="btn btn-danger">remove crew</a>
                                  </td>
                                </tr>
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
        function deleteCrew($id) {
            swal({
                title: 'Remove Crew?',
                text: "This will delete crew member from ship",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Yes, remove!',
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
                    url: '/ships/remove_crew/' + $id,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        $('#crew-'+$id).remove();
                    },
                    error: function (response) {
                        alert(response);
                    }
                });

            }, function (dismiss) {
                if (dismiss === 'cancel') {
                }
            })
        };
    </script>
@endpush