<?php
class Todo_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    // Ambil semua mata pelajaran beserta aktivitasnya
    public function get_tasks() {
        $jadwal = $this->db->get('tasks')->result();
        foreach ($jadwal as $item) {
            $item->subtasks = $this->db->get_where('subtasks', ['task_id' => $item->id])->result();
        }
        return $jadwal;
    }

    // Tambah mata pelajaran baru
    public function add_task($mata_pelajaran, $waktu, $status = 'Belum Dipelajari') {
        $this->db->insert('tasks', [
            'task' => $mata_pelajaran,
            'deadline' => $waktu,
            'status' => $status
        ]);
        return $this->db->insert_id();
    }

    // Tambah aktivitas belajar (subtask)
    public function add_subtask($task_id, $aktivitas) {
        return $this->db->insert('subtasks', [
            'task_id' => $task_id,
            'subtask' => $aktivitas
        ]);
    }

    // Hapus jadwal dan semua aktivitas
    public function delete_task($id) {
        $this->db->delete('subtasks', ['task_id' => $id]);
        return $this->db->delete('tasks', ['id' => $id]);
    }

    // Hapus semua aktivitas dari satu pelajaran
    public function delete_subtasks($task_id) {
        return $this->db->delete('subtasks', ['task_id' => $task_id]);
    }

    // Update pelajaran dan waktunya
    public function update_task($id, $mata_pelajaran, $waktu) {
        $this->db->where('id', $id);
        $this->db->update('tasks', [
            'task' => $mata_pelajaran,
            'deadline' => $waktu
        ]);
    }

    // Update status belajar
    public function update_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', ['status' => $status]);
    }

    // Ambil satu pelajaran berdasarkan ID
    public function get_task_by_id($id) {
        return $this->db->get_where('tasks', ['id' => $id])->row();
    }

    // Ambil semua aktivitas belajar dari satu pelajaran
    public function get_subtasks_by_task_id($task_id) {
        return $this->db->get_where('subtasks', ['task_id' => $task_id])->result();
    }

    // Hapus satu aktivitas belajar
    public function delete_single_subtask($id) {
        return $this->db->delete('subtasks', ['id' => $id]);
    }
}
