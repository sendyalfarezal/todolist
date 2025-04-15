<?php
class Todo extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Todo_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['tasks'] = $this->Todo_model->get_tasks();
        $this->load->view('todo/index', $data); // ini bisa diganti jadi 'jadwal/index' kalau kamu mau pisah view-nya
    }

    public function add() {
        $mata_pelajaran = $this->input->post('task'); // "task" di form tetap, meskipun kita anggap sebagai mata pelajaran
        $waktu = $this->input->post('deadline');
        $status = $this->input->post('status');

        if ($mata_pelajaran) {
            $task_id = $this->Todo_model->add_task($mata_pelajaran, $waktu, $status);
            $aktivitas = $this->input->post('subtasks');

            if (!empty($aktivitas)) {
                foreach ($aktivitas as $item) {
                    if (!empty($item)) {
                        $this->Todo_model->add_subtask($task_id, $item);
                    }
                }
            }
        }
        redirect('todo');
    }

    public function delete($id) {
        $this->Todo_model->delete_task($id);
        redirect('todo');
    }

    public function edit($id) {
        $mata_pelajaran = $this->input->post('task');
        $waktu = $this->input->post('deadline');
        $status = $this->input->post('status');

        if ($mata_pelajaran) {
            $this->Todo_model->update_task($id, $mata_pelajaran, $waktu);
            $this->Todo_model->update_status($id, $status);

            $aktivitas = $this->input->post('subtasks');
            $this->Todo_model->delete_subtasks($id);

            if (!empty($aktivitas)) {
                foreach ($aktivitas as $item) {
                    if (!empty($item)) {
                        $this->Todo_model->add_subtask($id, $item);
                    }
                }
            }
        }

        redirect('todo');
    }

    public function update_status($id) {
        $status = $this->input->post('status');

        if ($status) {
            $this->Todo_model->update_status($id, $status);
        }

        redirect('todo');
    }
}
