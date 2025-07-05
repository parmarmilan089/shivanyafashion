@extends('admin.layout.page')

@section('content')
  <style>
    .choices__inner {
    min-height: 45px;
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 8px 10px;
    font-size: 14px;
    }

    .choices__placeholder {
    opacity: 0.6;
    font-style: italic;
    color: #6c757d;
    }

    .choices__input {
    margin-bottom: 4px;
    }

    .choices__list--multiple .choices__item {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 4px 8px;
    margin: 3px;
    border-radius: 4px;
    font-size: 13px;
    }

    .choices__list--multiple .choices__item.is-highlighted {
    background-color: #0056b3;
    }
  </style>
  <div class="container-fluid py-4">
    <div class="row">
    <div class="col-12">

      <div class="card">
      <div class="card-header pb-0">
        <h5 class="text-dark">Add New Payment</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.payment.store') }}" method="POST">
        @csrf

        <div class="row">
          <!-- Payment Date -->
          <div class="col-md-6">
          <label for="payment_received_date">Payment Received Date</label>
          <div class="input-group input-group-outline my-2">
            <input type="date" name="payment_received_date" class="form-control"
            value="{{ old('payment_received_date') }}" required>
          </div>
          </div>

          <!-- Amount -->
          <div class="col-md-6">
          <label for="amount">Amount</label>
          <div class="input-group input-group-outline my-2">
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}"
            placeholder="Enter Amount" required>
          </div>
          </div>

          <!-- Delivered Order Sub Order IDs -->
          <div class="col-md-6">
          <label for="delivered_sub_order_ids">Delivered Sub Order IDs <small>(press Enter after
            each)</small></label>
          <div class="input-group input-group-outline my-2">
            <input type="text" id="delivered_sub_order_ids" name="delivered_sub_order_ids"
            value="{{ old('delivered_sub_order_ids') }}" placeholder="Enter Sub Order ID and press Enter" />
          </div>
          </div>

          <!-- Return Charges Order Sub Order IDs -->
          <div class="col-md-6">
          <label for="return_sub_order_ids">Return Charges Sub Order IDs <small>(press Enter after
            each)</small></label>
          <div class="input-group input-group-outline my-2">
            <input type="text" id="return_sub_order_ids" name="return_sub_order_ids"
            value="{{ old('return_sub_order_ids') }}" placeholder="Enter Return Sub Order ID and press Enter" />
          </div>
          </div>

          <!-- Description -->
          <div class="col-md-12">
          <label for="description">Description</label>
          <div class="input-group input-group-outline my-2">
            <textarea name="description" class="form-control" rows="3"
            placeholder="Optional">{{ old('description') }}</textarea>
          </div>
          </div>

          <!-- Submit -->
          <div class="col-md-12 text-end mt-3">
          <button type="submit" class="btn btn-primary">Save Payment</button>
          <a href="{{ route('admin.payment.index') }}" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </div>

        </form>
      </div>
      </div>

    </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    new Choices('#delivered_sub_order_ids', {
      delimiter: ',',
      editItems: true,
      removeItemButton: true,
      duplicateItemsAllowed: false,
      paste: true,
      placeholder: true,
      placeholderValue: 'Enter Sub Order ID and press Enter',
    });
    });
    document.addEventListener('DOMContentLoaded', function () {
    new Choices('#return_sub_order_ids', {
      delimiter: ',',
      editItems: true,
      removeItemButton: true,
      duplicateItemsAllowed: false,
      paste: true,
      placeholder: true,
      placeholderValue: 'Enter Sub Order ID and press Enter',
    });
    });
  </script>
@endsection