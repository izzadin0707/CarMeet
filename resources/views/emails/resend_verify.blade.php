<!DOCTYPE html>
<html lang="en" id="htmlMode" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="style/js/script.js"></script>
    <title>LookME</title>
</head>

<body class="position-relative">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card p-3" style="width: 59vh;">
            <div class="card-body">
                <form action="{{ route('resend_verify') }}" method="post">
                    @csrf
                    <h4>Please Verify Your Email</h4>
                    @if($status != null)
                    <p>{{ $status }}</p>
                    @endif
                    <span>wait 10 second for resend</span>
                    <input class="btn btn-outline-secondary" style="display: none;" type="submit" value="Resend Verify" id="submit">
                    <input type="hidden" value="{{ $email }}" name="email">
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>

<script>
    // Menunggu 5 detik sebelum menampilkan pesan
    setTimeout(function() {
      document.getElementById('submit').style.display = 'block';
    }, 10000);
</script>
