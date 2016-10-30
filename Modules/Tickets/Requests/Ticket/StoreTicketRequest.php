<?php
namespace Modules\Tickets\Http\Requests\Ticket;

use App\Http\Requests\Request;

class StoreTicketRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('ticket-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'status_id' => 'required',
            'assigned_to_staff_id' => 'required',
            'fk_staff_id_created' => '',
            'fk_relation_id' => '',
            'deadline' => ''
        ];
    }
}
