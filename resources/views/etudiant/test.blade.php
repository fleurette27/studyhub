@extends('layouts.etudiant')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @foreach($epreuves as $epreuve)
                <div class="card-header">{{$epreuve->nomEp}}</div>

                <div class="card-body">
                    @if(session('status'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('etudiant.test.store') }}">
                        @csrf
                        <div class="card mb-3">
                            <div class="card-body">
                                @foreach($epreuve->questions as $question)
                                <div class="card @if(!$loop->last)mb-3 @endif">
                                    <div class="card-header">{{ $question->question_text }}</div>

                                    <div class="card-body">
                                        @foreach($question->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option-{{ $option->id }}" value="{{ $option->id }}" @if(old("answers.$question->id") == $option->id) checked @endif>
                                            <label class="form-check-label" for="option-{{ $option->id }}">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                        @endforeach

                                        @if($errors->has("answers.$question->id"))
                                        <span style="margin-top: .25rem; font-size: 80%; color: #e3342f;" role="alert">
                                            <strong>{{ $errors->first("answers.$question->id") }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                        @if($epreuves->isNotEmpty() && \Carbon\Carbon::parse($epreuves->first()->dateEp)->isToday() && now()->between($epreuves->first()->heurDeb, $epreuves->first()->heurFin))
                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" disabled>
                                    Vous ne pouvez pas soumettre ,fin de l'examen.
                                </button>
                            </div>
                        </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
