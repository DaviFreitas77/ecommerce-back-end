<?php

namespace App\Http\Controllers\Cupom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cupom\StoreCupomRequest;
use App\Http\Services\CupomService;
use Dedoc\Scramble\Attributes\Group;

#[Group('Cupom')]
class CreateCupomController extends Controller
{
    /**
     * Create cupom
     */

    public function __construct(private CupomService $cupomService)
    {
        $this->cupomService = $cupomService;
    }

    public function __invoke(StoreCupomRequest $request)
    {
        $data = $request->validated();
        return $this->cupomService->createCupom($data);
    }
}