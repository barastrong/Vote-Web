<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<style>
/* Reset dasar untuk menghilangkan margin, padding, dan set box-sizing */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Menggunakan font Poppins dari Google Fonts */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f7f8fa;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

/* Kontainer utama */
.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Heading utama */
.heading {
    font-size: 2.8rem;
    margin-bottom: 20px;
    color: #4c6ef5;
    font-weight: 600;
}

/* Pesan sukses */
.success-message {
    color: #28a745;
    font-size: 1.2rem;
    margin-bottom: 20px;
}

/* Styling untuk form voting */
.vote-form {
    margin-top: 20px;
    text-align: left;
}

/* Styling untuk setiap opsi voting */
.vote-option {
    margin: 20px 0;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    font-size: 1.2rem;
    transition: background-color 0.3s ease;
    padding: 10px;
    border-radius: 10px;
}

/* Efek hover pada setiap opsi */
.vote-option:hover {
    background-color: #eef2fd;
}

/* Styling untuk input radio */
.vote-option input[type="radio"] {
    margin-right: 15px;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

/* Styling untuk label opsi */
.vote-label {
    font-size: 1.2rem;
    color: #555;
    cursor: pointer;
}

/* Tombol vote */
.vote-button {
    background-color: #4c6ef5;
    color: #fff;
    border: none;
    padding: 14px 35px;
    font-size: 1.2rem;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    margin-top: 20px;
}

.vote-button:hover {
    background-color: #3a56c4;
}

/* Hasil voting */
.results-heading {
    font-size: 1.8rem;
    margin-top: 40px;
    color: #333;
    font-weight: 600;
}

/* Daftar hasil voting */
.vote-results {
    list-style-type: none;
    margin-top: 20px;
    padding: 0;
}

.vote-results li {
    font-size: 1.2rem;
    color: #444;
    margin-bottom: 12px;
}

/* Modal Popup */
.modal {
    display: none;  /* Default modal is hidden */
    position: fixed;
    z-index: 1;  /* Sit on top of the page */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);  /* Background with opacity */
    transition: opacity 0.4s ease;
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 30px;
    border-radius: 15px;
    width: 80%;
    max-width: 500px;
    text-align: center;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 20px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Responsif untuk perangkat kecil */
@media screen and (max-width: 600px) {
    .heading {
        font-size: 2.2rem;
    }

    .vote-button {
        font-size: 1.1rem;
        padding: 12px 25px;
    }

    .vote-option label {
        font-size: 1rem;
    }

    .vote-results li {
        font-size: 1rem;
    }
}


</style>
<body>
    <div class="container">
        <h1 class="heading">Pilih Opsi untuk Voting</h1>

        @if(session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <!-- Form Voting -->
        <form action="{{ route('vote.store') }}" method="POST" class="vote-form">
            @csrf
            @foreach($options as $option)
                <div class="vote-option">
                    <input type="radio" id="option{{ $option->id }}" name="option_id" value="{{ $option->id }}">
                    <label for="option{{ $option->id }}" class="vote-label">
                        {{ $option->name }} - {{ $option->opini }}
                    </label>
                </div>
            @endforeach
            <button type="submit" class="vote-button">Vote</button>
        </form>

        <!-- Modal untuk Menampilkan Hasil Voting -->
        @if(session('selectedOption'))
            <div id="voteModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Terima Kasih telah Voting!</h2>
                    <p>Anda memilih: <strong>{{ session('selectedOption')->name }}</strong></p>
                    <p>Suara terkini: {{ session('selectedOption')->vote_count }} suara</p>
                    <button onclick="window.location.href='{{ route('vote.index') }}'">Kembali ke Voting</button>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Modal Popup
        var modal = document.getElementById("voteModal");
        var span = document.getElementsByClassName("close")[0];

        // Tampilkan modal jika ada session 'selectedOption'
        @if(session('selectedOption'))
            modal.style.display = "block";
        @endif

        // Tutup modal saat klik X
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Tutup modal jika klik di luar modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
