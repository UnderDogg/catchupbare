<?php

namespace Modules\Core\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * CreateTicketRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class CreateTicketRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'email'     => 'required|email',
            'fullname'  => 'required|min:3',
            'helptopic' => 'required',
            // 'dept' => 'required',
            'sla'      => 'required',
            'subject'  => 'required|min:5',
            'body'     => 'required|min:20',
            'priority' => 'required',
        ];
    }
}
