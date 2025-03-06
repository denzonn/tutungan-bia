<!DOCTYPE html>
<html>

<head>
    <title>{{ $data_email['subject'] }}</title>
</head>

<body>
    <h3>Pengirim: {{ $data_email['email_sender'] }}</h3>
    <p>Pesan:</p>
    <p>{{ $data_email['isi'] }}</p>
</body>

</html>
