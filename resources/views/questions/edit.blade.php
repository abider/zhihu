@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ lang('Edit Question') }}</div>

                <div class="panel-body">
                    <form action="{{ route('questions.update', $question->id) }}" method="post">
                        {!! csrf_field() !!}
                        {!! method_field('PATCH') !!}

                        <div class="form-group">
                            <label for="title">{{ lang('Title') }}</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $question->title }}" required>
                        </div>

                        <div class="form-group">
                            <label for="body">{{ lang('Body') }}</label>
                            <textarea name="body" id="body" cols="30" rows="10" class="form-control" required>
                                {{ $question->body }}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">{{ lang('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
