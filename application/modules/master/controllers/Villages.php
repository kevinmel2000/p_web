<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Villages extends MX_Controller 
{

    public function __construct()
    {
        $this->load->model("VillagesModel", "villages");
    }

    public function getVillages()
    {
        isAjax();
        $p = $this->villages->get();
        echo json_encode($p);
    }

    public function saveVillages()
    {
        isAjax();
        $data = $this->input->post('data');
        $p = $this->villages->post($data);
        echo json_encode($p);
    }

    public function editVillages()
    {
        isAjax();
        $data= $this->input->post('data');
        $p = $this->villages->put($data);
        echo json_encode($p);
    }

    public function deleteVillages()
    {
        isAjax();
        $data = $this->input->post('data');
        $p = $this->villages->delete($data);
        echo json_encode($p);
    }
}

/* End of file Villages.php */
