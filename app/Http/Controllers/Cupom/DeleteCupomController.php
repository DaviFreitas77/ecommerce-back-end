<?php

namespace App\Http\Controllers\Cupom;

use App\Http\Controllers\Controller;
use App\Http\Services\CupomService;
use Dedoc\Scramble\Attributes\Group;



#[Group('Cupom')]
class DeleteCupomController extends Controller
{
    /**
     * Delete cupom
     */

    public function __construct(private CupomService $cupomService)
    {
        $this->cupomService = $cupomService;
    }

    public function __invoke($id)
    {
        return $this->cupomService->deleteCupom($id);
    }
}