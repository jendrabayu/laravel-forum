@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Users ({{ $users->total() }} Results)</h4>
        </div>
        <div class="card-body ">
          <div class="table-responsive table-invoice">
            <table class="table table-striped">
              <tr>
                <th>Avatar</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th class="text-center">Threads</th>
                <th class="text-center">Answers</th>
                <th class="text-center">Comments</th>
              </tr>
              @foreach ($users as $user)
                <tr>
                  <td> <img alt="image" src="{{ Storage::url($user->avatar) }}" class="rounded-circle mr-1" width="50px"
                      height="50px"></td>
                  <td>{{ $user->full_name }}</a></td>
                  <td>{{ $user->username }}</a></td>
                  <td>{{ $user->email }}</td>
                  <td class="text-center">{{ $user->threads->count() }}</td>
                  <td class="text-center">{{ $user->answers->count() }}</td>
                  <td class="text-center">{{ $user->answerComments->count() }}</td>
                </tr>
              @endforeach
            </table>
            {{ $users->links() }}
          </div>
        </div>
      </div>
    </div>
  @endsection
