<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$canonical = $this->url->link('common/home');
			if ($this->config->get('config_seo_pro') && !$this->config->get('config_seopro_addslash')) {
				$canonical = rtrim($canonical, '/');
			}
			$this->document->addLink($canonical, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

        $this->load->model('catalog/category');
		$this->load->model('tool/image');

		$data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
        			if ($category['top']) {
        				// Level 2
        				$children_data = array();

        				$children = $this->model_catalog_category->getCategories($category['category_id']);

        				foreach ($children as $child) {
        					$filter_data = array(
        						'filter_category_id'  => $child['category_id'],
        						'filter_sub_category' => true
        					);

        					$children_data[] = array(
        						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
        						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
        					);
        				}

        				// Level 1
                        if($category['image']){
                            $image = $this->model_tool_image->resize($category['image'], 330, 495);
                        } else {
                            $image = false;
                        }
                        $data['categories'][] = array(
                            'image'    => $image,
        					'name'     => $category['name'],
        					'children' => $children_data,
        					'column'   => $category['column'] ? $category['column'] : 1,
        					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
        				);
        			}
        		}

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}