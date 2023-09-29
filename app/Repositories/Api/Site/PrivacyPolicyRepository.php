<?php
declare(strict_types=1);

namespace App\Repositories\Api\Site;

use App\Repositories\CoreRepository;
use App\Models\PrivacyPolicy as Model;
use Illuminate\Support\Facades\DB;

class PrivacyPolicyRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string the name of the privacy policy
     */
    public function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @return int
     */
    protected function getLastId(): int
    {
        try {
            return $this->startConditions()->latest()->first()->id;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * @return string|array
     */
    public function getPrivacyPolicy(): string|array
    {
        $id = $this->getLastId();

        if ($id) {
            try {
                return $this->startConditions()->find($id)->privacy_policy;
            } catch (\Exception $e) {
                return ['error' => $e->getMessage()];
            }
        } else {
            return '';
        }
    }

    public function savePrivacyPolicy($request): int|array
    {
        $result = 0;
        $id = $this->getLastId();

        if ($id) {
            try {
                DB::beginTransaction();
                $result = $this->startConditions()->whereId($id)->update(['privacy_policy' => $request->privacy_policy]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $result = ['error' => $e->getMessage()];
            }
        } else {
            try {
                DB::beginTransaction();
                $result = $this->startConditions()->create(['privacy_policy' => $request->privacy_policy])->id;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $result = ['error' => $e->getMessage()];
            }
        }

        return $result;
    }
}
