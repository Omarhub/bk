@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.promotion.cart-rule') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.promotion.cart-rule') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.cart-rule.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.promotion.add-cart-rule') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('cartRuleGrid','Webkul\Admin\DataGrids\CartRuleDataGrid')
            {!! $cartRuleGrid->render() !!}
        </div>
    </div>
@endsection