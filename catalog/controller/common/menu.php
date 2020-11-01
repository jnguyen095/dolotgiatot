<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

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

					// Level 3
                    $children_data3 = array();
                    $children3 = $this->model_catalog_category->getCategories($child['category_id']);
                    foreach ($children3 as $child3) {
                        $children_data3[] = array(
                            'name'  => $child3['name'],
                            'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' .$child3['category_id'] , true)
                        );
                    }

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'], true),
                        'children' => $children_data3
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'], true)
				);
			}
		}

		return $this->load->view('common/menu', $data);
	}
}
