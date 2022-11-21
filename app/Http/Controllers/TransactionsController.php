<?php

namespace App\Http\Controllers;

use App\Models\MasterFlagBit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationResult;
use ReflectionClass;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * @note could be in other controller but for simplicity been kept here
     *
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {

        /**
         * validate request parameters
         */
        $validate = $this->validateRequestParams();
        /**
         * return error message if request payload is not valid
         */
        if(!$validate->passes()) {
            $validateMessages = $validate->messages();
            return response()->json([
                'message' => $validateMessages->all(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dataArray = [
            'datensatz_typ_id' => request('dataTypeId'),
            'datensatz_id' => request('dataId'),
            'flagbit' => request('flagbitId'),
            'zeitraum_id' => request('periodId'),
            'bearbeiter_id' => request('userId'),
        ];

         MasterFlagBit::upsert(
             $dataArray,
             [ 'flagbit_ref_id', 'flagbit', 'datensatz_id', 'datensatz_typ_id', 'bearbeiter_id'], // update if these columns existing in table
             [
                 'zeitraum_id',
                 'timestamp' => Carbon::now()->toDateTimeString()
             ]
         );

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $transactionId
     * @return JsonResponse
     */
    public function show(int $transactionId): JsonResponse
    {

        $user = auth()->user();
        /**
         * get all userTransactions
         */
        $userTransaction = $user->transactions()->where('trans_id', '=', $transactionId)->get();

        /**
         * if no transaction is found for user
         */
        if($userTransaction->count() < 1) {
            return response()->json([
                'flags' =>  []
            ]);
        }

        /**
         * fetch DataFlag::constants as array
         */
        $dataFlag = new ReflectionClass('App\Constants\DataFlag');
        $flags = [];
        /**
         * map Transactions flag to DataFlag::constants
         */
        $userTransaction->first()->flagBits->each(function($flag) use($dataFlag, &$flags){
            $flags[] = array_flip($dataFlag->getConstants())[$flag->flagbit];
        });

        return response()->json([
            'flags' => array_unique($flags) ?? []
        ]);
    }

    /**
     * @note could be in other controller but for simplicity been kept here
     *
     * Remove the specified resource from storage.
     *
     * @param int $flagbitRefId
     * @return JsonResponse
     */
    public function destroy(int $flagbitRefId): JsonResponse
    {
        /**
         * skip if user has no master key
         */
        if (!auth()->user()->isMaster()) {
            return response()->json([], Response::HTTP_FORBIDDEN);
        }
        /**
         * 1 - find the flagRef
         * 2 - remove it
         */
        try {
            $flagRef = MasterFlagBit::findOrFail($flagbitRefId);
            $flagRef->delete();
        }  catch(ModelNotFoundException $e) {
            /**
             * return error message if flagRef not found.
             */
            return response()->json(['message' => 'Entity not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    protected function validateRequestParams(): ValidationResult
    {

        $rules = [
            'dataTypeId' => 'required|integer|between:1,28',
            'dataId' => 'required|integer',
            'flagbitId' => 'required|integer|between:1,13',
            'periodId' => 'required|integer|exists:App\Models\PeriodSpecification,zeitraum_id',
            'userId' => 'required|exists:App\Models\User,id',
        ];

        $messages = [
            'dataTypeId.between' => 'There is no dataType with this id in database.',
            'dataTypeId.required' => 'dataType must be provided as parameter.',
            'dataId.integer' => 'dataId should be integer.',
            'dataId.required' => 'dataId must be provided as parameter.',
            'flagbitId.exists' => 'There is no flagBitId with this id in database.',
            'flagbitId.required' => 'flagBitId must be provided as parameter.',
            'periodId.exists' => 'There is no period with this id in database.',
            'periodId.required' => 'periodId must be provided as parameter.',
            'userId.exists' => 'There is no User with this id in database.',
            'userId.required' => 'userID must be provided as parameter.',
        ];

        return  Validator::make(request()->all() ?? [], $rules, $messages);
    }
}
