<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Requests\Account\CreateAccountRequest;
use App\Repositories\CoreRepository;
use App\Models\User as Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @param CreateAccountRequest $request
     * @return Model|array
     */
    public function createAccount(CreateAccountRequest $request): Model|array
    {
        $result = null;

        try {
            DB::beginTransaction();
            $result = $this->startConditions()->create([
                'person_id' => $request->person_id,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getAccount(int $id): Collection
    {
        return $this->startConditions()->with(['person'])->where('id', $id)->get();
    }

    /**
     * @param int $idPerson
     * @return Collection
     */
    public function getAccountList(int $idPerson): Collection
    {
        return $this->startConditions()
            ->where('person_id',$idPerson)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @param int $id
     * @return int|array
     */
    public function deleteAccount(int $id): int|array
    {
        $result = null;

        try {
            DB::beginTransaction();
            $result = $this->startConditions()->destroy($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @param $request
     * @return Model|array
     */
    public function updateAccount($request): int|array
    {
        $result = null;

        try {
            $updateFields = [
                'email' => $request->email,
                'role' => $request->role,
                'is_active' => $request->is_active
            ];

            if ($request->password) {
                $updateFields['password'] = Hash::make($request->password);
            }

            DB::beginTransaction();
            $result = $this->startConditions()
                ->whereId($request->id)
                ->update($updateFields);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }
}
