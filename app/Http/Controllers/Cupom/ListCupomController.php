<?php

namespace App\Http\Controllers\Cupom;

use App\Http\Controllers\Controller;
use App\Http\Services\CupomService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;


#[Group('Cupom')]
class ListCupomController extends Controller
{
    /**
     * List all cupoms
     */
    public function __construct(private CupomService $cupomService)
    {
        $this->cupomService = $cupomService;
    }

    public function __invoke(Request $request)
    {
        return $this->cupomService->listAllCupom();
    }
}