@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
@endpush
@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Notifications List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('notifications.create')}}" class="btn btn-primary">Create Notification</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Serial Number</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($notifications->isEmpty())
                                    <tr>
                                        <td class="text-center" colspan="5">
                                            No Notifications Pleace Create
                                        </td>
                                    </tr>
                                @endif
                                @foreach($notifications as $notification)
                                    <tr id="notification-{{$notification->id}}">
                                        <th scope="row">
                                            {{$notification->id}}
                                        </th>
                                        <th scope="row">
                                            {{$notification->created_at}}
                                        </th>
                                        <td>  
                                            {{$notification->name}}
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td> 
                                            {{$notification->created_by_user->name}}
                                        </td>
                                        <td>
                                            <a href="{{route('notifications.show', $notification->id)}}" class="btn btn-primary">details</a>
                                            <a onclick="deleteShip({{$notification->id}})" class="btn btn-danger">delete</a>
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
        function deleteShip($id) {
            swal({
                title: 'Delete Ship?',
                text: "This will delete Ship permanantly",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Yes, delete!',
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
                    url: '/notifications/' + $id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        $('#notification-'+$id).remove();
                    },
                    error: function (response) {
                    }
                });

            }, function (dismiss) {
                if (dismiss === 'cancel') {
                }
            })
        };
    </script>
@endpush