<?php namespace App\Repositories;

use App\Models\Audit;
use App\Models\Setting;
use Bosnadev\Repositories\Eloquent\Repository;

class AuditRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Audit';
    }

    /**
     * @param $staff_id
     * @param $category
     * @param $message
     * @param array $attributes
     * @param null $data_parser
     * @param null $replay_route
     * @return bool|static
     */
    public static function log($staff_id, $category, $message, Array $attributes = null, $data_parser = null, $replay_route = null)
    {

        $audit_enabled = (new Setting())->get('audit.enabled');
        $audit = false;
        $attJson = null;

        if ($audit_enabled) {
            // Remove from array attributes that we do not want to save.
            unset($attributes['_method']);
            unset($attributes['_token']);
            unset($attributes['password']);
            unset($attributes['password_confirmation']);

            if ($attributes) {
                $attJson = json_encode($attributes);
            }

            $audit = Audit::create([
                "staff_id" => $staff_id,
                "category" => $category,
                "message" => $message,
                "data" => $attJson,
                "data_parser" => $data_parser,
                "replay_route" => $replay_route,
            ]);
        }

        return $audit;
    }
}
