@extends('admin.layout.index')
@section('content')

    <h1 class="text-uppercase">Thêm Blog</h1>
    <!-- Content Header (Page header) -->

    <form class="form-horizontal" action="admin/blog/add" method="post">

        <div class="box-body">
            @if($errors->any())
                @foreach($errors->all() as $err)
                    {{ $err }} <br>
                @endforeach
            @endif

            @if(session('message'))
                <div class="alert">
                    {{ session('message') }}
                </div>
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-md-2">Tiêu đề</label>
                <div class="col-md-10">
                    <input class="title form-control" type="text" name="name" value="{{ old('name') }}"
                           placeholder="Tiêu đề"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Tiêu đề tiếng nhật</label>
                <div class="col-md-10">
                    <input class="title form-control" type="text" name="name_jp" value="{{ old('name_jp') }}"
                           placeholder="Tiêu đề"></div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Url</label>
                <div class="col-md-10">
                    <input class="form-control slug" type="text" name="url" value="{{ old('url') }}"
                           placeholder=""></div>
            </div>


            <div class="form-group">
                <label class="col-md-2">Ảnh đại điện</label>
                <div class="col-md-10">
                    <input type="text" size="48" readonly name="image" id="image"/> <span
                            onclick="openPopup()" class="btn btn-default">Chọn file</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-2">Nội dung</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="description"
                              name="description">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Nội dung tiếng nhật</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="description_jp"
                              name="description_jp">{{ old('description_jp') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2">Phân loại</label>
                <div class="col-md-2">
                    <select class="form-control" name="type">
                        <option value="1" <?php if (old('type') == 1) {
                            echo 'selected';
                        } ?>>Chuyện đi Nhật
                        </option>
                        <option value="2" <?php if (old('type') == 2) {
                            echo 'selected';
                        } ?>>Chuyện học tập
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <label>Description</label>
                </div>
                <div class="col-md-6">
                    <textarea name="description" rows="5" cols="40" class="form-control tinymce-editor"></textarea>
                    <textarea id="mytextarea" name="description" rows="5" cols="40" class="form-control "></textarea>
                    <textarea id="local-upload" name="description" rows="5" cols="40" class="form-control "></textarea>
                    <div id="uploader">
                        <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button class="btn btn-primary" type="submit">Thêm</button>
            </div>
        </div>


    </form>
    <!-- /.content -->
    <script src="https://cdn.tiny.cloud/1/tm9fwsqhr637c9pvl8q9vg44wgct2ejtd2zejauegt1prhi9/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script type="text/javascript">

    </script>
    <script>
        $("#uploader").plupload({
            // General settings
            runtimes : 'html5,flash,silverlight,html4',
            url : "/examples/upload",

            // Maximum file size
            max_file_size : '2mb',

            chunk_size: '1mb',

            // Resize images on clientside if we can
            resize : {
                width : 200,
                height : 200,
                quality : 90,
                crop: true // crop to exact dimensions
            },

            // Specify what files to browse for
            filters : [
                {title : "Image files", extensions : "jpg,gif,png"},
                {title : "Zip files", extensions : "zip,avi"}
            ],

            // Rename files by clicking on their titles
            rename: true,

            // Sort files
            sortable: true,

            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: true,

            // Views to activate
            views: {
                list: true,
                thumbs: true, // Show thumbs
                active: 'thumbs'
            },

            // Flash settings
            flash_swf_url : '/plupload/js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url : '/plupload/js/Moxie.xap'
        });
        tinymce.init({
            selector: 'textarea#local-upload',
            plugins: 'image code',
            toolbar: 'undo redo | image code',

            /* without images_upload_url set, Upload tab won't show up*/
            images_upload_url: 'postAcceptor.php',

            /* we override default upload handler to simulate successful upload*/
            images_upload_handler: function (blobInfo, success, failure) {
                setTimeout(function () {
                    /* no matter what you upload, we will turn it into TinyMCE logo :)*/
                    success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
                }, 2000);
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        tinymce.init({
            selector: '#mytextarea',
            plugins: [
                "image imagetool",
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | lignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | image",

            file_picker_callback: function (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                let type = 'image' === meta.filetype ? 'Images' : 'Files',
                    url = '/laravel-filemanager?editor=tinymce5&type=' + type;

                tinymce.activeEditor.windowManager.openUrl({
                    url: url,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        });
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 100,

            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount ',
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help |image',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
        CKEDITOR.replace('description', {
            filebrowserBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html') }}',
            filebrowserImageBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html?type=Images') }}',
            filebrowserFlashBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html?type=Flash') }}',
            filebrowserUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
            filebrowserImageUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
            filebrowserFlashUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
        });
        CKEDITOR.replace('description_jp', {
            filebrowserBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html') }}',
            filebrowserImageBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html?type=Images') }}',
            filebrowserFlashBrowseUrl: '{{ asset('public/ckfinder/ckfinder.html?type=Flash') }}',
            filebrowserUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
            filebrowserImageUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
            filebrowserFlashUploadUrl: '{{ asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
        });

        function openPopup() {
            CKFinder.popup({
                chooseFiles: true,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        var file = evt.data.files.first();
                        document.getElementById('image').value = file.getUrl();
                    });
                    finder.on('file:choose:resizedImage', function (evt) {
                        document.getElementById('image').value = evt.data.resizedUrl;
                    });
                }
            });
        }

        function get_alias(str) {
            str = str.toLowerCase();
            str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
            str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
            str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            str = str.replace(/đ/g, "d");
            str = str.replace(/!|@|\$|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'| |\"|\&|\#|\[|\]|~/g, "-");
            str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
            return str;
        }

        $(document).ready(function () {
            $('.title').keyup(function () {
                var str = $(this).val();
                $('.slug').val(get_alias(str));
            });

        });
    </script>

@endsection
