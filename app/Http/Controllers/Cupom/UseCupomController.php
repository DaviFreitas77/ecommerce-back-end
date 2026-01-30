<?php

namespace App\Http\Controllers\Cupom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cupom\UseCupomRequest;
use App\Http\Services\CupomService;
use Dedoc\Scramble\Attributes\Group;


#[Group('Cupom')]
class UseCupomController extends Controller
{
    /**
     * Use cupom
     */
    public function __construct(private CupomService $cupomService)
    {
        $this->cupomService = $cupomService;
    }

    public function __invoke(UseCupomRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        return $this->cupomService->useCupom($data,$user);
    }
}