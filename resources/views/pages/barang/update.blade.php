@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('barang') }}">Daftar Produk</a></li>
                            <li class="breadcrumb-item active">Update Produk</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-box"></i> Update Produk</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('barang.update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Kode SKU</label>
                                                <input type="text" name="sku" class="form-control form-control-border" value="{{ $product->sku }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama Produk <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" value="{{ $product->name }}" name="name" id="name" placeholder="Nama Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Harga<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="price" value="{{ $product->price }}" id="price" placeholder="Harga Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="weight">Berat <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="weight" id="weight" value="{{ $product->weight }}" placeholder="Berat Produk (Kilogram). Contoh: 1.5" required onkeydown="return event.keyCode !== 69">
                                            </div>
                                            <div class="form-group">
                                                <label for="position">Posisi Produk <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="position" id="position"  value="{{ $product->position }}" required>
                                                    @foreach($loop as $number)
                                                        <option value="{{ $number }}" @if($number === $product->position) selected @endif>{{ $number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-border" name="description" id="description" rows="6" placeholder="Masukan deskripsi ..." required>{{ $product->description }}</textarea>
                                            </div>

                                            <div class="from-group">
                                                <label for="category_id">Kategori Produk <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="category_id" id="category_id"  value="{{ $product->category_id }}" required>
                                                    @foreach($category as $number)
                                                        <option value="{{ $number->id }}" @if($number->id === $product->category_id) selected @endif>{{ $number->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" class="form-control form-control-border" id="is_enable" name="is_enable" @if($product->is_enable === 'on') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="slug">Slug Produk <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-border" name="slug" value="{{ $product->slug }}" id="slug" placeholder="Slug Produk" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meta_title">Meta Title <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-border" name="meta_title" value="{{ $product->meta_title }}" id="meta_title" placeholder="Masukan Meta Title" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meta_description">Meta Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control form-control-border" id="meta_description" name="meta_description"  rows="6" placeholder="Masukan Meta Deskripsi ..." required>{{ $product->meta_description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meta-keywords">Meta Keywords <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-border" name="meta_keywords" id="meta_keywords" placeholder="Masukan Meta Keywords"  value="{{ $product->meta_keywords }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="sack-container">
                                                        <div class="wrapper-sack">
                                                            <div class="form-group">
                                                                <label for="contents">Jumlah Produk Dalam Karung</label>
                                                                <input type="text" class="form-control form-control-border" name="contents" id="contents" placeholder="Isi Total Dalam Karung" value="{{ $sack->contents ?? 0 }}" required onkeydown="return event.keyCode !== 69">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="weight_min">Berat Min. (KG)</label>
                                                                <input type="text" class="form-control form-control-border" name="weight_min" id="weight_min" placeholder="Berat Minimal Karung (Kilogram). Contoh: 1.5" value="{{ $sack->weight_min ?? 0.0 }}" required onkeydown="return event.keyCode !== 69">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="weight_min">Berat Maks. (KG)</label>
                                                                <input type="text" class="form-control form-control-border" name="weight_max" id="weight_max" placeholder="Berat Maksimal Karung (Kilogram). Contoh: 1.5" value="{{ $sack->weight_max ?? 0.0 }}" required onkeydown="return event.keyCode !== 69">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6" id="template">
                                            <div class="form-group">
                                                <label for="exampleInputBorder">Foto Produk <span class="text-danger">*</span></label>
                                                <input type="file" id="image" name="image" class="form-control form-control-border" accept="image/*"/>

                                                @if($imageURL)
                                                    <div class="w-50">
                                                        <img src="{{ $imageURL }}" class="img-thumbnail thumbnail-cover" alt="Cover">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" id="template">
                                            <div class="form-group text-right">

                                                <button type="submit" class="btn btn-secondary"><i class="fas fa-edit"></i> Update Produk</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        textarea{
            resize: none;
        }

        .sack-container{
            background-color: #FFB703;
            border-radius: 5% 10%;
        }

        .wrapper-sack{
            padding: 4%;
        }
    </style>
@endpush

@push('scripts')

    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>

        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        @error('product_update_invalid')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        @error('sack_update_invalid')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        function string_to_slug (str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            let from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            let to   = "aaaaeeeeiiiioooouuuunc------";
            for (var i=0, l=from.length ; i<l ; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

        // cek jika cover null atau tidak
        checkImage()
        function checkImage(status = false){

            if (status){
                jQuery(".thumbnail-cover").css({
                    "display": 'block'
                })
            }
        }

        // mulai jquery
        jQuery(document).ready(function ($) {

            $("#image").on('change', function (event){
                let reader = new FileReader()
                reader.onload = () => {
                    document.querySelector('.thumbnail-cover').src = reader.result
                }
                checkImage(true)
                reader.readAsDataURL(event.target.files[0])
            })

            // slug converter
            $("#slug").on('change', function () {
                let slug = string_to_slug($("#slug").val())
                $("#slug").val(slug)
            })
            // end slug converter

            // weight converter
            $("#weight").on('keypress', function (){
                let weight = $(this)
                let rgx = /^[0-9]*\.?[0-9]*$/;
                weight.val(weight.val().match(rgx));
            })
            // end weight converter

            // switch button
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
            // end switch

            // filter number
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };

            $("#price").inputFilter(function(value) {
                return /^-?\d*$/.test(value); });
            // end filter number

            $("#contents").inputFilter(function(value) {
                return /^-?\d*$/.test(value);
            });

            $("#weight_min").on('keypress', function (){
                let weight = $(this)
                let rgx = /^[0-9]*\.?[0-9]*$/;
                weight.val(weight.val().match(rgx));
            })

            $("#weight_max").on('keypress', function (){
                let weight = $(this)
                let rgx = /^[0-9]*\.?[0-9]*$/;
                weight.val(weight.val().match(rgx));
            })
        })


    </script>
@endpush
