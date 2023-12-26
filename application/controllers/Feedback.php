<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

class Feedback extends CI_Controller
{
    public function index()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $params = $this->input->post();
            if ($params['rating1'] >= 1 && $params['rating1'] <= 2) {
                $label = '0';
            } elseif ($params['rating1'] >= 3 && $params['rating1'] <= 5) {
                $label = '1';
            } else {
                $label = '2';
            }
            $this->db->insert('datasets', [
                'text' => $params['text'],
                'label' => $label,
                'pre_processing_text' => '',
                'predicted_label' => 0,
                'id_pasien' => $_SESSION['id'],
                'bintang' => $params['rating1'],
            ]);
            echo "<script>alert('Terimakasih telah mengirimkan ulasan ke kami'); location.href = '".base_url()."feedback';</script>";
        } else {
            $this->db->where('id_pasien', $_SESSION['id']);
            $data['info'] = $this->db->get('datasets')->row_array();

            $this->load->view('v_feedback', $data);
        }
    }

    public function daftar()
    {
        $data['datasets'] = $this->db->get('datasets')->result_array();
        $this->load->view('v_daftar_feedback', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/login', 'refresh');
    }
}
