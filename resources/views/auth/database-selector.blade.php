@extends('layouts.app')

@section('content')
<div class="container d-flex flex-wrap justify-content-center align-items-center vh-100 vw-100">
    <div class="row col-12 col-md-8 col-lg-6 shadow rounded p-3">
        <h2 class="mb-3">Database Selector</h2>
        <hr />
        <div class="col-md-12">
            <div class="col-12">
                <label for="inputState" class="form-label">Database</label>
                <select name="database" required id="inputState" class="form-select">
                    <option selected value="db1">Database 1</option>
                    <option value="db2">Database 2</option>
                </select>
            </div>
        </div>
        <div class="row mb-0 mt-5">
            <div class="col-md-8 ">
                <button onclick="proceed()" class="btn btn-primary">
                    Proceed
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

        function proceed() {
            var database = $('#inputState').val();
            var pathname = window.location.pathname;
            $.ajax({
            url: '/verify-my-email/db1'+pathname,
            type: 'POST',
            data: {
            "_token": "{{ csrf_token() }}",
            'id': '{{ $data["id"] }}',
            'hash': '{{ $data["hash"] }}',
            'signature': '{{ $data["signature"] }}',
            'email': '{{ $data["email"] }}',
            'database': database
            },
            success: function(data) {
                console.log(data);
                if (data["success"]) {
                    alert(data["message"]);
                    window.location = '/home';
                }else{
                    alert(data["message"]);
                }
            }
        });
        }

        // });
</script>

@endsection
