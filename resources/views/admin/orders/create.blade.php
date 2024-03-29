@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.orders.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
                <label for="customer_name">{{ trans('cruds.order.fields.customer_name') }}*</label>
                <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ old('customer_name', isset($order) ? $order->customer_name : '') }}" required>
                @if($errors->has('customer_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('customer_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.order.fields.customer_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('customer_email') ? 'has-error' : '' }}">
                <label for="customer_email">{{ trans('cruds.order.fields.customer_email') }}</label>
                <input type="email" id="customer_email" name="customer_email" class="form-control" value="{{ old('customer_email', isset($order) ? $order->customer_email : '') }}">
                @if($errors->has('customer_email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('customer_email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.order.fields.customer_email_helper') }}
                </p>
            </div>

            <div class="card">
                <div class="card-header">
                    商品
                </div>

                <div class="card-body">
                    <table class="table" id="products_table">
                        <thead>
                            <tr>
                                <th>商品</th>
                                <th>數量</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="product0">
                                <td>
                                    <select name="products[]" class="form-control">
                                        <option value="">-- 選擇商品 --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} (${{ number_format($product->price, 2) }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantities[]" class="form-control" value="1" />
                                </td>
                            </tr>
                            <tr id="product1"></tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-light pull-left">+ 新增資料</button>
                            <button id='delete_row' class="pull-right btn btn-danger">- 刪除資列</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    let row_number = 1;
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
      $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#product" + (row_number - 1)).html('');
        row_number--;
      }
    });
  });
</script>
@endsection