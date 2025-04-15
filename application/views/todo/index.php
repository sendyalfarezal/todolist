<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .list-group-item { background-color: lightblue }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="text-center w-50">
            <h1>Jadwal Pelajaran</h1>
            
            <!-- Form Tambah Jadwal -->
            <form method="post" action="<?php echo site_url('todo/add'); ?>" class="form-control bg-dark text-white">
                <div class="m-2">
                    <input type="text" name="task" required class="form-control mb-3" placeholder="Mata Pelajaran">
                </div>
                <div class="mb-3">
                    <input type="datetime-local" name="deadline" class="form-control" required>
                </div>
                <div id="subtasks" class="m-2">
                    <input class="form-control mb-2" type="text" name="subtasks[]" placeholder="Aktivitas Belajar">
                </div>
                <div class="mb-3">
                    <select name="status" class="form-select" required>
                        <option value="Belum Dipelajari">Belum Dipelajari</option>
                        <option value="Sudah Dipelajari">Sudah Dipelajari</option>
                    </select>
                </div>
                <div class="d-flex justify-content-start mt-3">
                    <button class="btn btn-warning me-2" type="button" onclick="addSubtask()">Tambah Aktivitas</button>
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>

            <!-- Tabel Jadwal -->
            <table class="table table-bordered table-striped mt-4">
                <thead class="table-primary">
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Hari & Jam</th>
                        <th>Aktivitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo $task->task; ?></td>
                        <td><?php echo date('l, d M Y H:i', strtotime($task->deadline)); ?></td>
                        <td>
                            <ul class="mb-0">
                                <?php foreach ($task->subtasks as $subtask): ?>
                                    <li><?php echo $subtask->subtask; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td>
                            <form method="post" action="<?php echo site_url('todo/update_status/'.$task->id); ?>">
                                <input type="hidden" name="status" value="<?php echo ($task->status === 'Sudah Dipelajari') ? 'Belum Dipelajari' : 'Sudah Dipelajari'; ?>">
                                <button type="submit" class="btn btn-sm <?php echo ($task->status === 'Sudah Dipelajari') ? 'btn-success' : 'btn-secondary'; ?>">
                                    <?php echo $task->status ?? 'Belum Dipelajari'; ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $task->id; ?>">Edit</button>
                            <a href="<?php echo site_url('todo/delete/'.$task->id); ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>

                    <!-- Modal Edit Jadwal -->
                    <div class="modal fade" id="editModal<?php echo $task->id; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="<?php echo site_url('todo/edit/'.$task->id); ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Mata Pelajaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <input type="text" name="task" class="form-control" value="<?php echo $task->task; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="datetime-local" name="deadline" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($task->deadline)); ?>" required>
                                        </div>
                                        <div id="subtasks<?php echo $task->id; ?>">
                                            <?php foreach ($task->subtasks as $subtask): ?>
                                                <div class="mb-2">
                                                    <input type="text" name="subtasks[]" class="form-control" value="<?php echo $subtask->subtask; ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript untuk tambah aktivitas -->
    <script>
        function addSubtask() {
            const div = document.createElement('div');
            div.innerHTML = '<input class="form-control mb-2" type="text" name="subtasks[]" placeholder="Aktivitas Belajar">';
            document.getElementById('subtasks').appendChild(div);
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
