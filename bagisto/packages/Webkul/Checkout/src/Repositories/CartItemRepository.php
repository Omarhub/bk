<?php

namespace Webkul\Checkout\Repositories;

use Webkul\Core\Eloquent\Repository;

/**
 * Cart Items Reposotory
 *
 * @author    Prashant Singh <prashant.singh852@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */

class CartItemRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Webkul\Checkout\Contracts\CartItem';
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */

    public function update(array $data, $id, $attribute = "id")
    {
        $cartitems = $this->find($id);

        $cartitems->update($data);

        return $cartitems;
    }

    public function getProduct($cartItemId) {
        return $this->model->find($cartItemId)->product->id;
    }
}