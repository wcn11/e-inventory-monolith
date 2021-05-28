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
                            <li class="breadcrumb-item active">Update Kategori Barang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-th-large"></i> Update Kategori</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('kategori.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ $errors }}
                                                <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" id="name" name="name" value="{{ $category->name }}" placeholder="Nama Kategori" required>

                                                @error('name')
                                                    <div id="name" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="position">Posisi Kategori <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="position" id="position" value="{{ $category->posititon }}" required>
                                                    @foreach($loop as $number)
                                                        <option>{{ $number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="description">Deskripsi <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-border" id="description" name="description" rows="6" placeholder="Masukan deskripsi ..." required>{{ $category->description }}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="checkbox" class="form-control form-control-border" id="is_enable" name="is_enable" @if($category->is_enable === 'on') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">Slug Kategori <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="slug" value="{{ $category->slug }}" id="slug" placeholder="Slug Kategori" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta-title">Meta Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="meta_title" value="{{ $category['meta_title'] }}" id="meta-title" placeholder="Masukan Meta Title" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-border" name="meta_description" id="meta-description" rows="6" placeholder="Masukan Meta Deskripsi ..." required>{{ $category['meta_description'] }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta-keywords">Meta Keywords <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="meta_keywords" id="meta-keywords" value="{{ $category['meta_keywords'] }}" placeholder="Masukan Meta Keywords" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6" id="template">
                                            <div class="form-group">
                                                <label for="exampleInputBorder">Foto Kategori <span class="text-danger">*</span></label>
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

                                                <button type="submit" class="btn btn-secondary"><i class="fas fa-edit"></i> Update Kategori</button>
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
