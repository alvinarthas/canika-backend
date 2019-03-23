@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Bank</h4>
                    <p class="card-description">
                    Masukan data Bank baru
                    </p>
                    @if ($jenis=="create")
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('storeBank')}}" method="post">
                        @csrf
                    @elseif ($jenis=="edit")
                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateBank',['id' => $bank->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="bank_id" value="{{$bank->id}}">
                    @endif
                    @if ($errors->count() > 0)
                        <div class="card-body">
                            <blockquote class="blockquote blockquote-primary">
                                @foreach( $errors->all() as $message )
                                    <li>{{ $message }}</li>
                                  @endforeach
                            </blockquote>
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="exampleInputName1">Nama Bank</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Name" value="@isset($bank->nama){{$bank->nama}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Upload Gambar</label>
                            <progress value="0" max="100" id="uploadProgress">0%</progress>
                            <input type="file" name="upload" id="uploadButton" value="upload">
                            <input type="hidden" name="image" id="imagehide">
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://www.gstatic.com/firebasejs/5.9.0/firebase.js"></script>
    <script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyB7ikhA3SS-htfwsnxrUgjPcanmoLlCHAQ",
        authDomain: "canika-v2.firebaseapp.com",
        databaseURL: "https://canika-v2.firebaseio.com",
        projectId: "canika-v2",
        storageBucket: "canika-v2.appspot.com",
        messagingSenderId: "490792347618"
    };
    firebase.initializeApp(config);

    var storage = firebase.storage();

    var progress = document.getElementById('uploadProgress');
    var button = document.getElementById('uploadButton');

    button.addEventListener('change',function(e){
        var file = e.target.files[0];
        var storageRef = storage.ref('bank/'+file.name);
        var uploadTask = storageRef.put(file);

        uploadTask.on('state_changed', loadUpload, errUpload, completeUpload)

        function loadUpload(data){
            var percent = (data.bytesTransferred/data.totalBytes)*100
            progress.value = percent
        }

        function errUpload(err){
            console.log('error')
            console.log(err)
        }

        function completeUpload(data){
            console.log('success')
            // console.log(data)
            downloadResult(file.name)
        }
        
    })

    function downloadResult(name){
        console.log(name)
        var imageRef = storage.ref('bank/'+name);
        var imagehide = document.getElementById('imagehide');
        imageRef.getDownloadURL().then(function(url){
            // console.log("berhasil")
            // console.log(url)
            imagehide.value=url
            // console.log(imagehide)
        });

    }
    </script>
@endsection