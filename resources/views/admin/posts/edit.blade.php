@extends('layouts.admin')

@section('title', 'Sửa bài viết - Tour Manager')
@section('page_heading', 'Bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Chỉnh sửa bài viết</h3>
                    <p class="text-muted mb-0">Cập nhật nội dung cho bài viết: <strong>{{ $post->title }}</strong>.</p>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>

            @include('admin.posts._form', ['post' => $post])
        </div>
    </div>
@endsection

@section('page_css')
<style>
    #post_content {
        width: 100%;
    }

    .cke_chrome,
    .cke_inner,
    .cke_contents {
        max-width: 100% !important;
    }

    .cke_contents {
        min-height: 500px !important;
    }
</style>
@endsection

@section('page_js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('post_content', {
        height: 500,
        removeButtons: 'PasteFromWord',
        toolbarGroups: [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            '/',
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
        ]
    });
</script>
@endsection
