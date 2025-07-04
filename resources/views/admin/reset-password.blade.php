@extends('layouts.auth_gate')

@section('content')
    <livewire:admin.reset-password :token="request()->segment(3)" />
@endsection
