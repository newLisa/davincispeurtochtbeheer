@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$data['quest']->naam}} Highscores</div>
                <?php $count = 1; ?>
                <table class="table">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Score</th>
                            <th>Markers Completed</th>
                        </tr>
                    </thead>
                    @foreach ($data['highscores'] as $highscore)
                        <tbody>
                            <tr>
                                <th scope="row">{{ $count }}</th>
                                <td>{{ $highscore->user[0]->name }}</td>
                                <td>{{ $highscore->score }}</td>
                                <td>{{ $highscore->markers_completed }}</td>
                            </tr>
                        </tbody>
                        <?php $count++; ?>
                    @endforeach
                </table>


            </div>
        </div>
    </div>
</div>
@endsection
