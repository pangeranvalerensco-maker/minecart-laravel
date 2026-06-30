@extends('admin.layout')

@section('content')
<h2>Withdrawals</h2>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Seller</th>
                <th>Amount</th>
                <th>Bank Details</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $withdrawal)
            <tr>
                <td>{{ $withdrawal->user->name }}</td>
                <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                <td>
                    {{ $withdrawal->bank_name }}<br>
                    <small>{{ $withdrawal->account_number }} - {{ $withdrawal->account_name }}</small>
                </td>
                <td>
                    <span class="badge" style="
                        @if($withdrawal->status === 'approved') background: var(--success); color: white;
                        @elseif($withdrawal->status === 'rejected') background: var(--danger); color: white;
                        @else background: #f59e0b; color: white; @endif
                    ">
                        {{ ucfirst($withdrawal->status) }}
                    </span>
                </td>
                <td>
                    @if($withdrawal->status === 'pending')
                    <div style="display: flex; gap: 5px;">
                        <form action="{{ route('admin.withdrawals.process', $withdrawal->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('admin.withdrawals.process', $withdrawal->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </div>
                    @else
                        Processed at {{ $withdrawal->processed_at }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px;">
        {{ $withdrawals->links() }}
    </div>
</div>
@endsection
