<?php
class ControllerProductNew extends Controller {
    public function index() {
        // Optional. This calls for your language file
        $this->load->language('product/new');

        // Optional. Set the title of your web page
        $this->document->setTitle($this->language->get('heading_title'));

        // Breadcrumbs for the page
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('product/new')
        );

        // Get "heading_title" from language file
        $data['heading_title'] = $this->language->get('heading_title');

        // All the necessary page elements
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $filter_data = array(
            'sort'  => 'p.date_added',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 10,
        );

        $data['products'] = $this->model_catalog_product->getProducts($filter_data);
        // Load the template file and show output
        $this->response->setOutput($this->load->view('product/new', $data));
    }
}