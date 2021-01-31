@extends('layouts.app')
@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--7">
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('Create Ship') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('notifications.store') }}" autocomplete="off">
                        @csrf
                        
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="ranks">Assign Rank</label>
                                <select class="mul-select form-control" required name="ranks[]" multiple="true">
                                    @foreach($ranks as $rank)
                                        <option value="{{$rank->id}}">{{$rank->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('notification') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-image">{{ __('notification') }}</label>

                                <div class="form-group">
                                    <textarea name="notification"></textarea>
                                </div>
                                @if ($errors->has('notification'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(".mul-select").select2({
            placeholder: "select rank", //placeholder
            tags: true,
            tokenSeparators: ['/',',',';'," "],
        });
        CKEDITOR.replace('notification', {
            filebrowserUploadUrl: "{{route('editor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
