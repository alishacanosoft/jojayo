@extends('admin.layouts.master')
@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
        rel="stylesheet" />
    <style>
        .slow .toggle-group {
            transition: left 0.7s;
            -webkit-transition: left 0.7s;
        }

        .toggle,
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20rem;
        }

        .toggle,
        .toggle.ios .toggle-handle {
            border-radius: 20rem;
        }

        .editable-address {
            display: block;
            margin-bottom: 5px;
        }

        .editable-address span {
            width: 70px;
            display: inline-block;
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#manage" data-toggle="tab">Product Summary</a></li>
                        </ul>
                        <div class="tab-content bg-white">
                            <div class="tab-paneactive" id="manage">
                                <form action="{{ route('products.restore', $product->id) }}" method="POST"
                                    class="form-horizontal">
                                    @csrf
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-sm-12">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Product Name<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="name" type="text" class="form-control"
                                                                        disabled value="{{ @$product->product->name }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Category<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="name" type="text" class="form-control"
                                                                        disabled
                                                                        value="{{ @$product->product->category->name }}">
                                                                </div>
                                                            </div>

                                                            <div class="row text-center" style="margin-bottom:6px">
                                                                <strong>General</strong>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Slug<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="slug" type="text" class="form-control"
                                                                        disabled value="{{ @$product->product->slug }}">

                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Video</label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input type="url" name="video" class="form-control"
                                                                        disabled>

                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Brand<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="slug" type="text" class="form-control"
                                                                        disabled
                                                                        value="{{ @$product->product->brand->name }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Vendor<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="slug" type="text" class="form-control"
                                                                        disabled
                                                                        value="{{ @$product->product->VendorName->company }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Vendor SKU<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="sku" type="text" class="form-control"
                                                                        id="sku" disabled
                                                                        value="{{ @$product->product->sku }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Jojayo SKU</label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <input name="jojayo_sku" type="text"
                                                                        class="form-control" id="jojayo_sku" disabled
                                                                        value="{{ @$product->product->jojayo_sku }}">

                                                                </div>
                                                            </div>

                                                            <div id="attribute">
                                                                <div class="row text-center" style="margin-bottom:6px">
                                                                    <strong>Product
                                                                        Attributes</strong>
                                                                </div>
                                                                @if (!empty($product_attr))
                                                                    @foreach ($product_attr as $att_list)
                                                                        @foreach ($att_list->attributes as $key => $value)
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-sm-2 control-label">{{ $value->attributeDetail->name }}
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <div class="col-md-8 col-lg-10">

                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Similar Products<span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <select name="similar_poducts[]" class="select_2_to"
                                                                        id="similar_poducts" multiple="multiple">
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Product
                                                                    Specification<span class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <textarea name="specification" id="specification"
                                                                        rows="10"
                                                                        class="form-control editor">{{ @$product->product->specification }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 control-label">Product
                                                                    Description<span class="text-danger">*</span></label>
                                                                <div class="col-md-8 col-lg-10">
                                                                    <textarea name="description" id="description" rows="10"
                                                                        class="form-control editor">{{ @$product->product->description }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div id="warranty_data">
                                                                <div class="form-group row">
                                                                    <div class="col-md-4 col-lg-2">
                                                                        <label for="description-2" class="block">Warranty
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-8 col-lg-10">
                                                                        <input type="text" name="warranty"
                                                                            placeholder="Warranty period"
                                                                            class="form-control"
                                                                            value="{{ old('warranty', @$data->warranty) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @method('PATCH')
                                    <div class="row text-right">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary" name="status"
                                                value="active">Restore Product</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
@endsection
