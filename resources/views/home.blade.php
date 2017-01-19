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
                            <th class="col-md-2">Name</th>
                            <th class="col-md-1">Course</th>
                            <th class="col-md-7">Info</th>
                            <th class="col-md-2">Actions</th>
                        </tr>
                        @foreach ($quests as $quest)
                            @if (!$quest->is_deleted)
                                <tr>
                                    <td>{{ $quest->naam }}</td>
                                    <td>{{ $quest->opleiding }}</td>
                                    <td>{{ $quest->informatie }}</td>
                                    <td>
                                        <a title="Edit" href="{{ url('/quests/edit/' . $quest->id) }}" class="fa fa-pencil fa-lg" aria-hidden="true">&nbsp</a>  
                                        <a title="Delete" href="{{ url('/quests/delete/' . $quest->id) }}" class="fa fa-trash fa-lg" aria-hidden="true">&nbsp</a>  
                                        <a title="View" href="#" class="fa fa-eye fa-lg" aria-hidden="true"></a>
                                         <a title="Generate QR" href="{{ url('/qr-pdf/' . $quest->id)}}" class="fa fa-qrcode fa-lg" aria-hidden="true"></a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    <button class="btn btn-secondary">View All</button>
                    <a href="{{ url('/quests/add') }}" class="btn btn-primary">Add</a>
                </div>



                <div class="panel-body">
                    <h2>Archived Quests</h2>
                    <table class="table">
                        <tr>
                            <th class="col-md-2">Name</th>
                            <th class="col-md-1">Course</th>
                            <th class="col-md-7">Info</th>
                            <th class="col-md-2">Actions</th>
                        </tr>

                        @foreach ($quests as $quest)
                            @if ($quest->is_deleted)
                                <tr>
                                    <td>{{ $quest->naam }}</td>
                                    <td>{{ $quest->opleiding }}</td>
                                    <td>{{ $quest->informatie }}</td>
                                    <td><a title="Restore" href="{{ url('/quests/restore/' . $quest->id) }}" alt="test" class="fa fa-repeat fa-lg" aria-hidden="true"></a></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    <button class="btn btn-secondary">View All</button>
                </div>



            </div>
        </div>
    </div>
</div>
@endsection
