<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
 */

$route['404_override']                          = 'home/index';
$route['default_controller']                    = "login";
$route['home']                                  = "home/index";
$route['logout']                                = "login/logout";
$route['information']                           = "login/information";
$route['active-product']                        = "product/active";
$route['active-product/(:any)']                 = "product/active/$1";
$route['product-in-view']                       = "product/product_in_view";
$route['product-in-view/(:any)']                = "product/product_in_view/$1";
$route['save-criteria']                         = "product/save_criteria";
$route['promotion']                             = "promotion/index";
$route['promotion/(:any)']                      = "promotion/index/$1";
$route['promotion-detail']                      = "promotion/new_promotion";
$route['promotion-detail/(:any)']               = "promotion/new_promotion/$1";
$route['promotion-detail/(:any)/(:any)']        = "promotion/new_promotion/$1/$2";
$route['create-promotion']                      = "promotion/create_promotion";
$route['create-promotion/(:any)']               = "promotion/create_promotion/$1";
$route['create-promotion/(:any)/(:any)']        = "promotion/create_promotion/$1/$2";
$route['create-promotion/(:any)/(:any)/(:any)'] = "promotion/create_promotion/$1/$2/$3";
$route['inactive-product']                      = "product/inactive";
$route['inactive-product/(:any)']               = "product/inactive/$1";
$route['out-of-stock-product']                  = "product/out_of_stock";
$route['out-of-stock-product/(:any)']           = "product/out_of_stock/$1";
$route['update-stock/(:any)/(:any)']            = "product/update_stock/$1/$2";
$route['order/(:any)']                          = "order/index/$1";
$route['order-cancel']                          = "order/order_cancel";
$route['order-cancel/(:any)']                   = "order/order_cancel/$1";
$route['order-complete']                        = "order/order_complete";
$route['order-complete/(:any)']                 = "order/order_complete/$1";
$route['product-detail']                        = "product/product_detail/";
$route['product-detail/(:any)']                 = "product/product_detail/$1";
$route['get-advance-field']                     = "product/get_advance_field/";
$route['get-option-field']                      = "product/get_option_field/";
$route['get-variant-field']                     = "product/get_variant_field/";
$route['remove-image']                          = "product/remove_image/";
$route['remove-variant-image']                  = "product/remove_variant_image/";
$route['update-order/(:any)/(:any)']            = "order/update_order/$1/$2";
$route['get-order-field']                       = "order/get_order_field/";
$route['order-detail/(:any)']                   = "order/order_detail/$1";
$route['get-variant']                           = "product/get_variant";
$route['get-attribute']                         = "product/get_attribute";
$route['update-promotion']                      = "promotion/update_promotion";
$route['product-report']                        = "report/index";
$route['product-report/(:any)']                 = "report/index/$1";
$route['sale-report']                           = "report/sale";
$route['sale-report/(:any)']                    = "report/sale/$1";
$route['category']                              = "category/index";
$route['category/(:any)']                       = "category/index/$1";
$route['category-detail']                       = "category/category_detail";
$route['category-detail/(:any)']                = "category/category_detail/$1";
$route['sub-category']                          = "category/sub_category";
$route['sub-category/(:any)']                   = "category/sub_category/$1";
$route['sub-category-detail']                   = "category/sub_category_detail";
$route['sub-category-detail/(:any)']            = "category/sub_category_detail/$1";
$route['attribute']                             = "category/attribute";
$route['attribute/(:any)']                      = "category/attribute/$1";
$route['attribute-detail']                      = "category/attribute_detail";
$route['attribute-detail/(:any)']               = "category/attribute_detail/$1";
$route['criteria']                              = "category/criteria";
$route['criteria/(:any)']                       = "category/criteria/$1";
$route['criteria-detail']                       = "category/criteria_detail";
$route['criteria-detail/(:any)']                = "category/criteria_detail/$1";
$route['get-category']                          = "category/get_category/";
$route['active-supplier']                       = "supplier/index";
$route['active-supplier/(:any)']                = "supplier/index/$1";
$route['inactive-supplier']                     = "supplier/inactive_supplier";
$route['inactive-supplier/(:any)']              = "supplier/inactive_supplier/$1";
$route['supplier-detail']                       = "supplier/supplier_detail";
$route['supplier-detail/(:any)']                = "supplier/supplier_detail/$1";
$route['delete-warehouse']                      = "supplier/delete_warehouse";
$route['update-warehouse']                      = "supplier/update_warehouse";
$route['configuration']                         = "config/index";
$route['add-shipping']                          = "config/add_shipping";
$route['update-shipping']                       = "config/update_shipping";
$route['get-promotion-field']                   = "promotion/get_promotion_field";
$route['get-gift']                              = "promotion/get_gift";
$route['delete-item']                           = "promotion/delete_item";
$route['customer']                              = "customer/index";
$route['customer/(:any)']                       = "customer/index/$1";
$route['customer-detail/(:any)']                = "customer/detail/$1";
$route['voucher']                               = "promotion/voucher";
$route['voucher/(:any)']                        = "promotion/voucher/$1";
$route['voucher-detail']                        = "promotion/voucher_detail";
$route['voucher-detail/(:any)']                 = "promotion/voucher_detail/$1";
$route['news']                                  = "news/index";
$route['news/(:any)']                           = "news/index/$1";
$route['news-detail']                           = "news/detail";
$route['news-detail/(:any)']                    = "news/detail/$1";
$route['brand']                                 = "brand/index";
$route['edit-brand/(:num)']                     = "brand/edit_brand";
$route['add-brand']                             = "brand/add_brand";
$route['print-order-detail/(:any)']             = "order/print_order_detail/$1";
$route['supplier/checkemailexist']              = "supplier/checkemailexist";

$route['test-mail-template']       = "config/test_mail_template";
$route['new-order-admin']          = "config/new_order_admin";
$route['new-order-customer']       = "config/new_order_customer";
$route['create-new-customer']      = "config/create_new_customer";
$route['forgot-password-customer'] = "config/forgot_password_customer";
$route['forgot-password-admin']    = "config/forgot_password_admin";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
