@extends('layouts.admin')

@section('header', 'Edit Role')

@section('content')
    @livewire('admin.roles.edit', ['role' => $role])
@endsection 