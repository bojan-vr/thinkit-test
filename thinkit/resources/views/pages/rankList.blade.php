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
                                <h3 class="mb-0">Ranks List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('ranks.create')}}" class="btn btn-sm btn-primary">Create Rank</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($ranks->isEmpty())
                                    <tr>
                                        <td class="text-center" colspan="5">
                                            No Crew Please Created
                                        </td>
                                    </tr>
                                @endif
                                @foreach($ranks as $rank)
                                    <tr id="rank-{{$rank->id}}">
                                        <th scope="row">
                                            {{$rank->id}}
                                        </th>
                                        <th scope="row">
                                            {{$rank->created_at}}
                                        </th>
                                        <th scope="row">
                                            {{$rank->name}}
                                        </th>
                                        <td>
                                            {{ isset($rank->created_by_user->name) ? $rank->created_by_user->name : '' }}
                                        </td>
                                        <td>
                                            <a href="{{route('ranks.edit', $rank->id)}}" class="btn btn-primary">edit</a>
                                            <a onclick="deleteCrew({{$rank->id}})" class="btn btn-danger">Delete</a>
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
                title: 'Delete Rank?',
                text: "This will delete rank permanantly",
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
                    url: '/ranks/' + $id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        $('#rank-'+$id).remove();
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