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
                                    <th scope="col">Surname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Ship</th>
                                    <th scope="col">Rank</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($crew->isEmpty())
                                    <tr>
                                        <td class="text-center" colspan="5">
                                            No Crew Please Created
                                        </td>
                                    </tr>
                                @endif
                                @foreach($crew as $member)
                                    <tr id="crew-{{$member->id}}">
                                        <th scope="row">
                                            {{$member->id}}
                                        </th>
                                        <th scope="row">
                                            {{$member->name}}
                                        </th>
                                        <th scope="row">
                                            {{$member->surname}}
                                        </th>
                                        <td>  
                                            {{$member->email}}
                                        </td>
                                        <td>
                                            {{ isset($member->ship->name) ? $member->ship->name : '' }}
                                        </td>
                                        <td>
                                            {{ isset($member->rank->name) ? $member->rank->name : '' }}
                                        </td>
                                        <td>
                                            {{ isset($member->created_by_user->name) ? $member->created_by_user->name : '' }}
                                        </td>
                                        <td>
                                            <a href="{{route('crew.edit', $member->id)}}" class="btn btn-primary">edit</a>
                                            <a onclick="deleteCrew({{$member->id}})" class="btn btn-danger">Delete</a>
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
                title: 'Delete Crew?',
                text: "This will delete crew member permanantly",
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
                    url: '/crew/' + $id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        $('#crew-'+$id).remove();
                        swal("Success!", "Crew has been removed!", "success");
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