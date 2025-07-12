@extends('layouts.admin')

@section('header', 'Edit User')

@section('content')
    @livewire('admin.users.edit', ['user' => $user])
@endsection 