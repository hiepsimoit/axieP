@extends('admin.layout.index')
@section('title',$title)
@section('content')
    <!-- Content Header (Page header) -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{$title}}</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route($url.'.store') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Bài viết</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea id="content" name="content" rows="5" cols="40"
                                      class="form-control my-editor"></textarea>
                            <textarea id="my-editor" name="content"
                                      class="form-control">{!! old('content', 'test editor content') !!}</textarea>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-9">
                                <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div id="holder" style="max-height:100px;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button>Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.tiny.cloud/1/tm9fwsqhr637c9pvl8q9vg44wgct2ejtd2zejauegt1prhi9/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>

        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace('my-editor', options);
        /*
   var editor_config = {
       path_absolute: "/",
       selector: 'textarea#content',
       relative_urls: false,
       plugins: [
           "advlist autolink lists link image charmap print preview hr anchor pagebreak",
           "searchreplace wordcount visualblocks visualchars code fullscreen",
           "insertdatetime media nonbreaking save table directionality",
           "emoticons template paste textpattern"
       ],
       toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
       file_picker_callback: function (callback, value, meta) {
           var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
           var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

           var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
           if (meta.filetype == 'image') {
               cmsURL = cmsURL + "&type=Images";
           } else {
               cmsURL = cmsURL + "&type=Files";
           }

           tinyMCE.activeEditor.windowManager.openUrl({
               url: cmsURL,
               title: 'Filemanager',
               width: x * 0.8,
               height: y * 0.8,
               resizable: "yes",
               close_previous: "no",
               onMessage: (api, message) => {
                   callback(message.content);
               }
           });
       }
   };

   tinymce.init(editor_config);

*/
        var route_prefix = "laravel-filemanager";
        $('#lfm').filemanager('image', {prefix: route_prefix});

        // $('#lfm').filemanager('file');
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
