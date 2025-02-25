<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID level Pengguna</th>
        </tr>
        @foreach($user as $u)
        <tr>
            <td>{{ $u->user_id }}</td>
            <td>{{ $u->username }}</td>
            <td>{{ $u->nama }}</td>
            <td>{{ $u->level_id }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>