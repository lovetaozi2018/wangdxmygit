<?php

namespace App\Http\ViewComposers;

use App\Helpers\ModelTrait;

use App\Models\Teacher;
use Illuminate\Contracts\View\View;

class SquadComposer {

    use ModelTrait;

    public function compose(View $view) {

        $data = Teacher::with('user')
            ->where('school_id', 1)
            ->get()->toArray();
        $teachers = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $teachers[$v['id']] = $v['user']['realname'];
            }
        }
        $view->with([
            'teachers' => $teachers,
            'uris' => $this->uris()
        ]);

    }

}