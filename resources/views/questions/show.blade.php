@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card form-group">
                <div class="card-block">
                    <h3 class="card-title">
                        {{ $question->title }}
                    </h3>
                    <p class="card-text">
                        {{ $question->body }}
                    </p>
                </div>
                <div class="card-footer text-muted">
                    提问于 {{ $question->created_at->diffForHumans() }}
                    <comments type="question"
                              :id="{{ $question->id }}"
                              url="{{ route('questions.comments', $question->id) }}">
                    </comments>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card form-group text-center">
                <div class="card-block">
                    <h5 class="text-muted">
                        关注者
                    </h5>
                    <h2>{{ $question->followers_count }}</h2>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-6">
                            <question-follow
                                    url="{{ route('questions.follow', $question->id) }}"
                                    :followed="{!! auth()->check() && auth()->user()->isFollowedQuestion($question->id) ? 'true' : 'false' !!}">
                            </question-follow>
                        </div>
                        <div class="col-6">
                            <answer-write url="{{ route('answers.store', $question->id) }}"
                                          title="{{ $question->title }}">
                            </answer-write>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            @foreach ($question->answers as $answer)
                <div class="card form-group">
                    <div class="card-header">
                        <img width="40" class="img-thumbnail rounded-circle" src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}">
                        {{ $answer->user->name }} 发表于 {{ $answer->created_at->diffForHumans() }}
                    </div>
                    <div class="card-block">
                        {{ $answer->body }}
                    </div>
                    <div class="card-footer">
                        <answer-vote url="{{ route('answers.vote', $answer->id) }}"
                                     :vote-count="{{ $answer->votes_count }}"
                                     :voted="{{ auth()->check() && auth()->user()->isVoteAnswer($answer->id) ? 'true' : 'false' }}">
                        </answer-vote>
                        <comments type="answer"
                                  :id="{{ $answer->id }}"
                                  url="{{ route('answers.comments', $answer->id) }}">
                        </comments>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card form-group">
                        <div class="card-header">
                            作者
                        </div>
                        <div class="card-block text-center">
                            <img class="img-thumbnail rounded-circle" width="100" src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">
                            <h3>{{ $question->user->name }}</h3>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-muted">
                                        提问
                                    </p>
                                    <h5>
                                        {{ $question->user->questions()->count() }}
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted">
                                        回答
                                    </p>
                                    <h5>
                                        {{ $question->user->answers()->count() }}
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted">
                                        关注者
                                    </p>
                                    <h5>
                                        {{ $question->user->userFolloweds()->count() }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @if (auth()->check())
                            @if ( ! auth()->user()->isAuthor($question->user_id))
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <div class="col-6">
                                            <user-follow
                                                    url="{{ route('users.follow', $question->user_id) }}"
                                                    :followed="{!! auth()->check() && auth()->user()->isFollowedUser($question->user_id) ? 'true' : 'false' !!}">
                                            </user-follow>
                                        </div>
                                        <div class="col-6">
                                            <send-message url="{{ route('users.send.message', $question->user_id) }}"
                                                          name="{{ $question->user->name }}">
                                            </send-message>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                @if (auth()->check() && auth()->user()->isAuthor($question))
                    <div class="col-md-12">
                        <div class="card form-group">
                            <div class="card-header">
                                操作
                            </div>

                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-default btn-block">
                                            {{ lang('Edit Question') }}
                                        </a>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-danger btn-block">
                                                {{ lang('Delete Question') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{--<div class="col-md-12">--}}
                    {{--<div class="card">--}}
                        {{--<div class="card-header">--}}
                            {{--{{ lang('Topic') }}--}}
                        {{--</div>--}}
                        {{--<div class="card-block">--}}
                            {{--<ul class="list-group">--}}
                                {{--@foreach ($question->topics as $topic)--}}
                                {{--<li class="list-group-item">--}}
                                    {{--{{ $topic->name }}--}}
                                    {{--<span class="badge">{{ $topic->questions_count }}</span>--}}
                                {{--</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>

        </div>
    </div>
@endsection
