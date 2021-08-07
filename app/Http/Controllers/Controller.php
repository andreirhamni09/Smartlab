<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="8.0.0",
 *      title="SMARTLAB API",
 *      description="LIST API SMARTLAB",
 *      @OA\Contact(
 *          email="darius@matulionis.lt"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

 /**
 *  @OA\Server(
 *      url="https://slab.srs-ssms.com/api/admin",
 *      description="L5 Swagger OpenApi Server"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
