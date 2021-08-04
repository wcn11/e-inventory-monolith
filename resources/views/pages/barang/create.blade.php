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
                            <li class="breadcrumb-item active">Buat Produk Baru</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-box"></i> Tambah Produk</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('barang.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sku">Kode SKU <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="sku" id="sku" placeholder="Kode SKU" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama Produk <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="name" id="name" placeholder="Nama Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Harga<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="price" id="price" placeholder="Harga Produk" required onkeydown="return event.keyCode !== 69" pattern="\d*">
                                            </div>
                                            <div class="form-group">
                                                <label for="weight">Berat <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="weight" id="weight" placeholder="Berat Produk (Kilogram). Contoh: 1.5" required onkeydown="return event.keyCode !== 69">
                                            </div>
                                            <div class="form-group">
                                                <label for="posisi">Posisi Produk <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="position" id="position" required onkeydown="return event.keyCode !== 69">
                                                    @foreach($loop as $number)
                                                        <option>{{ $number + 1 }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Kategori Produk <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="category_id" id="category" required onkeydown="return event.keyCode !== 69">
                                                    @foreach($category as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-border" name="description" id="description" rows="6" placeholder="Masukan deskripsi ..." required></textarea>
                                            </div>
{{--                                            <product-variant-options></product-variant-options>--}}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" class="form-control form-control-border" id="is_enable" name="is_enable" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="slug">Slug Produk <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-border" name="slug" id="slug" placeholder="Slug Produk" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meta-title">Meta Title <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-border" name="meta_title" id="meta-title" placeholder="Masukan Meta Title" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Meta Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control form-control-border" name="meta_description" id="meta-description" rows="6" placeholder="Masukan Meta Deskripsi ..." required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meta-keywords">Meta Keywords <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-border" name="meta_keywords" id="meta-keywords" placeholder="Masukan Meta Keywords" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="sack-container">
                                                        <div class="wrapper-sack">
                                                            <div class="form-group">
                                                                <label for="contents">Jumlah Produk Dalam Karung</label>
                                                                <input type="text" class="form-control form-control-border" name="contents" id="contents" placeholder="Isi Total Dalam Karung" required onkeydown="return event.keyCode !== 69">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="weight_min">Berat Min. (KG)</label>
                                                                <input type="text" class="form-control form-control-border" name="weight_min" id="weight_min" placeholder="Berat Minimal Karung (Kilogram). Contoh: 1.5" required onkeydown="return event.keyCode !== 69">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="weight_min">Berat Maks. (KG)</label>
                                                                <input type="text" class="form-control form-control-border" name="weight_max" id="weight_max" placeholder="Berat Maksimal Karung (Kilogram). Contoh: 1.5" required onkeydown="return event.keyCode !== 69">
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
                                                <label for="image">Foto Produk <span class="text-danger">* Maks. 3mb</span></label>
                                                <input type="file" id="image" name="image" class="form-control form-control-border" accept="image/*"/>
                                                <div class="w-50">
                                                    <img src="" class="img-thumbnail thumbnail-cover" alt="Cover">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" id="template">
                                            <div class="form-group text-right">
                                                <button type="submit" class="btn btn-secondary"><i class="fas fa-save"></i> Simpan Produk</button>
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
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>

        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        @error('product_store_invalid')
            Toast.fire({
                icon: 'error',
                title: '{{ $message }}'
            })
        @enderror

        @error('sack_store_invalid')
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
            let element = document.querySelector('.thumbnail-cover')
            if (element.value === undefined){
                jQuery(".thumbnail-cover").css({
                    "display": 'none'
                })
            }

            if (status){
                jQuery(".thumbnail-cover").css({
                    "display": 'block'
                })
            }
        }

        jQuery(document).ready(function ($) {

            // buat thumbnail cover
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
                return /^-?\d*$/.test(value);
            });

            $("#stock").inputFilter(function(value) {
                return /^-?\d*$/.test(value);
            });
            // end filter number

            $("#contents").inputFilter(function(value) {
                return /^-?\d*$/.test(value);
            });

            // weight converter
            $("#weight").on('keypress', function (){
                let weight = $(this)
                let rgx = /^[0-9]*\.?[0-9]*$/;
                weight.val(weight.val().match(rgx));
            })

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
            // end weight converter

            // variant expand
            $('#is_has_variant').on('switchChange.bootstrapSwitch', function (event, state) {
                if (state){

                }else{

                }
            });
        })


    </script>
@endpush
