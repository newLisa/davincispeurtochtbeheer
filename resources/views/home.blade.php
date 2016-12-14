@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Active Quests</h2>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Info</th>
                            <th>Actions</th>
                        </tr>

                        @foreach ($quests as $quest)
                            <tr>
                                <td>{{ $quest->naam }}</td>
                                <td>{{ $quest->opleiding }}</td>
                                <td>{{ $quest->informatie }}</td>
                                <td><a href="{{ url('/quests/edit/' . $quest->id) }}" class="fa fa-pencil" aria-hidden="true"></a> <a href="{{ url('/quests/delete/' . $quest->id) }}" class="fa fa-trash" aria-hidden="true"></a></td>
                            </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-secondary">View All</button>
                    <a href="{{ url('/quests/add') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
