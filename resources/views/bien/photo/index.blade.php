@extends('layouts.main.dashboard')
@extends('compenents.navbar')


@extends('compenents.header')
@section('content')

@section('content')
    <div class="table-responsive-sm">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Filename</th>
                <th scope="col">Original Filename</th>
                <th scope="col">Resized Filename</th>
            </tr>
            </thead>
            <tbody>
            @foreach($photos as $photo)
                <tr>
                    <td><img width="200px" height="150px" src="{{asset('images/photos_bien/'.$photo->resized_name.'') }}  "></td>
                    <td>{{ $photo->filename }}</td>
                    <td>{{ $photo->original_name }}</td>
                    <td>{{ $photo->resized_name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@endsection


@section('js-content')

@endsection