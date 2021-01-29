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
                                <h3 class="mb-0">Ships List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('ships.create')}}" class="btn btn-sm btn-primary">Create Ship</a>
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
                              @foreach($ships as $ship)
                                <tr id="ship-{{$ship->id}}">
                                    <th scope="row">
                                        {{$ship->id}}
                                    </th>
                                    <th scope="row">
                                        {{$ship->serial_number}}
                                    </th>
                                    <td>  
                                        {{$ship->name}}
                                    </td>
                                    <td>
                                        <img src={{$ship->image}} height="100px">
                                    </td>
                                    <td>  
                                        {{ isset($ship->created_by_user->name) ? $ship->created_by_user->name : '' }}
                                    </td>
                                    <td>
                                        <a href="{{route('ships.show', $ship->id)}}" class="btn btn-primary">details</a>
                                        <a href="{{route('ships.edit', $ship->id)}}" class="btn btn-primary">edit</a>
                                        <a onclick="deleteShip({{$ship->id}})" class="btn btn-danger">delete</a>
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
                    url: '/ships/' + $id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        $('#ship-'+$id).remove();
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