@extends('admin.layout')

@section('content')
<h2>Platform Settings</h2>
<div class="card" style="max-width: 500px;">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="platform_commission" style="display:block; margin-bottom: 8px; color: var(--text-muted);">Platform Commission (%)</label>
            <input type="number" step="0.1" name="platform_commission" id="platform_commission" class="form-control" 
                value="{{ old('platform_commission', $commission->value ?? 5) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
