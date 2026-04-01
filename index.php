<?php
// Error reporting (for debugging demo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'db.php';

// HANDLE POST: ADD DATA
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_entry'])) {
    $content = trim($_POST['content']);
    if (!empty($content)) {
        if ($db_connected) {
            $stmt = $conn->prepare("INSERT INTO entries (content) VALUES (?)");
            $stmt->bind_param("s", $content);
            if ($stmt->execute()) {
                $message = '<div class="alert alert-success mt-2">Data berhasil ditambahkan!</div>';
            } else {
                $message = '<div class="alert alert-danger mt-2">Error: ' . $conn->error . '</div>';
            }
            $stmt->close();
        } else {
            $message = '<div class="alert alert-danger mt-2">Database tidak terhubung!</div>';
        }
    } else {
        $message = '<div class="alert alert-warning mt-2">Konten tidak boleh kosong!</div>';
    }
}

// HANDLE GET: DELETE DATA
if (isset($_GET['delete_id'])) {
    if ($db_connected) {
        $delete_id = (int)$_GET['delete_id'];
        $stmt = $conn->prepare("DELETE FROM entries WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php"); // Redirect to avoid re-execution
        exit();
    }
}

// FETCH DATA
$entries = [];
if ($db_connected) {
    $result = $conn->query("SELECT * FROM entries ORDER BY created_at DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $entries[] = $row;
        }
    }
}

// SYSTEM INFO DATA
$php_version = phpversion();
$server_software = $_SERVER['SERVER_SOFTWARE'];
$os_info = PHP_OS;
$server_time = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Demo Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">PHP Demo</a>
            <div class="ms-auto">
                <span class="badge bg-success">
                    Server Status: Online
                </span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="p-4 mb-4 bg-white border rounded">
            <h1>Minimal Web Server Setup With Nginx</h1>
            <p class="text-muted">Selamat datang di Halaman demo setup php, nginx, & mariadb</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row">
            <!-- Left Side: System Information -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title h6 fw-bold mb-3">System Information</h5>
                        <div class="mb-2">
                            <small class="text-muted d-block">Web Server</small>
                            <span><?php echo $server_software; ?></span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">PHP Version</small>
                            <span><?php echo $php_version; ?></span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">MariaDB Status</small>
                            <span class="<?php echo $db_connected ? 'text-success' : 'text-danger'; ?>">
                                <?php echo $db_status; ?>
                            </span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">OS Info</small>
                            <span><?php echo $os_info; ?></span>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted d-block">Server Time</small>
                            <span><?php echo $server_time; ?></span>
                        </div>
                        <div class="alert alert-secondary mt-3 small p-2">
                             Konfigurasi database di <code>db.php</code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: CRUD Operations -->
            <div class="col-lg-8 col-md-7">
                <!-- Add New Entry Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title h6 fw-bold mb-3">Tambah Data Baru</h5>
                        <form action="index.php" method="POST">
                            <div class="input-group mb-3">
                                <input type="text" name="content" class="form-control" placeholder="Masukkan teks di sini..." required>
                                <button type="submit" name="submit_entry" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        <?php echo $message; ?>
                    </div>
                </div>

                <!-- Entries Table -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title h6 fw-bold m-0">Data Tersimpan</h5>
                            <span class="badge bg-secondary"><?php echo count($entries); ?> Items</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover small">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Konten</th>
                                        <th>Waktu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($entries)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada data.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach($entries as $row): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo htmlspecialchars($row['content']); ?></td>
                                                <td><?php echo $row['created_at']; ?></td>
                                                <td>
                                                    <a href="index.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
