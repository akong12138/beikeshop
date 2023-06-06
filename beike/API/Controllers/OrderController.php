<?php
/**
 * OrderController.php
 *
 * @copyright  2023 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2023-08-14 17:54:20
 * @modified   2023-08-14 17:54:20
 */

namespace Beike\API\Controllers;

use App\Http\Controllers\Controller;
use Beike\Repositories\OrderRepo;
use Beike\Shop\Http\Resources\Account\OrderDetailList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $customer = current_customer();
        if (empty($customer)) {
            return json_success(trans('common.get_success'));
        }

        try {
            $filters = [
                'customer' => $customer,
                'status'   => $request->get('status'),
            ];
            $orders = OrderRepo::filterOrders($filters);

            return OrderDetailList::collection($orders);
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    public function show()
    {

    }
}
