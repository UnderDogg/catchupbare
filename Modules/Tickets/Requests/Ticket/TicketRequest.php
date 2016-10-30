<?php

namespace Modules\Core\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * TicketRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class TicketRequest extends Request
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
            // 'To' => 'required',
            'ticket_ID'     => 'required',
            'reply_content' => 'required',
        ];
    }
}
