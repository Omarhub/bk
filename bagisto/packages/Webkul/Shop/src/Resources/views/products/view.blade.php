@extends('shop::layouts.master')

@section('page_title')
    {{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
@stop

@section('seo')
    <meta name="description" content="{{ trim($product->meta_description) != "" ? $product->meta_description : str_limit(strip_tags($product->description), 120, '') }}"/>
    <meta name="keywords" content="{{ $product->meta_keywords }}"/>
@stop

@section('content-wrapper')

    {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

    <section class="product-detail">

        <div class="layouter">
            <product-view>
                <div class="form-container">
                    @csrf()

                    <input type="hidden" name="product" value="{{ $product->product_id }}">

                    @include ('shop::products.view.gallery')

                    <div class="details">

                        <div class="product-heading">
                            <span>{{ $product->name }}</span>
                        </div>

                        @include ('shop::products.review', ['product' => $product])

                        @include ('shop::products.price', ['product' => $product])

                        @include ('shop::products.view.stock', ['product' => $product])

                        {!! view_render_event('bagisto.shop.products.view.short_description.before', ['product' => $product]) !!}

                        <div class="description">
                            {!! $product->short_description !!}
                        </div>

                        {!! view_render_event('bagisto.shop.products.view.short_description.after', ['product' => $product]) !!}


                        {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                        <div class="quantity control-group" :class="[errors.has('quantity') ? 'has-error' : '']">

                            <label class="required">{{ __('shop::app.products.quantity') }}</label>

                            <input class="control quantity-change" value="-" style="width: 35px; border-radius: 3px 0px 0px 3px;" onclick="updateQunatity('remove')" readonly>

                            <input name="quantity" id="quantity" class="control quantity-change" value="1" v-validate="'required|numeric|min_value:1'" style="width: 60px; position: relative; margin-left: -4px; margin-right: -4px; border-right: none;border-left: none; border-radius: 0px;" data-vv-as="&quot;{{ __('shop::app.products.quantity') }}&quot;" readonly>

                            <input class="control quantity-change" value="+" style="width: 35px; padding: 0 12px; border-radius: 0px 3px 3px 0px;" onclick=updateQunatity('add') readonly>

                            <span class="control-error" v-if="errors.has('quantity')">@{{ errors.first('quantity') }}</span>
                        </div>

                        {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}

                        @if ($product->type == 'configurable')
                            <input type="hidden" value="true" name="is_configurable">
                        @else
                            <input type="hidden" value="false" name="is_configurable">
                        @endif

                        @include ('shop::products.view.configurable-options')

                        {!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

                        <accordian :title="'{{ __('shop::app.products.description') }}'" :active="true">
                            <div slot="header">
                                {{ __('shop::app.products.description') }}
                                <i class="icon expand-icon right"></i>
                            </div>

                            <div slot="body">
                                <div class="full-description">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </accordian>

                        {!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

                        @include ('shop::products.view.attributes')

                        @include ('shop::products.view.reviews')
                    </div>
                </div>
            </product-view>
        </div>

        @include ('shop::products.view.related-products')

        @include ('shop::products.view.up-sells')

    </section>

    {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}
@endsection

@push('scripts')

    <script type="text/x-template" id="product-view-template">
        <form method="POST" id="product-form" action="{{ route('cart.add', $product->product_id) }}" @click="onSubmit($event)">

            <slot></slot>

        </form>
    </script>

    <script>

        Vue.component('product-view', {

            template: '#product-view-template',

            inject: ['$validator'],

            methods: {
                onSubmit: function(e) {
                    if (e.target.getAttribute('type') != 'submit')
                        return;

                    e.preventDefault();

                    this.$validator.validateAll().then(function (result) {
                        if (result) {
                          if (e.target.getAttribute('data-href')) {
                            window.location.href = e.target.getAttribute('data-href');
                          } else {
                            document.getElementById('product-form').submit();
                          }
                        }
                    });
                }
            }
        });

        $(document).ready(function() {
            var addTOButton = document.getElementsByClassName('add-to-buttons')[0];
            document.getElementById('loader').style.display="none";
            addTOButton.style.display="flex";
        });

        window.onload = function() {
            var thumbList = document.getElementsByClassName('thumb-list')[0];
            var thumbFrame = document.getElementsByClassName('thumb-frame');
            var productHeroImage = document.getElementsByClassName('product-hero-image')[0];

            if (thumbList && productHeroImage) {

                for(let i=0; i < thumbFrame.length ; i++) {
                    thumbFrame[i].style.height = (productHeroImage.offsetHeight/4) + "px";
                    thumbFrame[i].style.width = (productHeroImage.offsetHeight/4)+ "px";
                }

                if (screen.width > 720) {
                    thumbList.style.width = (productHeroImage.offsetHeight/4) + "px";
                    thumbList.style.minWidth = (productHeroImage.offsetHeight/4) + "px";
                    thumbList.style.height = productHeroImage.offsetHeight + "px";
                }
            }

            window.onresize = function() {
                if (thumbList && productHeroImage) {

                    for(let i=0; i < thumbFrame.length; i++) {
                        thumbFrame[i].style.height = (productHeroImage.offsetHeight/4) + "px";
                        thumbFrame[i].style.width = (productHeroImage.offsetHeight/4)+ "px";
                    }

                    if (screen.width > 720) {
                        thumbList.style.width = (productHeroImage.offsetHeight/4) + "px";
                        thumbList.style.minWidth = (productHeroImage.offsetHeight/4) + "px";
                        thumbList.style.height = productHeroImage.offsetHeight + "px";
                    }
                }
            }
        };

        function updateQunatity(operation) {
            var quantity = document.getElementById('quantity').value;

            if (operation == 'add') {
                quantity = parseInt(quantity) + 1;
            } else if (operation == 'remove') {
                if (quantity > 1) {
                    quantity = parseInt(quantity) - 1;
                } else {
                    alert('{{ __('shop::app.products.less-quantity') }}');
                }
            }
            document.getElementById("quantity").value = quantity;

            event.preventDefault();
        }
    </script>
@endpush