@extends('admin.layout.page')

@section('contect')
  <div class="container-fluid py-4">
    <h3 class="text-dark">Payment List</h3>

    <!-- Payment Table -->
    <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
      <table id="payment-table" class="table align-items-center mb-0">
        <thead>
        <tr>
          <th>#</th>
          <th>Received Date</th>
          <th>Amount</th>
          <th>Delivered sub order ids</th>
          <th>Return sub order ids</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($payments as $payment)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ \Carbon\Carbon::parse($payment->payment_received_date)->format('d M Y') }}</td>
        <td>₹{{ number_format($payment->amount, 2) }}</td>
        <td>
        @php
        $deliveredIds = json_decode($payment->delivered_sub_order_ids, true) ?? [];
      @endphp

        @foreach(array_slice($deliveredIds, 0, 3) as $subOrderId)
        <span class="badge bg-primary mb-1">{{ $subOrderId }}</span>
      @endforeach

        @if(count($deliveredIds) > 3)
        <span class="badge bg-secondary mb-1" data-bs-toggle="tooltip"
        title="{{ implode(', ', array_slice($deliveredIds, 3)) }}">
        +{{ count($deliveredIds) - 3 }} more
        </span>
      @endif
        </td>

        <td>
        @php
        $returnIds = json_decode($payment->return_sub_order_ids, true) ?? [];
      @endphp

        @foreach(array_slice($returnIds, 0, 3) as $subOrderId)
        <span class="badge bg-primary mb-1">{{ $subOrderId }}</span>
      @endforeach

        @if(count($returnIds) > 3)
        <span class="badge bg-secondary mb-1" data-bs-toggle="tooltip"
        title="{{ implode(', ', array_slice($returnIds, 3)) }}">
        +{{ count($returnIds) - 3 }} more
        </span>
      @endif
        </td>
        <td>{{ Str::limit($payment->description, 60) }}</td>
        <td>
        <div class="d-flex gap-1">
          <a href="{{ route('admin.payment.show', $payment->id) }}" class="btn btn-sm btn-info">View</a>
          <form action="{{ route('admin.payment.destroy', $payment->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Delete this payment?')"
          class="btn btn-sm btn-danger">Delete</button>
          </form>
        </div>
        </td>
        </tr>
      @endforeach
        @if($payments->isEmpty())
      <tr>
        <td colspan="6" class="text-center text-muted">No payments found.</td>
      </tr>
      @endif
        </tbody>
      </table>
      </div>
    </div>
    </div>
  </div>
@endsection
@push('scripts')

@endpush