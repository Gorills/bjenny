<?php
class ControllerExtensionModuleAdminEmail extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('extension/module/adminemail');
		$this->load->language('extension/module/adminemail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
			
		if (!isset($this->error['nopixels'])) {
		    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			    $this->model_setting_setting->editSetting('module_adminemail', $this->request->post);

				$this->model_extension_module_adminemail->setImages($this->request->post['images'],$this->request->post['orientation'],$this->request->post['pixels']);

				$this->session->data['success'] = $this->language->get('text_success');
			    $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		    }
		}
		
		$results = $this->model_extension_module_adminemail->getImages();
		foreach ($results as $result) {
		        $data['images']       = $result['images'];
				$data['orientation']  = $result['orientation'];
				$data['pixels']       = $result['pixels'];
		}

		if (isset($this->error['warning'])) {
			$data['error_warning']    = $this->error['warning'];
		} else {
			$data['error_warning']    = '';
		}
		
		if (isset($this->error['nopixels'])) {
			$data['error_nopixels']   = $this->error['nopixels'];
		} else {
			$data['error_nopixels']   = '';
		}

		$data['breadcrumbs']   = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/adminemail', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/adminemail', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_adminemail_status'])) {
			$data['module_adminemail_status'] = $this->request->post['module_adminemail_status'];
		} else {
			$data['module_adminemail_status'] = $this->config->get('module_adminemail_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/adminemail', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/adminemail')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['pixels'])) {
		    if(!is_numeric($this->request->post['pixels'])) {
			    $this->error['nopixels'] = $this->language->get('error_nopixels');
			}
		}

		return !$this->error;
	}
	
	public function install() {
        $this->load->model("extension/module/adminemail");
		$this->model_extension_module_adminemail->createSchema();
    }
 
    public function uninstall() {
		$this->load->model("extension/module/adminemail");
		$this->model_extension_module_adminemail->deleteSchema();
    }
}