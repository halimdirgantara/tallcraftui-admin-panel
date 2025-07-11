@extends('layouts.admin')

@section('header', 'Role Details')

@section('content')
    @livewire('admin.roles.show', ['role' => $role])
@endsection 