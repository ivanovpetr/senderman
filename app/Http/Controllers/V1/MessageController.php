<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Rules\MessengersArray;
use App\Rules\ReceiversArray;
use App\Services\MessageManager;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MessageController extends Controller
{

    /**
     * Queue message manage
     *
     * @var MessageManager
     */
    private $messageManager;

    /**
     * MessageController constructor.
     */
    public function __construct(MessageManager $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * Validate request data and process data to queue manager
     *
     * @param Request $request
     * @return Response

     */
    public function sendMessages(Request $request): Response
    {
        //валидация полей
        $rules =  [
            'time' => 'nullable|date_format:"d-m-Y H:i"',
            'timezone' => 'required_with:time|timezone',
            'message' => 'required',
            'messengers' => ['required','array',new MessengersArray],
            'receivers' => ['required','array',new ReceiversArray(app('libphonenumber'))]
        ];
        $validator = app('validator')->make($request->all(),$rules);
        if($validator->fails()){
            throw new \Dingo\Api\Exception\ResourceException('Invalid input',$validator->errors());
        }

        $time = ($request->input('time'))? new Carbon($request->time, $request->timezone) : null;
        foreach ($request->receivers as $receiver){
            $this->messageManager->enqueueMessage($request->message,$receiver,$request->messengers,$time);
        }
        return $this->response->created();

    }
}