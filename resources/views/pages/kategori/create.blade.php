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
                            <li class="breadcrumb-item"><a href="{{ route('kategori') }}">Kategori Barang</a></li>
                            <li class="breadcrumb-item active">Buat Kategori Barang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-th-large"></i> Tambah Kategori</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ $errors }}
                                                <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama Kategori" required>

                                                @error('name')
                                                    <div id="name" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="position">Posisi Kategori <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border @error('position') is-invalid @enderror" id="position" name="position" required>
                                                    @foreach($loop as $number)
                                                        <option>{{ $number + 1 }}</option>
                                                    @endforeach
                                                </select>

                                                @error('position')
                                                    <div id="position" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-border @error('description') is-invalid @enderror" name="description" id="description" rows="6" placeholder="Masukan deskripsi ..." required></textarea>

                                                @error('description')
                                                    <div id="description" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="checkbox" class="form-control form-control-border" id="is_enable" name="is_enable" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">Slug Kategori <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border @error('slug') is-invalid @enderror" id="slug" name="slug" placeholder="Slug Kategori" required>

                                                @error('slug')
                                                    <div id="slug" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="meta-title">Meta Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border @error('meta_title') is-invalid @enderror" id="meta-title" name="meta_title" placeholder="Masukan Meta Title" required>

                                                @error('meta-title')
                                                    <div id="meta-title" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label for="meta-description">Meta Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-border @error('meta_description') is-invalid @enderror" id="meta-description" name="meta_description" rows="6" placeholder="Masukan Meta Deskripsi ..." required></textarea>

                                                @error('meta-description')
                                                    <div id="meta-description" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label for="meta-keywords">Meta Keywords <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border @error('meta_keywords') is-invalid @enderror" id="meta-keywords" name="meta_keywords" placeholder="Masukan Meta Keywords" required>

                                                @error('meta-keywords')
                                                    <div id="meta-keywords" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6" id="template">
                                            <div class="form-group">
                                                <label for="image">Foto Kategori <span class="text-danger">*</span></label>
                                                <input type="file" id="image" name="image" class="form-control form-control-border  @error('image') is-invalid @enderror" accept="image/*"/>

                                                @error('image')
                                                    <div id="image" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="w-50">
                                                    <img src="" class="img-thumbnail thumbnail-cover" alt="Cover">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" id="template">
                                            <div class="form-group text-right">

                                                <button type="submit" class="btn btn-secondary"><i class="fas fa-save"></i> Simpan Kategori</button>
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
    </style>
@endpush

@push('scripts')

    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script>
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

            // switch button
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
            // end switch

            // slug converter
            $("#slug").on('change', function () {
                let slug = string_to_slug($("#slug").val())
                $("#slug").val(slug)
            })
            // end slug converter
        })


    </script>
@endpush
