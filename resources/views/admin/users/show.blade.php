@extends('layouts.admin')

@section('header', 'User Details')

@section('content')
    @livewire('admin.users.show', ['user' => $user])
@endsection 