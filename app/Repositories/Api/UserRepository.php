<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Requests\User\CreateUserRequest;
use App\Repositories\CoreRepository;
use App\Models\User as Model;
use Illuminate\Support\Collection;

class UserRepository extends CoreRepository
{
    private array $notUpdateFields = [
        'confirm_password',
        'created_at',
        'updated_at',
    ];

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
     * @param CreateUserRequest $request
     * @return Model|array
     */
    public function createUser(CreateUserRequest  $request): Model | array
    {
        try {
            return $this->startConditions()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getUser(int $id): Model
    {
        return $this->startConditions()->find($id);
    }

    /**
     * @return Collection
     */
    public function getUsersList(): Collection
    {
        return $this->startConditions()->all();
    }

    /**
     * @param int $id
     * @return int|array
     */
    public function deleteUser(int $id): int | array
    {
        try {

            return $this->startConditions()->destroy($id);

        } catch (\Exception $exception) {
            return [
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function updateUser($request): Model | array
    {
        $updateFields = [];

        foreach ($request->all() as $key=>$value) {
            if (!in_array($key, $this->notUpdateFields) && !is_null($value)) {
                $updateFields[$key] = $value;
            }
        }

        try {
            $user = $this->getUser($request->id);

            if ($user->update($updateFields)) {
                return $user;
            }

            return [
                'error' => 'error update user',
            ];
        } catch (\Exception $exception) {
            return [
                'error' => $exception->getMessage(),
            ];
        }
    }
}
