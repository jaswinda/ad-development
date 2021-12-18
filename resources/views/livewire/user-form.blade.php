<div>
    @if ($uploaded_document!=null)
    <h1>Document Have Been Submitted.</h1>
    <table class="table">
        <tr>
            <td>Document Name</td>
            <td>{{$uploaded_document->full_name}}</td>
        </tr>
        <tr>
            <td>Document Type</td>
            <td>{{$uploaded_document->document_type=='1'?'Citizenship':'License'}}</td>
        </tr>
        <tr>
            <td>Document Issue Place</td>
            <td>{{$uploaded_document->document_issue_place}}</td>
        </tr>
        <tr>
            <td>Document File</td>
            <td>
                <div wire:loading >
                    <div class='spinner-border'></div>
                </div>
                <div id="upload-section">
                    <div id="upload-section-inside">
                        @if ($uploaded_document->document_image=='/images/no-image.png')

                        <img src="{{$uploaded_document->document_image}}">
                        <form name="photo" id="imageUploadForm" enctype="multipart/form-data" action="/compress-image"
                            method="post">
                            <input required class="form-control" type="file" id="ImageBrowse" name="image" size="30" />
                            <input type="submit" class="btn" name="upload" value="Upload" />
                        </form>
                        @else
                        <img width="200" height="200" src="/images/documents/{{$uploaded_document->document_image}}">
                        <form name="photo" id="imageUploadForm" enctype="multipart/form-data" action="/compress-image"
                            method="post">
                            <input required class="form-control mt-3" type="file" id="ImageBrowse" name="image" size="30" />
                            <input type="submit" class="btn mt-3" name="upload" value="Change Image" />
                        </form>
                        @endif
                    </div>
                </div>

            </td>
        </tr>
    </table>
    @else
    <div class="container d-flex flex-wrap justify-content-center align-items-center vh-100 vw-100">

        <div class="row col-12 col-md-8 col-lg-6 shadow rounded p-3">

            <div class="col-sm-12">
                Please Provide Your Details
                <form role="form" method="POST" wire:submit.prevent="submit">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <label class="control-label">Full Name</label>
                                <input required type="text" wire:model='full_name' name="full_name"
                                    class="form-control">
                                @error('full_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mt-3">
                                <label class="control-label">Father's Name</label>
                                <input required type="test" wire:model='father_name' name="father_name"
                                    class="form-control">
                                @error('father_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <label class="control-label">Date of Birth (DOB)</label>
                                <input required type="date" wire:model='date_of_birth'
                                    class="form-control datepicker" />
                                @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <label for="inputState" class="form-label">Document-Type</label>
                                <select name="document_type" wire:model='document_type' required id="inputState"
                                    class="form-select">
                                    <option selected value="1">Citizenship</option>
                                    <option value="2">License</option>
                                </select>
                                @error('document_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mt-3">
                                <label for="document_issue_date" class="control-label">Document Issue Date</label>
                                <input required id="document_issue_date" wire:model='document_issue_date' required
                                    type="date" name="document_issue_date" class="form-control">
                                @error('document_issue_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <label for="document_number" class="control-label">Document Number</label>
                                <input required id="document_number" wire:model='document_number' required type="number"
                                    name="document_number" class="form-control">
                                @error('document_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mt-3">
                                <label for="document_issue_place" class="control-label">Document Issue Place</label>
                                <input required id="document_issue_place" wire:model='document_issue_place' required
                                    type="text" name="document_issue_place" class="form-control">
                                @error('document_issue_place')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-primary w-100">SEND</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function (e) {
        $('#imageUploadForm').on('submit',(function(e) {
            e.preventDefault();
            $('#upload-section-inside').hide();
            $('#upload-section').addClass('spinner-border');
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    if (data["success"]) {
                        alert(data["message"]);
                        Livewire.emit('update-document', data["image"]);
                    } else {
                        alert(data["message"]);
                    }
                    $('#upload-section').removeClass('spinner-border');
                    $('#upload-section-inside').show();
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
        }));


        });
        // uploadImage(){
        //     $.ajax({
        //     url: '/compress-image',
        //     type: 'POST',
        //     data: {
        //     "_token": "{{ csrf_token() }}",
        //     },
        //     success: function(data) {
        //         console.log(data);
        //         if (data["success"]) {
        //             alert(data["message"]);
        //             window.location = '/home';
        //         }else{
        //             alert(data["message"]);
        //         }
        //     }
        // });
    </script>

</div>
